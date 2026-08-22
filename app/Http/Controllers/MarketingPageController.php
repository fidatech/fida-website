<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Support\LocalizedUrl;
use App\Support\SeoSchema;
use Illuminate\Contracts\View\View;

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
        $relatedPages = ContentPage::published()
            ->whereKeyNot($page->getKey())
            ->whereIn('type', ['solution', 'service', 'product', 'case-study'])
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('marketing.page', [
            'page' => $page,
            'seo' => $seo,
            'faqs' => $faqs,
            'productProfile' => $productProfile,
            'relatedPages' => $relatedPages,
            'structuredData' => SeoSchema::page($page, $seo['title'], $seo['description'], $seo['canonical'], $faqs),
        ]);
    }
}
