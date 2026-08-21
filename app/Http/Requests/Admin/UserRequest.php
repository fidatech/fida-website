<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->allows('users.manage') === true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->boolean('active'),
        ]);
    }

    public function rules(): array
    {
        $existing = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', Rule::unique(User::class)->ignore($existing)],
            'role' => ['required', Rule::in(['super_admin', 'editor', 'sales'])],
            'active' => ['required', 'boolean'],
            'password' => [
                Rule::requiredIf(! $existing),
                'nullable',
                'confirmed',
                Password::min(12)->letters()->mixedCase()->numbers(),
            ],
        ];
    }
}
