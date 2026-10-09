<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRfqRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    protected function prepareForValidation(): void
    {
        $this->merge(['privacy_accepted' => $this->boolean('privacy_accepted')]);
    }

    public function rules(): array
    {
        $capabilityKeys = collect(config('website.featured_solutions', []))->pluck('key')->all();

        return [
            'website' => ['nullable', 'max:0'],
            'organization_name' => ['required','string','max:190'],
            'organization_type' => ['required', Rule::in(['government','ngo','ingo','un','donor','bank','telecom','private','other'])],
            'contact_name' => ['required','string','max:120'],
            'job_title' => ['nullable','string','max:120'],
            'email' => ['required','email','max:190'],
            'phone' => ['nullable','string','max:50'],
            'country' => ['nullable','string','max:100'],
            'city' => ['nullable','string','max:100'],
            'procurement_reference' => ['nullable','string','max:120'],
            'procurement_method' => ['required', Rule::in(['rfq','rfp','tender','eoi','direct'])],
            'submission_deadline' => ['nullable','date'],
            'capabilities' => ['required','array','min:1'],
            'capabilities.*' => ['required', Rule::in($capabilityKeys)],
            'budget_currency' => ['nullable', Rule::in(['USD','AFN','EUR'])],
            'budget_min' => ['nullable','numeric','min:0'],
            'budget_max' => ['nullable','numeric','gte:budget_min'],
            'delivery_location' => ['nullable','string','max:190'],
            'project_summary' => ['required','string','min:20','max:3000'],
            'scope_requirements' => ['required','string','min:20','max:15000'],
            'compliance_requirements' => ['nullable','string','max:5000'],
            'timeline' => ['nullable','string','max:190'],
            'document' => ['nullable','file','mimes:pdf,doc,docx,xls,xlsx,zip','max:15360'],
            'locale' => ['required', Rule::in(array_keys(config('website.locales')))],
            'source_url' => ['nullable','url','max:2048'],
            'utm_source' => ['nullable','string','max:100'],
            'utm_medium' => ['nullable','string','max:100'],
            'utm_campaign' => ['nullable','string','max:150'],
            'privacy_accepted' => ['accepted'],
        ];
    }
}
