<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WebsiteSettingsRequest;
use App\Models\SiteSetting;
use App\Support\WebsiteSettings;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
            'themes' => config('website.appearance.themes'),
            'palettes' => config('website.appearance.palettes'),
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
            DB::transaction(function () use ($data, $logoPath): void {
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
                    'theme' => $data['theme'],
                    'palette' => $data['palette'],
                    'primary_color' => strtolower($data['primary_color']),
                    'secondary_color' => strtolower($data['secondary_color']),
                    'highlight_color' => strtolower($data['highlight_color']),
                ]);
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

    /** @param array<string, mixed> $value */
    private function put(string $key, string $group, array $value): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => $key],
            ['group' => $group, 'value' => $value, 'type' => 'json', 'is_public' => true],
        );
    }
}
