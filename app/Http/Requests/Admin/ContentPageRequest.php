<?php

namespace App\Http\Requests\Admin;

use App\Models\ContentPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'type' => ['required', Rule::in(['solution', 'service', 'industry', 'case-study', 'article', 'page'])],
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
            'status' => ['required', Rule::in(['draft', 'published'])],
            'featured' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
