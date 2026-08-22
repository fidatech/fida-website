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
            'title' => $page->translation('meta_title') ?: $page->translation('title').' | Fida Technologies',
            'description' => $page->translation('meta_description') ?: $page->translation('summary'),
            'canonical' => LocalizedUrl::path('/'.$page->slug),
            'type' => $page->type === 'article' ? 'article' : 'website',
        ];
        $faqs = $page->faqs();
        $productProfile = $page->productProfile();
        $hubLayout = in_array($page->slug, ['about', 'services', 'projects', 'pricing', 'contact'], true)
            ? $page->slug
            : null;
        $collectionPages = $this->collectionPages($hubLayout);
        $relatedPages = ContentPage::published()
            ->whereKeyNot($page->getKey())
            ->whereIn('type', ['solution', 'service', 'product', 'case-study'])
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
            'collectionPages' => $collectionPages,
            'relatedPages' => $relatedPages,
            'structuredData' => SeoSchema::page($page, $seo['title'], $seo['description'], $seo['canonical'], $faqs),
        ]);
    }

    private function collectionPages(?string $hubLayout): Collection
    {
        $urls = match ($hubLayout) {
            'services' => collect(config('website.featured_solutions'))->pluck('url'),
            'projects' => collect(config('website.products'))->pluck('url'),
            default => collect(),
        };
        $slugs = $urls->map(fn (string $url): string => basename($url))->values();

        if ($slugs->isEmpty()) {
            return collect();
        }

        $pages = ContentPage::published()->whereIn('slug', $slugs)->get()->keyBy('slug');

        return $slugs->map(fn (string $slug) => $pages->get($slug))->filter()->values();
    }
}
