<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $pages = ContentPage::published()
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('seo.sitemap', ['pages' => $pages])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
