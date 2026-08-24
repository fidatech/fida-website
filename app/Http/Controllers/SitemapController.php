<?php

namespace App\Http\Controllers;

use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\ContentPage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        abort_unless(config('website.indexable'), 404);

        $sitemaps = collect(config('website.sitemap.groups'))
            ->filter(fn (array $definition, string $group): bool => $this->groupHasEntries($group, $definition))
            ->map(function (array $definition, string $group): array {
                $latestUpdate = ContentPage::published()
                    ->sitemapEligible()
                    ->whereIn('type', $definition['types'])
                    ->max('updated_at');

                return [
                    'location' => route('sitemap.group', ['group' => $group]),
                    'last_modified' => $latestUpdate ? Carbon::parse($latestUpdate) : null,
                ];
            })
            ->values();

        return response()
            ->view('seo.sitemap-index', compact('sitemaps'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function show(string $group): Response
    {
        abort_unless(config('website.indexable'), 404);

        $definition = config("website.sitemap.groups.{$group}");
        abort_unless(is_array($definition), 404);

        $entries = $this->contentEntries($group, $definition);

        if (($definition['taxonomies'] ?? false) === true) {
            $entries = $entries
                ->concat($this->categoryEntries())
                ->concat($this->authorEntries());
        }

        abort_if($entries->isEmpty(), 404);

        return response()
            ->view('seo.sitemap', compact('entries'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    private function groupHasEntries(string $group, array $definition): bool
    {
        if ($group === 'pages') {
            return true;
        }

        if (ContentPage::published()->sitemapEligible()->whereIn('type', $definition['types'])->exists()) {
            return true;
        }

        return ($definition['taxonomies'] ?? false) === true
            && ($this->categoryQuery()->exists() || $this->authorQuery()->exists());
    }

    private function contentEntries(string $group, array $definition): Collection
    {
        $entries = ContentPage::published()
            ->sitemapEligible()
            ->whereIn('type', $definition['types'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(fn (ContentPage $page): array => [
                'path' => '/'.$page->slug,
                'last_modified' => $page->sitemap_last_modified_at ?? $page->updated_at,
                'change_frequency' => $page->sitemapChangeFrequency($definition['change_frequency'] ?? null),
                'priority' => $page->sitemapPriority((float) ($definition['priority'] ?? 0.8)),
            ]);

        if ($group === 'pages') {
            $entries->prepend([
                'path' => '/',
                'last_modified' => $entries->max('last_modified'),
                'change_frequency' => 'weekly',
                'priority' => '1.0',
            ]);
        }

        return $entries;
    }

    private function categoryEntries(): Collection
    {
        return $this->categoryQuery()->get()->map(fn (ArticleCategory $category): array => [
            'path' => '/articles/category/'.$category->slug,
            'last_modified' => $category->updated_at,
            'change_frequency' => 'monthly',
            'priority' => '0.6',
        ]);
    }

    private function authorEntries(): Collection
    {
        return $this->authorQuery()->get()->map(fn (ArticleAuthor $author): array => [
            'path' => '/articles/author/'.$author->slug,
            'last_modified' => $author->updated_at,
            'change_frequency' => 'monthly',
            'priority' => '0.5',
        ]);
    }

    private function categoryQuery(): Builder
    {
        return ArticleCategory::active()
            ->whereHas('articles', fn (Builder $query): Builder => $query->published()->sitemapEligible()->where('type', 'article'))
            ->orderBy('updated_at', 'desc');
    }

    private function authorQuery(): Builder
    {
        return ArticleAuthor::active()
            ->whereHas('articles', fn (Builder $query): Builder => $query->published()->sitemapEligible()->where('type', 'article'))
            ->orderBy('updated_at', 'desc');
    }
}
