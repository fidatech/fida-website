<?php

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use App\Models\ContentPage;
use App\Support\LocalizedUrl;
use App\Support\SeoSchema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class MarketingPageController extends Controller
{
    public function __invoke(ContentPage $page): View
    {
        abort_unless($page->isPubliclyVisible(), 404);
        $page->loadMissing(['articleCategory', 'articleAuthor']);

        $seo = [
            'title' => $page->translation('meta_title') ?: $page->translation('title').' | '.config('website.name'),
            'description' => $page->translation('meta_description') ?: $page->translation('summary'),
            'canonical' => LocalizedUrl::path('/'.$page->slug),
            'type' => in_array($page->type, ['article', 'case-study'], true) ? 'article' : 'website',
            'robots' => $page->robotsDirective(),
            'image' => $page->socialImage(),
            'author' => $page->byline(),
        ];
        $faqs = $page->faqs();
        $productProfile = $page->productProfile();
        $serviceProfile = $page->serviceProfile();
        $solutionProfile = $page->solutionProfile();
        $industryProfile = $page->industryProfile();
        $callToAction = $page->callToAction();
        $archive = $this->archiveFor($page->type);
        $hubLayout = in_array($page->slug, [
            'about', 'services', 'projects', 'pricing', 'contact',
            ...array_keys(config('website.content_hubs')),
        ], true) ? $page->slug : null;
        $collectionPages = $this->collectionPages($hubLayout);
        $portfolioBody = $hubLayout === 'products' ? $this->portfolioBody() : null;
        $projectBody = $hubLayout === 'projects' ? $this->projectBody() : null;
        $relatedPages = $this->relatedPages($page);
        $articleCategories = $hubLayout === 'articles'
            ? ArticleCategory::active()
                ->whereHas('articles', fn ($query) => $query->published()->where('type', 'article'))
                ->withCount(['articles' => fn ($query) => $query->published()->where('type', 'article')])
                ->orderBy('sort_order')
                ->get()
            : collect();
        $detailView = match ($page->type) {
            'service' => 'marketing.service',
            'solution' => 'marketing.solution',
            'product' => 'marketing.product',
            'industry' => 'marketing.industry',
            'article' => 'marketing.article',
            default => 'marketing.page',
        };

        return view($hubLayout ? 'marketing.hub' : $detailView, [
            'page' => $page,
            'seo' => $seo,
            'faqs' => $faqs,
            'productProfile' => $productProfile,
            'serviceProfile' => $serviceProfile,
            'solutionProfile' => $solutionProfile,
            'industryProfile' => $industryProfile,
            'callToAction' => $callToAction,
            'hubLayout' => $hubLayout,
            'archive' => $archive,
            'collectionPages' => $collectionPages,
            'portfolioBody' => $portfolioBody,
            'projectBody' => $projectBody,
            'articleCategories' => $articleCategories,
            'relatedPages' => $relatedPages,
            'structuredData' => SeoSchema::page($page, $seo['title'], $seo['description'], $seo['canonical'], $faqs, $archive),
        ]);
    }

    private function relatedPages(ContentPage $page): Collection
    {
        $preferredSlugs = $page->relatedSlugs();
        $preferred = collect();

        if ($preferredSlugs !== []) {
            $positions = array_flip($preferredSlugs);
            $preferred = ContentPage::published()
                ->whereKeyNot($page->getKey())
                ->whereIn('slug', $preferredSlugs)
                ->with(['articleCategory', 'articleAuthor'])
                ->get()
                ->sortBy(fn (ContentPage $relatedPage): int => $positions[$relatedPage->slug] ?? PHP_INT_MAX)
                ->values();
        }

        if ($preferred->count() >= 3) {
            return $preferred->take(3);
        }

        $fallback = ContentPage::published()
            ->whereKeyNot($page->getKey())
            ->whereNotIn('id', $preferred->pluck('id')->all())
            ->whereIn('type', $this->relatedTypes($page->type))
            ->with(['articleCategory', 'articleAuthor'])
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->limit(3 - $preferred->count())
            ->get();

        return $preferred->concat($fallback)->values();
    }

    private function archiveFor(string $type): ?array
    {
        $path = config("website.content_types.{$type}.archive");
        $labelKey = match ($type) {
            'solution' => 'solutions',
            'service' => 'services',
            'product' => 'products',
            'industry' => 'industries',
            'case-study' => 'case_studies',
            'article' => 'articles',
            default => null,
        };

        if (! is_string($path) || $labelKey === null) {
            return null;
        }

        return [
            'path' => LocalizedUrl::path($path),
            'label' => __("website.nav.{$labelKey}"),
        ];
    }

    private function relatedTypes(string $type): array
    {
        return match ($type) {
            'article' => ['article', 'service', 'solution'],
            'industry' => ['industry', 'product', 'solution'],
            'service', 'solution' => ['service', 'solution', 'industry'],
            'product' => ['product', 'industry', 'case-study'],
            'case-study' => ['case-study', 'product', 'industry'],
            default => array_values(array_filter(
                array_keys(config('website.content_types')),
                fn (string $contentType): bool => $contentType !== 'page',
            )),
        };
    }

    private function portfolioBody(): ?string
    {
        $projects = ContentPage::published()->where('slug', 'projects')->first();
        $html = trim((string) $projects?->translation('body'));

        if ($html === '') {
            return null;
        }

        // The four detailed product profiles already appear above the catalogue.
        // Bespoke company websites belong to the Projects hub.
        $exclude = [
            'Realist ERP', 'Prime Sarafi', 'Darmal ERP', 'OGRAYI',
            'Real Estate Company Website Platform', 'Technology Company Website Platform',
        ];

        foreach ($exclude as $name) {
            $html = preg_replace(
                '/<li><strong>'.preg_quote($name, '/').'<\/strong>.*?<\/li>/s',
                '',
                $html
            ) ?? $html;
        }

        foreach (config('website.portfolio_systems', []) as $system) {
            $needle = '<li><strong>'.$system['name'].'</strong>';
            $label = e($system['label'] ?? $system['name']);
            $html = str_replace($needle, '<li id="system-'.$system['slug'].'"><strong>'.$label.'</strong>', $html);
        }

        $html = preg_replace('/<h2>(?:Portfolio policy|سیاست پورتفولیو|د پورټفولیو تګلاره)<\/h2><p>.*?<\/p>/s', '', $html) ?? $html;

        return $html;
    }

    private function projectBody(): ?string
    {
        $projects = ContentPage::published()->where('slug', 'projects')->first();
        $source = trim((string) $projects?->translation('body'));

        if ($source === '') {
            return null;
        }

        $items = [];

        foreach ([
            'real-estate-company-website-platform' => 'Real Estate Company Website Platform',
            'technology-company-website-platform' => 'Technology Company Website Platform',
        ] as $slug => $name) {
            if (preg_match('/<li><strong>'.preg_quote($name, '/').'<\/strong>.*?<\/li>/s', $source, $match)) {
                $items[] = str_replace('<li>', '<li id="project-'.$slug.'">', $match[0]);
            }
        }

        if ($items === []) {
            return null;
        }

        $heading = match (app()->getLocale()) {
            'fa' => 'پروژه‌های وب‌سایت شرکتی',
            'ps' => 'د شرکتونو د وېب‌سایټ پروژې',
            default => 'Company website projects',
        };

        return '<h2>'.e($heading).'</h2><ul>'.implode('', $items).'</ul>';
    }

    private function collectionPages(?string $hubLayout): Collection
    {
        $types = config("website.content_hubs.{$hubLayout}.types", []);

        if ($types === []) {
            return collect();
        }

        return ContentPage::published()
            ->whereIn('type', $types)
            ->with(['articleCategory', 'articleAuthor'])
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->orderBy('title->en')
            ->get();
    }
}
