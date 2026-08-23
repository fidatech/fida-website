<?php

namespace App\Http\Controllers;

use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\ContentPage;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $pages = ContentPage::published()
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);

        $articleCategories = ArticleCategory::active()
            ->whereHas('articles', fn ($query) => $query->published()->where('type', 'article'))
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);
        $articleAuthors = ArticleAuthor::active()
            ->whereHas('articles', fn ($query) => $query->published()->where('type', 'article'))
            ->orderBy('updated_at', 'desc')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('seo.sitemap', compact('pages', 'articleCategories', 'articleAuthors'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
