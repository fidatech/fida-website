<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRfqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization' => ['required', 'string', 'max:190'],
            'organization_type' => ['required', Rule::in(['government', 'ngo', 'ingo', 'donor', 'bank', 'enterprise', 'other'])],
            'contact_name' => ['required', 'string', 'max:120'],
            'job_title' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'phone' => ['nullable', 'string', 'min:7', 'max:40'],
            'procurement_type' => ['required', Rule::in(['software-erp', 'web-mobile', 'ai-iot', 'data-center', 'network', 'cloud-servers', 'cybersecurity', 'hardware-supply', 'systems-integration', 'managed-services', 'mixed'])],
            'project_title' => ['required', 'string', 'max:220'],
            'submission_deadline' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:160'],
            'budget' => ['nullable', 'string', 'max:80'],
            'requirements' => ['required', 'string', 'min:40', 'max:8000'],
            'documents' => ['nullable', 'array', 'max:5'],
            'documents.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:10240'],
            'locale' => ['nullable', Rule::in(array_keys(config('website.locales', [])))],
            'source_url' => ['nullable', 'url', 'max:2048'],
            'website' => ['prohibited'],
        ];
    }
}
