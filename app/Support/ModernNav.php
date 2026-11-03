<?php

namespace App\Support;

use App\Models\ContentPage;
use Illuminate\Support\Collection;

/**
 * Navigation helpers for the Lapis 2026 template.
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
        $label = (string) ($system['label'] ?? '');

        return preg_match('/\(([^)]+)\)\s*$/u', $label, $match) === 1 ? $match[1] : '';
    }
}
