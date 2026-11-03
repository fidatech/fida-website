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
     * Portfolio systems are stored as "Name (what it does)"; return the description part.
     */
    public static function systemDescription(array $system): string
    {
        $label = (string) ($system['label'] ?? '');

        return preg_match('/\(([^)]+)\)\s*$/u', $label, $match) === 1 ? $match[1] : '';
    }
}
