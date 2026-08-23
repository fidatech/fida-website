<?php

namespace App\Http\Controllers;

use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\ContentPage;
use App\Support\LocalizedUrl;
use App\Support\SeoSchema;
use Illuminate\Contracts\View\View;

class ArticleTaxonomyController extends Controller
{
    public function category(ArticleCategory $articleCategory): View
    {
        abort_unless($articleCategory->active, 404);

        return $this->render(
            title: (string) $articleCategory->translation('name'),
            description: (string) ($articleCategory->translation('description') ?: __('website.insights.category_description', ['category' => $articleCategory->translation('name')])),
            canonicalPath: '/articles/category/'.$articleCategory->slug,
            query: ContentPage::published()->where('type', 'article')->whereBelongsTo($articleCategory),
            metaTitle: (string) ($articleCategory->translation('meta_title') ?: $articleCategory->translation('name').' | '.config('website.name')),
            metaDescription: (string) ($articleCategory->translation('meta_description') ?: $articleCategory->translation('description')),
            taxonomyLabel: __('website.insights.category'),
        );
    }

    public function author(ArticleAuthor $articleAuthor): View
    {
        abort_unless($articleAuthor->active, 404);

        return $this->render(
            title: $articleAuthor->name,
            description: (string) ($articleAuthor->translation('bio') ?: __('website.insights.author_description', ['author' => $articleAuthor->name])),
            canonicalPath: '/articles/author/'.$articleAuthor->slug,
            query: ContentPage::published()->where('type', 'article')->whereBelongsTo($articleAuthor),
            metaTitle: __('website.insights.author_title', ['author' => $articleAuthor->name, 'company' => config('website.name')]),
            metaDescription: (string) ($articleAuthor->translation('bio') ?: __('website.insights.author_description', ['author' => $articleAuthor->name])),
            taxonomyLabel: __('website.insights.author'),
        );
    }

    private function render(
        string $title,
        string $description,
        string $canonicalPath,
        $query,
        string $metaTitle,
        string $metaDescription,
        string $taxonomyLabel,
    ): View {
        $articles = $query
            ->with(['articleCategory', 'articleAuthor'])
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->get();
        abort_if($articles->isEmpty(), 404);

        $canonical = LocalizedUrl::path($canonicalPath);
        $seo = [
            'title' => $metaTitle,
            'description' => $metaDescription ?: $description,
            'canonical' => $canonical,
            'type' => 'website',
            'robots' => config('website.discovery.default_robots'),
            'image' => config('website.social_image'),
        ];

        return view('marketing.article-archive', [
            'title' => $title,
            'description' => $description,
            'taxonomyLabel' => $taxonomyLabel,
            'articles' => $articles,
            'seo' => $seo,
            'structuredData' => SeoSchema::articleCollection($title, $seo['description'], $canonical, $articles),
        ]);
    }
}
