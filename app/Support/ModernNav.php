<?php

namespace App\Support;

use App\Models\ContentPage;
use Illuminate\Support\Collection;

/**
 * Navigation helpers for the Fida 2026 template.
 *
 * Page titles keep their search phrasing ("... in Afghanistan"); menus show the short name.
 */
final class ModernNav
{
    private const LOCATION_SUFFIXES = [
        ' in Afghanistan',
        ' Afghanistan',
        ' در افغانستان',
        ' په افغانستان کې',
    ];

    public static function label(string $title): string
    {
        $label = trim($title);

        foreach (self::LOCATION_SUFFIXES as $suffix) {
            if (mb_strlen($label) > mb_strlen($suffix) && str_ends_with($label, $suffix)) {
                return rtrim(mb_substr($label, 0, mb_strlen($label) - mb_strlen($suffix)), ' :–-');
            }
        }

        return $label;
    }

    /**
     * Split solution pages into the Software and Infrastructure pillars.
     *
     * @param  Collection<int, ContentPage>  $solutions
     * @return array{software: Collection<int, ContentPage>, infrastructure: Collection<int, ContentPage>}
     */
    public static function splitSolutions(Collection $solutions): array
    {
        $infrastructure = config('website.modern.infrastructure_slugs', []);

        return [
            'software' => $solutions->reject(fn (ContentPage $page) => in_array($page->slug, $infrastructure, true))->values(),
            'infrastructure' => $solutions->filter(fn (ContentPage $page) => in_array($page->slug, $infrastructure, true))->values(),
        ];
    }

    /**
     * "Prime Sarafi — Sarafi Management System" becomes "Prime Sarafi".
     */
    public static function productShortName(string $name): string
    {
        return trim(preg_split('/\s+[—–-]\s+/u', $name, 2)[0] ?? $name);
    }

    /**
     * Industry chips: "Construction ERP Software in Afghanistan" becomes "Construction".
     * Only English wording is trimmed; Dari and Pashto titles keep their full short label.
     */
    public static function industryShortName(string $title): string
    {
        $label = self::label($title);
        $trimmed = preg_replace('/\s+(ERP\s+Software|Software\s+Systems|Management\s+Software|Management\s+System|OSS\/BSS\s+Software|Software)$/u', '', $label);

        return is_string($trimmed) && $trimmed !== '' ? $trimmed : $label;
    }

    /**
     * Portfolio systems are stored as "Name (what it does)"; return the description part.
     */
    public static function systemDescription(array $system): string
    {
        $key = 'modern.systems.'.($system['slug'] ?? '').'.description';
        if (app()->getLocale() !== config('website.default_locale') && trans()->has($key)) {
            return (string) __($key);
        }

        $label = (string) ($system['label'] ?? '');

        return preg_match('/\(([^)]+)\)\s*$/u', $label, $match) === 1 ? $match[1] : '';
    }

    /**
     * Brand names stay as they are; descriptive system names are translated for Dari and Pashto.
     */
    public static function systemName(array $system): string
    {
        $key = 'modern.systems.'.($system['slug'] ?? '').'.name';
        if (app()->getLocale() !== config('website.default_locale') && trans()->has($key)) {
            return (string) __($key);
        }

        return (string) ($system['name'] ?? '');
    }

    private const GENERIC_EYEBROWS = [
        'Enterprise capability for institutional delivery',
        'Industry workflow guide',
    ];

    private const MENU_DESCRIPTION_KEYS = [
        'data-center' => 'data-center', 'network-infrastructure' => 'network', 'cloud-server' => 'cloud',
        'cybersecurity' => 'cybersecurity', 'hardware' => 'hardware', 'systems-integration' => 'integration',
        'managed-it' => 'managed-it', 'iot-' => 'iot',
    ];

    /**
     * One-line description for a mega-menu item: a written menu line when there is one,
     * otherwise the page's tagline unless it is a generic placeholder.
     */
    public static function menuDescription(ContentPage $page): string
    {
        foreach (self::MENU_DESCRIPTION_KEYS as $keyword => $key) {
            if (str_contains($page->slug, $keyword) && trans()->has("modern.menu.desc.{$key}")) {
                return (string) __("modern.menu.desc.{$key}");
            }
        }

        $eyebrow = trim((string) $page->translation('eyebrow'));
        $english = trim((string) $page->translation('eyebrow', config('website.default_locale')));

        if ($eyebrow === '' || in_array($english, self::GENERIC_EYEBROWS, true) || str_contains($eyebrow, '·')) {
            return '';
        }

        return $eyebrow;
    }

    /**
     * Office address in the visitor's language; English uses the address saved in Website settings.
     */
    public static function address(): string
    {
        if (app()->getLocale() !== config('website.default_locale') && trans()->has('modern.contact.address')) {
            return (string) __('modern.contact.address');
        }

        return trim(config('website.address.line').', '.config('website.address.city'), ', ');
    }
}
