<?php

namespace App\Http\Controllers;

use App\Support\LocalizedUrl;
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

        return view('marketing.home', [
            'seo' => $seo,
            'structuredData' => SeoSchema::home($seo['title'], $seo['description'], $seo['canonical'], $topic, $seo['image']),
            'solutions' => config('website.featured_solutions'),
            'products' => config('website.products'),
            'industries' => config('website.industries'),
        ]);
    }
}
