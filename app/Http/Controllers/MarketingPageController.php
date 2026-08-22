<?php

namespace App\Http\Controllers;

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

        $seo = [
            'title' => $page->translation('meta_title') ?: $page->translation('title').' | '.config('website.name'),
            'description' => $page->translation('meta_description') ?: $page->translation('summary'),
            'canonical' => LocalizedUrl::path('/'.$page->slug),
            'type' => $page->type === 'article' ? 'article' : 'website',
            'robots' => $page->robotsDirective(),
            'image' => $page->socialImage(),
            'author' => $page->author_name,
        ];
        $faqs = $page->faqs();
        $productProfile = $page->productProfile();
        $archive = $this->archiveFor($page->type);
        $hubLayout = in_array($page->slug, [
            'about', 'services', 'projects', 'pricing', 'contact',
            ...array_keys(config('website.content_hubs')),
        ], true) ? $page->slug : null;
        $collectionPages = $this->collectionPages($hubLayout);
        $relatedPages = ContentPage::published()
            ->whereKeyNot($page->getKey())
            ->whereIn('type', $this->relatedTypes($page->type))
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view($hubLayout ? 'marketing.hub' : 'marketing.page', [
            'page' => $page,
            'seo' => $seo,
            'faqs' => $faqs,
            'productProfile' => $productProfile,
            'hubLayout' => $hubLayout,
            'archive' => $archive,
            'collectionPages' => $collectionPages,
            'relatedPages' => $relatedPages,
            'structuredData' => SeoSchema::page($page, $seo['title'], $seo['description'], $seo['canonical'], $faqs, $archive),
        ]);
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
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->orderBy('title->en')
            ->get();
    }
}
