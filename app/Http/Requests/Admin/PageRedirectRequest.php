<?php

namespace App\Http\Requests\Admin;

use App\Models\PageRedirect;
use App\Support\PageRedirects;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class PageRedirectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->allows('content.manage') === true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'source_path' => PageRedirects::normalize((string) $this->input('source_path')),
            'target_path' => PageRedirects::normalize((string) $this->input('target_path')),
            'active' => $this->boolean('active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'source_path' => [
                'required',
                'string',
                'max:255',
                'regex:#^/[a-zA-Z0-9/_-]*$#',
                Rule::unique(PageRedirect::class)->ignore($this->route('pageRedirect')),
            ],
            'target_path' => ['required', 'string', 'max:255', 'regex:#^/[a-zA-Z0-9/_-]*$#'],
            'status_code' => ['required', Rule::in([301, 308])],
            'active' => ['required', 'boolean'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($this->input('source_path') === '/') {
                    $validator->errors()->add('source_path', 'The homepage cannot be used as a redirect source.');
                }

                if ($this->input('source_path') === $this->input('target_path')) {
                    $validator->errors()->add('target_path', 'Redirect source and target must be different.');
                }

                if (str_starts_with((string) $this->input('source_path'), '/admin')) {
                    $validator->errors()->add('source_path', 'Admin paths cannot be redirected.');
                }
            },
        ];
    }
}
