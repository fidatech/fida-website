<?php

namespace App\Http\Requests\Admin;

use App\Models\ContentPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ContentPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->allows('content.manage') === true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'featured' => $this->boolean('featured'),
        ]);
    }

    public function rules(): array
    {
        $safeHtml = function (string $attribute, mixed $value, \Closure $fail): void {
            if (is_string($value) && preg_match('/<\s*(script|iframe|object|embed)\b|on\w+\s*=|javascript\s*:/i', $value)) {
                $fail('Unsafe HTML is not allowed.');
            }
        };

        return [
            'type' => ['required', Rule::in(array_keys(config('website.content_types')))],
            'article_category_id' => ['nullable', Rule::exists('article_categories', 'id')],
            'article_author_id' => ['nullable', Rule::exists('article_authors', 'id')],
            'slug' => [
                'required',
                'string',
                'max:190',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique(ContentPage::class)->ignore($this->route('contentPage')),
            ],
            'title' => ['required', 'array'],
            'title.en' => ['required', 'string', 'max:190'],
            'title.fa' => ['nullable', 'string', 'max:190'],
            'title.ps' => ['nullable', 'string', 'max:190'],
            'eyebrow' => ['nullable', 'array'],
            'eyebrow.*' => ['nullable', 'string', 'max:190'],
            'summary' => ['nullable', 'array'],
            'summary.*' => ['nullable', 'string', 'max:1000'],
            'body' => ['nullable', 'array'],
            'body.*' => ['nullable', 'string', 'max:60000', $safeHtml],
            'meta_title' => ['nullable', 'array'],
            'meta_title.*' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'array'],
            'meta_description.*' => ['nullable', 'string', 'max:320'],
            'primary_query' => ['nullable', 'array'],
            'primary_query.*' => ['nullable', 'string', 'max:190'],
            'search_intent' => ['nullable', Rule::in(array_keys(config('website.discovery.search_intents')))],
            'robots_directive' => ['nullable', Rule::in(array_keys(config('website.discovery.robots')))],
            'social_image_url' => ['nullable', 'url:http,https', 'max:2048'],
            'author_name' => ['nullable', 'string', 'max:120'],
            'reviewer_name' => ['nullable', 'string', 'max:120'],
            'reviewed_at' => ['nullable', 'date'],
            'metadata' => ['nullable', 'array'],
            'metadata.related_slugs' => ['nullable', 'array', 'max:8'],
            'metadata.related_slugs.*' => ['nullable', 'string', 'distinct', Rule::exists('content_pages', 'slug')],
            'metadata.faqs' => ['nullable', 'array', 'max:6'],
            'metadata.faqs.*.question' => ['nullable', 'array'],
            'metadata.faqs.*.question.*' => ['nullable', 'string', 'max:320'],
            'metadata.faqs.*.answer' => ['nullable', 'array'],
            'metadata.faqs.*.answer.*' => ['nullable', 'string', 'max:1500'],
            'metadata.service' => ['nullable', 'array'],
            'metadata.service.engagement' => ['nullable', 'array'],
            'metadata.service.engagement.*' => ['nullable', 'string', 'max:240'],
            'metadata.service.delivery' => ['nullable', 'array'],
            'metadata.service.delivery.*' => ['nullable', 'string', 'max:240'],
            'metadata.service.handover' => ['nullable', 'array'],
            'metadata.service.handover.*' => ['nullable', 'string', 'max:240'],
            'metadata.service.capabilities' => ['nullable', 'array', 'max:8'],
            'metadata.service.capabilities.*' => ['nullable', 'array'],
            'metadata.service.capabilities.*.*' => ['nullable', 'string', 'max:190'],
            'metadata.product' => ['nullable', 'array'],
            'metadata.product.code' => ['nullable', 'string', 'max:24'],
            'metadata.product.accent' => ['nullable', 'regex:/^#[0-9a-f]{6}$/i'],
            'metadata.product.category' => ['nullable', 'array'],
            'metadata.product.category.*' => ['nullable', 'string', 'max:190'],
            'metadata.product.platform' => ['nullable', 'array'],
            'metadata.product.platform.*' => ['nullable', 'string', 'max:190'],
            'metadata.product.deployment' => ['nullable', 'array'],
            'metadata.product.deployment.*' => ['nullable', 'string', 'max:190'],
            'metadata.product.status' => ['nullable', 'array'],
            'metadata.product.status.*' => ['nullable', 'string', 'max:190'],
            'metadata.product.features' => ['nullable', 'array', 'max:10'],
            'metadata.product.features.*' => ['nullable', 'array'],
            'metadata.product.features.*.*' => ['nullable', 'string', 'max:190'],
            'status' => ['required', Rule::in(['draft', 'review', 'published'])],
            'featured' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                foreach ((array) $this->input('metadata.faqs', []) as $index => $faq) {
                    foreach (array_keys(config('website.locales')) as $locale) {
                        $question = trim((string) data_get($faq, "question.{$locale}"));
                        $answer = trim((string) data_get($faq, "answer.{$locale}"));

                        if (($question === '') !== ($answer === '')) {
                            $validator->errors()->add(
                                "metadata.faqs.{$index}.question.{$locale}",
                                'Each FAQ needs both a question and an answer in the same language.',
                            );
                        }
                    }
                }

                if ((string) $this->input('type') !== 'article'
                    && ($this->filled('article_category_id') || $this->filled('article_author_id'))) {
                    $validator->errors()->add('type', 'Article categories and authors can only be assigned to articles.');
                }

                if (in_array((string) $this->input('slug'), (array) $this->input('metadata.related_slugs', []), true)) {
                    $validator->errors()->add('metadata.related_slugs', 'A page cannot link to itself as related content.');
                }
            },
        ];
    }
}
