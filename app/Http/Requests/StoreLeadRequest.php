<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email:rfc', 'max:190', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'min:7', 'max:30', 'required_without:email'],
            'company' => ['nullable', 'string', 'max:190'],
            'project_type' => ['required', Rule::in(['erp', 'accounting', 'mobile', 'website', 'saas', 'ai-automation', 'iot', 'data-center', 'network', 'cloud-servers', 'cybersecurity', 'hardware-supply', 'systems-integration', 'managed-services', 'tender', 'company-profile', 'other'])],
            'budget' => ['nullable', Rule::in(['under-1000', '1000-3000', '3000-10000', '10000-plus', 'not-sure'])],
            'message' => ['required', 'string', 'min:20', 'max:3000'],
            'locale' => ['nullable', Rule::in(array_keys(config('website.locales', [])))],
            'source_url' => ['nullable', 'url', 'max:2048'],
            'interest_slug' => ['nullable', 'string', 'max:190', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'utm_source' => ['nullable', 'string', 'max:100'],
            'utm_medium' => ['nullable', 'string', 'max:100'],
            'utm_campaign' => ['nullable', 'string', 'max:150'],
            'website' => ['prohibited'],
        ];
    }
}
