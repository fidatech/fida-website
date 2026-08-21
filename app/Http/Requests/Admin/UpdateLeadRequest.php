<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->allows('leads.manage') === true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['new', 'contacted', 'qualified', 'proposal', 'won', 'lost', 'spam'])],
            'assigned_to' => ['nullable', 'integer', Rule::exists('users', 'id')->where('active', true)],
        ];
    }
}
