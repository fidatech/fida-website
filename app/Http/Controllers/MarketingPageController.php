<?php

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use App\Models\ContentPage;
use App\Support\LocalizedUrl;
use App\Support\SeoSchema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class MarketingPageController extends Controller
{
    public function __invoke(ContentPage $page): View
    {
        abort_unless($page->status === 'published' && (! $page->published_at || $page->published_at->isPast()), 404);
        $page->loadMissing(['articleCategory', 'articleAuthor']);

        $seo = [
            'title' => $page->translation('meta_title') ?: $page->translation('title').' | '.config('website.name'),
            'description' => $page->translation('meta_description') ?: $page->translation('summary'),
            'canonical' => LocalizedUrl::path('/'.$page->slug),
            'type' => $page->type === 'article' ? 'article' : 'website',
            'robots' => $page->robotsDirective(),
            'image' => $page->socialImage(),
            'author' => $page->byline(),
        ];
        $faqs = $page->faqs();
        $productProfile = $page->productProfile();
        $serviceProfile = $page->serviceProfile();
        $industryProfile = $page->industryProfile();
        $archive = $this->archiveFor($page->type);
        $hubLayout = in_array($page->slug, [
            'about', 'services', 'projects', 'pricing', 'contact',
            ...array_keys(config('website.content_hubs')),
        ], true) ? $page->slug : null;
        $collectionPages = $this->collectionPages($hubLayout);
        $relatedPages = $this->relatedPages($page);
        $articleCategories = $hubLayout === 'articles'
            ? ArticleCategory::active()
                ->whereHas('articles', fn ($query) => $query->published()->where('type', 'article'))
                ->withCount(['articles' => fn ($query) => $query->published()->where('type', 'article')])
                ->orderBy('sort_order')
                ->get()
            : collect();
        $detailView = match ($page->type) {
            'service' => 'marketing.service',
            'product' => 'marketing.product',
            'industry' => 'marketing.industry',
            'article' => 'marketing.article',
            default => 'marketing.page',
        };

        return view($hubLayout ? 'marketing.hub' : $detailView, [
            'page' => $page,
            'seo' => $seo,
            'faqs' => $faqs,
            'productProfile' => $productProfile,
            'serviceProfile' => $serviceProfile,
            'industryProfile' => $industryProfile,
            'hubLayout' => $hubLayout,
            'archive' => $archive,
            'collectionPages' => $collectionPages,
            'articleCategories' => $articleCategories,
            'relatedPages' => $relatedPages,
            'structuredData' => SeoSchema::page($page, $seo['title'], $seo['description'], $seo['canonical'], $faqs, $archive),
        ]);
    }

    private function relatedPages(ContentPage $page): Collection
    {
        $preferredSlugs = $page->relatedSlugs();
        $preferred = collect();

        if ($preferredSlugs !== []) {
            $positions = array_flip($preferredSlugs);
            $preferred = ContentPage::published()
                ->whereKeyNot($page->getKey())
                ->whereIn('slug', $preferredSlugs)
                ->with(['articleCategory', 'articleAuthor'])
                ->get()
                ->sortBy(fn (ContentPage $relatedPage): int => $positions[$relatedPage->slug] ?? PHP_INT_MAX)
                ->values();
        }

        if ($preferred->count() >= 3) {
            return $preferred->take(3);
        }

        $fallback = ContentPage::published()
            ->whereKeyNot($page->getKey())
            ->whereNotIn('id', $preferred->pluck('id')->all())
            ->whereIn('type', $this->relatedTypes($page->type))
            ->with(['articleCategory', 'articleAuthor'])
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->limit(3 - $preferred->count())
            ->get();

        return $preferred->concat($fallback)->values();
    }

    private function archiveFor(string $type): ?array
    {
        $path = config("website.content_types.{$type}.archive");
        $labelKey = match ($type) {
            'solution' => 'solutions',
            'service' => 'services',
            'product' => 'products',
            'industry' => 'industries',
            'case-study' => 'case_studies',
            'article' => 'articles',
            default => null,
        };

        if (! is_string($path) || $labelKey === null) {
            return null;
        }

        return [
            'path' => LocalizedUrl::path($path),
            'label' => __("website.nav.{$labelKey}"),
        ];
    }

    private function relatedTypes(string $type): array
    {
        return match ($type) {
            'article' => ['article', 'service', 'solution'],
            'industry' => ['industry', 'product', 'solution'],
            'service', 'solution' => ['service', 'solution', 'industry'],
            'product' => ['product', 'industry', 'case-study'],
            'case-study' => ['case-study', 'product', 'industry'],
            default => array_values(array_filter(
                array_keys(config('website.content_types')),
                fn (string $contentType): bool => $contentType !== 'page',
            )),
        };
    }

    private function collectionPages(?string $hubLayout): Collection
    {
        $types = config("website.content_hubs.{$hubLayout}.types", []);

        if ($types === []) {
            return collect();
        }

        return ContentPage::published()
            ->whereIn('type', $types)
            ->with(['articleCategory', 'articleAuthor'])
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->orderBy('title->en')
            ->get();
    }
}
