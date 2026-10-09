<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRfqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->allows('leads.manage') ?? false;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['new', 'reviewing', 'clarification', 'qualified', 'quoted', 'submitted', 'won', 'lost', 'archived'])],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'internal_notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
