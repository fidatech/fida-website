<?php

namespace App\Http\Controllers;

use App\Support\LocalizedUrl;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('marketing.home', [
            'seo' => [
                'title' => __('website.seo.home.title'),
                'description' => __('website.seo.home.description'),
                'canonical' => LocalizedUrl::path('/'),
            ],
            'solutions' => config('website.featured_solutions'),
            'products' => config('website.products'),
            'industries' => config('website.industries'),
        ]);
    }
}
