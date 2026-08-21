<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Support\LocalizedUrl;
use Illuminate\Contracts\View\View;

class MarketingPageController extends Controller
{
    public function __invoke(ContentPage $page): View
    {
        abort_unless($page->status === 'published' && (! $page->published_at || $page->published_at->isPast()), 404);

        return view('marketing.page', [
            'page' => $page,
            'seo' => [
                'title' => $page->translation('meta_title') ?: $page->translation('title').' | Fida Technologies',
                'description' => $page->translation('meta_description') ?: $page->translation('summary'),
                'canonical' => LocalizedUrl::path('/'.$page->slug),
                'type' => $page->type === 'article' ? 'article' : 'website',
            ],
        ]);
    }
}
