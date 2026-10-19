<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Throwable;

class WebsiteSettings
{
    public const GENERAL_KEY = 'website.general';

    public const BRANDING_KEY = 'website.branding';

    public const APPEARANCE_KEY = 'website.appearance';


    /** @var array<string, array<string, mixed>>|null */
    private ?array $stored = null;

    public function apply(): void
    {
        $form = $this->formData();
        $theme = config("website.appearance.themes.{$form['theme']}");
        $palette = $form['palette'] === 'custom'
            ? [
                'label' => 'Custom',
                'description' => 'Administrator-defined website colors.',
                'primary' => $form['primary_color'],
                'primary_soft' => $this->mixWithWhite($form['primary_color'], .58),
                'secondary' => $form['secondary_color'],
                'highlight' => $form['highlight_color'],
            ]
            : config("website.appearance.palettes.{$form['palette']}");

        $adminTheme = config("website.appearance.themes.{$form['admin_theme']}");
        $adminPalette = $form['admin_palette'] === 'custom'
            ? [
                'label' => 'Custom admin',
                'description' => 'Administrator-defined console colors.',
                'primary' => $form['admin_primary_color'],
                'primary_soft' => $this->mixWithWhite($form['admin_primary_color'], .58),
                'secondary' => $form['admin_secondary_color'],
                'highlight' => $form['admin_highlight_color'],
            ]
            : config("website.appearance.palettes.{$form['admin_palette']}");

        config([
            'website.name' => $form['company_name'],
            'website.legal_name' => $form['legal_name'],
            'website.email' => $form['email'],
            'website.phone' => $form['phone'],
            'website.whatsapp' => $form['whatsapp'],
            'website.address.line' => $form['address_line'],
            'website.address.city' => $form['city'],
            'website.address.country' => $form['country'],
            'website.address.country_code' => $form['country_code'],
            'website.map_embed_url' => $form['map_embed_url'],
            'website.branding.name' => $form['brand_name'],
            'website.branding.tagline' => $form['brand_tagline'],
            'website.branding.logo_path' => $form['logo_path'],
            'website.branding.logo_url' => $this->logoUrl($form['logo_path']),
            'website.appearance.current_template' => $form['template'],
            'website.appearance.current_font_preset' => $form['font_preset'],
            'website.appearance.current_type_scale' => $form['type_scale'],
            'website.appearance.current_theme' => $form['theme'],
            'website.appearance.current_palette' => $form['palette'],
            'website.appearance.current_theme_values' => $theme,
            'website.appearance.current_colors' => $palette,
            'website.appearance.rgb' => [
                'primary' => $this->hexToRgb($palette['primary']),
                'secondary' => $this->hexToRgb($palette['secondary']),
                'highlight' => $this->hexToRgb($palette['highlight']),
            ],
            'website.admin_appearance.current_theme' => $form['admin_theme'],
            'website.admin_appearance.current_palette' => $form['admin_palette'],
            'website.admin_appearance.current_theme_values' => $adminTheme,
            'website.admin_appearance.current_colors' => $adminPalette,
            'website.admin_appearance.rgb' => [
                'primary' => $this->hexToRgb($adminPalette['primary']),
                'secondary' => $this->hexToRgb($adminPalette['secondary']),
                'highlight' => $this->hexToRgb($adminPalette['highlight']),
            ],
        ]);
    }

    /** @return array<string, mixed> */
    public function formData(): array
    {
        $stored = $this->stored();
        $general = $stored[self::GENERAL_KEY] ?? [];
        $branding = $stored[self::BRANDING_KEY] ?? [];
        $appearance = $stored[self::APPEARANCE_KEY] ?? [];
        $adminAppearance = $appearance;

        $themes = config('website.appearance.themes', []);
        $palettes = config('website.appearance.palettes', []);
        $defaultTheme = config('website.appearance.default_theme', 'midnight');
        $defaultPalette = config('website.appearance.default_palette', 'fida');
        $theme = array_key_exists((string) ($appearance['theme'] ?? ''), $themes)
            ? (string) $appearance['theme']
            : $defaultTheme;
        $palette = (string) ($appearance['palette'] ?? $defaultPalette);

        if ($palette !== 'custom' && ! array_key_exists($palette, $palettes)) {
            $palette = $defaultPalette;
        }

        $fallbackColors = $palettes[$palette === 'custom' ? $defaultPalette : $palette];

        $adminTheme = array_key_exists((string) ($adminAppearance['admin_theme'] ?? ''), $themes)
            ? (string) $adminAppearance['admin_theme']
            : $defaultTheme;
        $adminPalette = (string) ($adminAppearance['admin_palette'] ?? $defaultPalette);
        if ($adminPalette !== 'custom' && ! array_key_exists($adminPalette, $palettes)) {
            $adminPalette = $defaultPalette;
        }
        $adminFallbackColors = $palettes[$adminPalette === 'custom' ? $defaultPalette : $adminPalette];

        return [
            'company_name' => $this->text($general['company_name'] ?? null, config('website.name'), 160),
            'legal_name' => $this->text($general['legal_name'] ?? null, config('website.legal_name'), 190),
            'email' => $this->text($general['email'] ?? null, config('website.email'), 190),
            'phone' => $this->text($general['phone'] ?? null, config('website.phone'), 50),
            'whatsapp' => $this->digits($general['whatsapp'] ?? null, config('website.whatsapp')),
            'address_line' => array_key_exists('address_line', $general)
                ? $this->text($general['address_line'], '', 255, true)
                : $this->text(config('website.address.line', ''), '', 255, true),
            'city' => $this->text($general['city'] ?? null, config('website.address.city'), 100),
            'country' => $this->text($general['country'] ?? null, config('website.address.country'), 100),
            'country_code' => $this->countryCode($general['country_code'] ?? null, config('website.address.country_code')),
            'map_embed_url' => $this->mapEmbedUrl($general['map_embed_url'] ?? config('website.map_embed_url'))
                ?? $this->mapEmbedUrl(config('website.map_embed_url')),
            'brand_name' => $this->text($branding['brand_name'] ?? null, config('website.branding.name', 'Fida'), 80),
            'brand_tagline' => $this->text($branding['brand_tagline'] ?? null, config('website.branding.tagline', 'Technologies'), 80),
            'logo_path' => $this->logoPath($branding['logo_path'] ?? null),
            'template' => array_key_exists((string) ($appearance['template'] ?? ''), config('website.appearance.templates', []))
                ? (string) $appearance['template']
                : (string) config('website.appearance.default_template', 'technology'),
            'font_preset' => array_key_exists((string) ($appearance['font_preset'] ?? ''), config('website.appearance.font_presets', []))
                ? (string) $appearance['font_preset']
                : (string) config('website.appearance.default_font_preset', 'editorial'),
            'type_scale' => array_key_exists((string) ($appearance['type_scale'] ?? ''), config('website.appearance.type_scales', []))
                ? (string) $appearance['type_scale']
                : (string) config('website.appearance.default_type_scale', 'balanced'),
            'theme' => $theme,
            'palette' => $palette,
            'primary_color' => $this->color($appearance['primary_color'] ?? null, $fallbackColors['primary']),
            'secondary_color' => $this->color($appearance['secondary_color'] ?? null, $fallbackColors['secondary']),
            'highlight_color' => $this->color($appearance['highlight_color'] ?? null, $fallbackColors['highlight']),
            'admin_theme' => $adminTheme,
            'admin_palette' => $adminPalette,
            'admin_primary_color' => $this->color($adminAppearance['admin_primary_color'] ?? null, $adminFallbackColors['primary']),
            'admin_secondary_color' => $this->color($adminAppearance['admin_secondary_color'] ?? null, $adminFallbackColors['secondary']),
            'admin_highlight_color' => $this->color($adminAppearance['admin_highlight_color'] ?? null, $adminFallbackColors['highlight']),
        ];
    }

