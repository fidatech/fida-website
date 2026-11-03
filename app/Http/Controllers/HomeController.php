<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Support\LocalizedUrl;
use App\Support\ModernNav;
use App\Support\SeoSchema;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $seo = [
            'title' => __('website.seo.home.title'),
            'description' => __('website.seo.home.description'),
            'canonical' => LocalizedUrl::path('/'),
            'image' => config('website.social_image'),
        ];
        $topic = (string) data_get(config('website.discovery.home.primary_query'), app()->getLocale(), data_get(config('website.discovery.home.primary_query'), config('website.default_locale')));

        $template = \App\Support\WebsiteTemplate::resolve($request);
        $data = [
            'seo' => $seo,
            'structuredData' => SeoSchema::home($seo['title'], $seo['description'], $seo['canonical'], $topic, $seo['image']),
            'solutions' => config('website.featured_solutions'),
            'products' => config('website.products'),
            'industries' => config('website.industries'),
        ];

        if ($template === 'modern') {
            $pillarPages = ContentPage::query()
                ->select(['id', 'type', 'slug', 'title', 'status', 'published_at', 'featured', 'sort_order'])
                ->published()
                ->whereIn('type', ['solution', 'industry'])
                ->orderByDesc('featured')
                ->orderBy('sort_order')
                ->orderBy('title->en')
                ->get()
                ->groupBy('type');

            return view('marketing.templates.modern.home', $data + [
                'solutionPages' => ModernNav::splitSolutions($pillarPages->get('solution', collect())),
                'industryPages' => $pillarPages->get('industry', collect()),
            ]);
        }

        return view($template === 'corporate' ? 'marketing.templates.corporate.home' : 'marketing.home', $data);
    }
}
