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
        ];
        $faqs = $page->faqs();
        $productProfile = $page->productProfile();
        $hubLayout = in_array($page->slug, [
            'about', 'services', 'projects', 'pricing', 'contact',
            ...array_keys(config('website.content_hubs')),
        ], true) ? $page->slug : null;
        $collectionPages = $this->collectionPages($hubLayout);
        $relatedPages = ContentPage::published()
            ->whereKeyNot($page->getKey())
            ->whereIn('type', array_keys(config('website.content_types')))
            ->where('type', '!=', 'page')
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
