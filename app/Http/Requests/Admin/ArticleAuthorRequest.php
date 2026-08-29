<?php

namespace App\Http\Requests\Admin;

use App\Models\ArticleAuthor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->allows('content.manage') === true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['active' => $this->boolean('active')]);
    }

    public function rules(): array
    {
        return [
            'slug' => [
                'required',
                'string',
                'max:190',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique(ArticleAuthor::class)->ignore($this->route('articleAuthor')),
            ],
            'name' => ['required', 'string', 'max:120'],
            'role' => ['nullable', 'array'],
            'role.*' => ['nullable', 'string', 'max:190'],
            'bio' => ['nullable', 'array'],
            'bio.*' => ['nullable', 'string', 'max:2000'],
            'avatar_url' => ['nullable', 'url:http,https', 'max:2048'],
            'active' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
