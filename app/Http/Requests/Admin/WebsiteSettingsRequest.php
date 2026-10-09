<?php

namespace App\Http\Requests\Admin;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WebsiteSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->allows('settings.manage') === true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'remove_logo' => $this->boolean('remove_logo'),
            'country_code' => strtoupper((string) $this->input('country_code')),
            'whatsapp' => preg_replace('/\D+/', '', (string) $this->input('whatsapp')),
            'remove_ai_api_key' => $this->boolean('remove_ai_api_key'),
            'lead_email_enabled' => $this->boolean('lead_email_enabled'),
        ]);
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:160'],
            'legal_name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:50'],
            'whatsapp' => ['required', 'regex:/^[0-9]{7,30}$/'],
            'address_line' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'country_code' => ['required', 'alpha', 'size:2'],
            'map_embed_url' => ['nullable', 'url:https', 'max:2048', $this->mapProviderRule()],
            'brand_name' => ['required', 'string', 'max:80'],
            'brand_tagline' => ['required', 'string', 'max:80'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048', 'dimensions:min_width=48,min_height=48,max_width=2400,max_height=2400'],
            'remove_logo' => ['required', 'boolean'],
            'theme' => ['required', Rule::in(array_keys(config('website.appearance.themes', [])))],
            'palette' => ['required', Rule::in([...array_keys(config('website.appearance.palettes', [])), 'custom'])],
            'primary_color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'secondary_color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'highlight_color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'ai_provider' => ['nullable', Rule::in(['gemini', 'openrouter'])],
            'ai_model' => ['nullable', 'string', 'max:120'],
            'ai_api_key' => ['nullable', 'string', 'max:500'],
            'remove_ai_api_key' => ['nullable', 'boolean'],
            'lead_email_enabled' => ['nullable', 'boolean'],
            'lead_email_recipient' => ['nullable', 'email', 'max:190'],
        ];
    }

    private function mapProviderRule(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail): void {
            if ($value === null || $value === '') {
                return;
            }

            $host = strtolower((string) parse_url((string) $value, PHP_URL_HOST));
            $path = strtolower((string) parse_url((string) $value, PHP_URL_PATH));
            $googleHost = $host === 'google.com' || str_ends_with($host, '.google.com');
            $openStreetMapHost = $host === 'openstreetmap.org' || str_ends_with($host, '.openstreetmap.org');

            parse_str((string) parse_url((string) $value, PHP_URL_QUERY), $query);
            $googleEmbed = str_starts_with($path, '/maps/embed')
                || (rtrim($path, '/') === '/maps' && strtolower((string) ($query['output'] ?? '')) === 'embed');

            $allowed = ($googleHost && $googleEmbed)
                || ($openStreetMapHost && str_starts_with($path, '/export/embed'));

            if (! $allowed) {
                $fail('Use a secure Google Maps or OpenStreetMap embed URL.');
            }
        };
    }
}
