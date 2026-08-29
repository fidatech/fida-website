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
        $prepared = ['featured' => $this->boolean('featured')];

        if ((string) $this->input('type') === 'case-study') {
            $metadata = (array) $this->input('metadata', []);

            foreach (array_keys(ContentPage::CASE_STUDY_EVIDENCE_CHECKS) as $key) {
                data_set($metadata, "case_study.{$key}", $this->boolean("metadata.case_study.{$key}"));
            }

            $prepared['metadata'] = $metadata;
        }

        $this->merge($prepared);
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
            'sitemap_included' => ['sometimes', 'boolean'],
            'sitemap_priority' => ['nullable', 'numeric', 'between:0.1,1.0'],
            'sitemap_change_frequency' => ['nullable', Rule::in(array_keys(config('website.sitemap.change_frequencies')))],
            'sitemap_last_modified_at' => ['nullable', 'date'],
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
            'metadata.cta' => ['nullable', 'array'],
            'metadata.cta.heading' => ['nullable', 'array'],
            'metadata.cta.heading.*' => ['nullable', 'string', 'max:190'],
            'metadata.cta.description' => ['nullable', 'array'],
            'metadata.cta.description.*' => ['nullable', 'string', 'max:500'],
            'metadata.cta.primary_label' => ['nullable', 'array'],
            'metadata.cta.primary_label.*' => ['nullable', 'string', 'max:120'],
            'metadata.cta.primary_intent' => ['nullable', Rule::in(array_keys(config('website.lead_intents')))],
            'metadata.cta.secondary_label' => ['nullable', 'array'],
            'metadata.cta.secondary_label.*' => ['nullable', 'string', 'max:120'],
            'metadata.cta.secondary_intent' => ['nullable', Rule::in(array_keys(config('website.lead_intents')))],
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
            'metadata.case_study' => ['nullable', 'array'],
            'metadata.case_study.client_identity_confirmed' => ['nullable', 'boolean'],
            'metadata.case_study.publication_permission_recorded' => ['nullable', 'boolean'],
            'metadata.case_study.implementation_scope_verified' => ['nullable', 'boolean'],
            'metadata.case_study.visual_assets_approved' => ['nullable', 'boolean'],
            'metadata.case_study.outcomes_evidence_verified' => ['nullable', 'boolean'],
            'metadata.case_study.final_client_approval_recorded' => ['nullable', 'boolean'],
            'metadata.case_study.evidence_owner' => ['nullable', 'string', 'max:120'],
            'metadata.case_study.approval_reference' => ['nullable', 'string', 'max:190'],
            'metadata.case_study.approved_at' => ['nullable', 'date'],
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

                if ((string) $this->input('type') === 'case-study' && (string) $this->input('status') === 'published') {
                    foreach (ContentPage::CASE_STUDY_EVIDENCE_CHECKS as $key => $label) {
                        if (! $this->boolean("metadata.case_study.{$key}")) {
                            $validator->errors()->add("metadata.case_study.{$key}", $label);
                        }
                    }

                    foreach (['evidence_owner', 'approval_reference', 'approved_at'] as $field) {
                        if (! $this->filled("metadata.case_study.{$field}")) {
                            $validator->errors()->add(
                                "metadata.case_study.{$field}",
                                'Complete the internal approval record before publishing a case study.',
                            );
                        }
                    }

                    foreach (array_keys(config('website.locales')) as $locale) {
                        foreach (['title', 'summary', 'body', 'meta_title', 'meta_description', 'primary_query'] as $field) {
                            if (! $this->filled("{$field}.{$locale}")) {
                                $validator->errors()->add(
                                    "{$field}.{$locale}",
                                    'Complete every case-study language before publication.',
                                );
                            }
                        }
                    }
                }
            },
        ];
    }
}
