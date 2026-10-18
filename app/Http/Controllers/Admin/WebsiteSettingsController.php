<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WebsiteSettingsRequest;
use App\Models\SiteSetting;
use App\Support\WebsiteSettings;
use App\Services\LeadNotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class WebsiteSettingsController extends Controller
{
    public function edit(WebsiteSettings $settings): View
    {
        return view('admin.settings.edit', [
            'settings' => $settings->formData(),
            'templates' => config('website.appearance.templates'),
            'themes' => config('website.appearance.themes'),
            'palettes' => config('website.appearance.palettes'),
            'aiSettings' => $this->aiSettings(),
            'leadNotificationSettings' => app(LeadNotificationService::class)->settings(),
        ]);
    }

    public function update(WebsiteSettingsRequest $request, WebsiteSettings $settings): RedirectResponse
    {
        $data = $request->validated();
        $current = $settings->formData();
        $logoPath = $current['logo_path'];
        $uploadedPath = null;

        if ($request->boolean('remove_logo')) {
            $logoPath = null;
        }

        if ($request->hasFile('logo')) {
            $uploadedPath = $request->file('logo')->store('branding', 'public');

            if (! is_string($uploadedPath)) {
                throw new RuntimeException('The logo could not be stored.');
            }

            $logoPath = $uploadedPath;
        }

        try {
            DB::transaction(function () use ($data, $logoPath, $current): void {
                $this->put(WebsiteSettings::GENERAL_KEY, 'general', [
                    'company_name' => trim($data['company_name']),
                    'legal_name' => trim($data['legal_name']),
                    'email' => strtolower(trim($data['email'])),
                    'phone' => trim($data['phone']),
                    'whatsapp' => $data['whatsapp'],
                    'address_line' => trim((string) ($data['address_line'] ?? '')),
                    'city' => trim($data['city']),
                    'country' => trim($data['country']),
                    'country_code' => strtoupper($data['country_code']),
                    'map_embed_url' => $data['map_embed_url'] ?? null,
                ]);
                $this->put(WebsiteSettings::BRANDING_KEY, 'branding', [
                    'brand_name' => trim($data['brand_name']),
                    'brand_tagline' => trim($data['brand_tagline']),
                    'logo_path' => $logoPath,
                ]);
                $this->put(WebsiteSettings::APPEARANCE_KEY, 'appearance', [
                    'template' => $data['template'],
                    'theme' => $data['theme'],
                    'palette' => $data['palette'],
                    'primary_color' => strtolower($data['primary_color']),
                    'secondary_color' => strtolower($data['secondary_color']),
                    'highlight_color' => strtolower($data['highlight_color']),
                    'admin_theme' => $data['admin_theme'] ?? $current['admin_theme'],
                    'admin_palette' => $data['admin_palette'] ?? $current['admin_palette'],
                    'admin_primary_color' => strtolower($data['admin_primary_color'] ?? $current['admin_primary_color']),
                    'admin_secondary_color' => strtolower($data['admin_secondary_color'] ?? $current['admin_secondary_color']),
                    'admin_highlight_color' => strtolower($data['admin_highlight_color'] ?? $current['admin_highlight_color']),
                ]);

                $existingAi = SiteSetting::query()->where('key', 'analytics.ai')->first();
                $existing = is_array($existingAi?->value) ? $existingAi->value : [];
                $encryptedKey = $existing['api_key'] ?? null;

                if (($data['remove_ai_api_key'] ?? false) === true) {
                    $encryptedKey = null;
                }

                if (filled($data['ai_api_key'] ?? null)) {
                    $encryptedKey = Crypt::encryptString(trim((string) $data['ai_api_key']));
                }

                SiteSetting::query()->updateOrCreate(
                    ['key' => 'analytics.ai'],
                    [
                        'group' => 'analytics',
                        'value' => [
                            'provider' => $data['ai_provider'] ?? ($existing['provider'] ?? 'gemini'),
                            'model' => trim((string) ($data['ai_model'] ?? '')),
                            'api_key' => $encryptedKey,
                        ],
                        'type' => 'json',
                        'is_public' => false,
                    ],
                );

                SiteSetting::query()->updateOrCreate(
                    ['key' => 'leads.notifications'],
                    [
                        'group' => 'leads',
                        'value' => [
                            'email_enabled' => (bool) ($data['lead_email_enabled'] ?? false),
                            'email_recipient' => strtolower(trim((string) ($data['lead_email_recipient'] ?? $data['email']))),
                        ],
                        'type' => 'json',
                        'is_public' => false,
                    ],
                );
            });
        } catch (Throwable $exception) {
            if ($uploadedPath !== null) {
                Storage::disk('public')->delete($uploadedPath);
            }

            throw $exception;
        }

        if ($current['logo_path'] !== null && $current['logo_path'] !== $logoPath) {
            Storage::disk('public')->delete($current['logo_path']);
        }

        return back()->with('success', 'Website settings updated.');
    }

    public function updateAdminAppearance(Request $request, WebsiteSettings $settings): JsonResponse
    {
        abort_unless($request->user()?->allows('settings.manage'), 403);

        $themes = config('website.appearance.themes', []);
        $palettes = config('website.appearance.palettes', []);
        $data = $request->validate([
            'theme' => ['required', 'string', \Illuminate\Validation\Rule::in(array_keys($themes))],
            'palette' => ['required', 'string', \Illuminate\Validation\Rule::in(array_keys($palettes))],
        ]);

        $current = $settings->formData();
        $setting = SiteSetting::query()->where('key', WebsiteSettings::APPEARANCE_KEY)->first();
        $appearance = is_array($setting?->value) ? $setting->value : [];

        $appearance['admin_theme'] = $data['theme'];
        $appearance['admin_palette'] = $data['palette'];
        $appearance['admin_primary_color'] = $palettes[$data['palette']]['primary'];
        $appearance['admin_secondary_color'] = $palettes[$data['palette']]['secondary'];
        $appearance['admin_highlight_color'] = $palettes[$data['palette']]['highlight'];

        $appearance += [
            'theme' => $current['theme'],
            'palette' => $current['palette'],
            'primary_color' => $current['primary_color'],
            'secondary_color' => $current['secondary_color'],
            'highlight_color' => $current['highlight_color'],
        ];

        $this->put(WebsiteSettings::APPEARANCE_KEY, 'appearance', $appearance);
        $settings->forget();

        return response()->json([
            'ok' => true,
            'theme' => $data['theme'],
            'palette' => $data['palette'],
        ]);
    }

    private function aiSettings(): array
    {
        $setting = SiteSetting::query()->where('key', 'analytics.ai')->first();
        $value = is_array($setting?->value) ? $setting->value : [];

        return [
            'provider' => in_array(($value['provider'] ?? null), ['gemini', 'openrouter', 'openai'], true) ? $value['provider'] : 'gemini',
            'model' => trim((string) ($value['model'] ?? '')),
            'has_api_key' => filled($value['api_key'] ?? null),
        ];
    }

    /** @param array<string, mixed> $value */
    private function put(string $key, string $group, array $value): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => $key],
            ['group' => $group, 'value' => $value, 'type' => 'json', 'is_public' => true],
        );
    }
}