    public function forget(): void
    {
        $this->stored = null;
    }

    /** @return array<string, array<string, mixed>> */
    private function stored(): array
    {
        if ($this->stored !== null) {
            return $this->stored;
        }

        try {
            $this->stored = SiteSetting::query()
                ->whereIn('key', [self::GENERAL_KEY, self::BRANDING_KEY, self::APPEARANCE_KEY])
                ->get()
                ->mapWithKeys(fn (SiteSetting $setting): array => [$setting->key => is_array($setting->value) ? $setting->value : []])
                ->all();
        } catch (Throwable) {
            $this->stored = [];
        }

        return $this->stored;
    }

    private function text(mixed $value, mixed $fallback, int $limit, bool $nullable = false): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return $nullable ? '' : mb_substr(trim((string) $fallback), 0, $limit);
        }

        return mb_substr($value, 0, $limit);
    }

    private function digits(mixed $value, mixed $fallback): string
    {
        $digits = preg_replace('/\D+/', '', (string) $value);

        return $digits !== '' ? mb_substr($digits, 0, 30) : preg_replace('/\D+/', '', (string) $fallback);
    }

    private function countryCode(mixed $value, mixed $fallback): string
    {
        $code = strtoupper(trim((string) $value));

        return preg_match('/^[A-Z]{2}$/', $code) ? $code : strtoupper((string) $fallback);
    }

    private function color(mixed $value, string $fallback): string
    {
        $value = strtolower(trim((string) $value));

        return preg_match('/^#[0-9a-f]{6}$/', $value) ? $value : strtolower($fallback);
    }

    private function logoPath(mixed $value): ?string
    {
        $path = trim((string) $value);

        if ($path === '' || ! preg_match('#^branding/[A-Za-z0-9/_\.-]+$#', $path)) {
            return null;
        }

        return $path;
    }

    private function logoUrl(?string $path): ?string
    {
        if ($path === null || ! Storage::disk('public')->exists($path)) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    private function mapEmbedUrl(mixed $value): ?string
    {
        $url = trim((string) $value);

        if ($url === '' || filter_var($url, FILTER_VALIDATE_URL) === false || parse_url($url, PHP_URL_SCHEME) !== 'https') {
            return null;
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $path = strtolower((string) parse_url($url, PHP_URL_PATH));
        $googleHost = $host === 'google.com' || str_ends_with($host, '.google.com');
        $openStreetMapHost = $host === 'openstreetmap.org' || str_ends_with($host, '.openstreetmap.org');

        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
        $googleEmbed = str_starts_with($path, '/maps/embed')
            || (rtrim($path, '/') === '/maps' && strtolower((string) ($query['output'] ?? '')) === 'embed');

        $allowed = ($googleHost && $googleEmbed)
            || ($openStreetMapHost && str_starts_with($path, '/export/embed'));

        return $allowed ? mb_substr($url, 0, 2048) : null;
    }

    private function hexToRgb(string $hex): string
    {
        $hex = ltrim($hex, '#');

        return implode(',', [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))]);
    }

    private function mixWithWhite(string $hex, float $ratio): string
    {
        $hex = ltrim($hex, '#');
        $channels = [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
        $mixed = array_map(fn (int $channel): int => (int) round($channel + ((255 - $channel) * $ratio)), $channels);

        return sprintf('#%02x%02x%02x', ...$mixed);
    }
}
