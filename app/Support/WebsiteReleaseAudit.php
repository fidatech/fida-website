<?php

namespace App\Support;

use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\ContentPage;
use App\Models\PageRedirect;

final class WebsiteReleaseAudit
{
    private const REQUIRED_TRANSLATIONS = [
        'title' => 'title',
        'summary' => 'summary',
        'body' => 'body content',
        'meta_title' => 'meta title',
        'meta_description' => 'meta description',
    ];

    public function run(bool $production = false): array
    {
        $findings = [];
        $locales = array_keys(config('website.locales', []));
        $configuredTypes = array_keys(config('website.content_types', []));
        $sitemapTypes = collect(config('website.sitemap.groups', []))
            ->flatMap(fn (array $group): array => (array) ($group['types'] ?? []))
            ->unique()
            ->all();
        $allPages = ContentPage::query()
            ->with(['articleCategory', 'articleAuthor'])
            ->get();
        $publishedPages = $allPages->where('status', 'published')->values();
        $pagesBySlug = $allPages->keyBy('slug');
        $relatedLinks = 0;

        foreach ($publishedPages as $page) {
            if (! in_array($page->type, $configuredTypes, true)) {
                $this->add($findings, 'blocker', 'unknown-content-type', $page->slug, "Content type [{$page->type}] is not configured.");
            }

            if (! in_array($page->type, $sitemapTypes, true)) {
                $this->add($findings, 'blocker', 'missing-sitemap-group', $page->slug, "Content type [{$page->type}] has no sitemap group.");
            }

            foreach ($locales as $locale) {
                foreach (self::REQUIRED_TRANSLATIONS as $field => $label) {
                    $value = data_get($page->getAttribute($field), $locale);
                    $normalized = $field === 'body'
                        ? trim(strip_tags((string) $value))
                        : trim((string) $value);

                    if ($normalized === '') {
                        $this->add($findings, 'blocker', 'missing-translation', $page->slug, strtoupper($locale)." {$label} is missing.");
                    }
                }

                $primaryQuery = trim((string) data_get($page->primary_query, $locale));

                if ($primaryQuery === '') {
                    $this->add($findings, 'warning', 'missing-primary-query', $page->slug, strtoupper($locale).' primary search topic is not documented.');
                }

                $metaTitleLength = mb_strlen(trim((string) data_get($page->meta_title, $locale)));
                $metaDescriptionLength = mb_strlen(trim((string) data_get($page->meta_description, $locale)));

                if ($metaTitleLength > 0 && ($metaTitleLength < 25 || $metaTitleLength > 70)) {
                    $this->add($findings, 'warning', 'meta-title-length', $page->slug, strtoupper($locale)." meta title is {$metaTitleLength} characters; review the practical 25–70 range.");
                }

                if ($metaDescriptionLength > 0 && ($metaDescriptionLength < 70 || $metaDescriptionLength > 180)) {
                    $this->add($findings, 'warning', 'meta-description-length', $page->slug, strtoupper($locale)." meta description is {$metaDescriptionLength} characters; review the practical 70–180 range.");
                }
            }

            if ($page->sitemap_included && str_starts_with($page->robotsDirective(), 'noindex')) {
                $this->add($findings, 'blocker', 'sitemap-robots-conflict', $page->slug, 'The page is included in its sitemap while its robots policy begins with noindex.');
            }

            if ($page->type === 'case-study' && ! $page->caseStudyPublicationApproved()) {
                $this->add($findings, 'blocker', 'unapproved-case-study', $page->slug, 'A published case study has not passed the evidence and client-approval gate.');
            }

            $rawRelatedSlugs = collect(data_get($page->metadata, 'related_slugs', []))
                ->filter(fn (mixed $slug): bool => is_string($slug) && trim($slug) !== '')
                ->map(fn (string $slug): string => trim($slug));
            $relatedLinks += $rawRelatedSlugs->count();

            if ($rawRelatedSlugs->duplicates()->isNotEmpty()) {
                $this->add($findings, 'warning', 'duplicate-related-link', $page->slug, 'Related-content targets contain duplicates.');
            }

            foreach ($rawRelatedSlugs->unique() as $relatedSlug) {
                if ($relatedSlug === $page->slug) {
                    $this->add($findings, 'blocker', 'self-related-link', $page->slug, 'The page links to itself as related content.');

                    continue;
                }

                $target = $pagesBySlug->get($relatedSlug);

                if (! $target) {
                    $this->add($findings, 'blocker', 'broken-related-link', $page->slug, "Related-content target [{$relatedSlug}] does not exist.");

                    continue;
                }

                if ($target->status !== 'published') {
                    $this->add($findings, 'warning', 'private-related-link', $page->slug, "Related-content target [{$relatedSlug}] is not published and will not render publicly.");
                }
            }

            if ($page->type === 'article' && $page->article_category_id && ! $page->articleCategory?->active) {
                $this->add($findings, 'warning', 'inactive-article-category', $page->slug, 'The assigned article category is inactive.');
            }

            if ($page->type === 'article' && $page->article_author_id && ! $page->articleAuthor?->active) {
                $this->add($findings, 'warning', 'inactive-article-author', $page->slug, 'The assigned article author is inactive.');
            }
        }

        foreach (ArticleCategory::active()->get() as $category) {
            foreach ($locales as $locale) {
                foreach (['name', 'description', 'meta_title', 'meta_description'] as $field) {
                    if (trim((string) data_get($category->getAttribute($field), $locale)) === '') {
                        $this->add($findings, 'warning', 'incomplete-article-category', 'articles/category/'.$category->slug, strtoupper($locale)." {$field} is missing.");
                    }
                }
            }
        }

        if (! config('website.social_image') && $publishedPages->whereNull('social_image_url')->isNotEmpty()) {
            $this->add($findings, 'warning', 'missing-social-image', null, 'No global social image is configured; pages without a specific image will not have an image preview.');
        }

        $activeRedirects = $this->auditRedirects($findings, $publishedPages, $locales);

        if ($production) {
            $this->auditProductionEnvironment($findings);
        }

        usort($findings, fn (array $left, array $right): int => [
            $left['severity'] === 'blocker' ? 0 : 1,
            $left['page'] ?? '',
            $left['code'],
        ] <=> [
            $right['severity'] === 'blocker' ? 0 : 1,
            $right['page'] ?? '',
            $right['code'],
        ]);

        $blockers = collect($findings)->where('severity', 'blocker')->count();
        $warnings = collect($findings)->where('severity', 'warning')->count();
        $blockerCodes = collect($findings)->where('severity', 'blocker')->countBy('code')->sortKeys()->all();
        $warningCodes = collect($findings)->where('severity', 'warning')->countBy('code')->sortKeys()->all();

        return [
            'ready' => $blockers === 0,
            'summary' => [
                'published_records' => $publishedPages->count(),
                'public_pages' => ContentPage::published()->count(),
                'locales' => count($locales),
                'localized_routes' => ContentPage::published()->count() * count($locales),
                'related_links' => $relatedLinks,
                'active_redirects' => $activeRedirects,
                'blockers' => $blockers,
                'warnings' => $warnings,
                'blocker_codes' => $blockerCodes,
                'warning_codes' => $warningCodes,
                'production_checks' => $production,
            ],
            'findings' => $findings,
        ];
    }

    private function auditProductionEnvironment(array &$findings): void
    {
        if (config('app.env') !== 'production') {
            $this->add($findings, 'blocker', 'production-environment', null, 'APP_ENV must be production for a production release.');
        }

        if (config('app.debug')) {
            $this->add($findings, 'blocker', 'production-debug', null, 'APP_DEBUG must be false for a production release.');
        }

        if (! config('website.indexable')) {
            $this->add($findings, 'blocker', 'production-indexing', null, 'WEBSITE_INDEXABLE must be true only for the approved production launch.');
        }

        $websiteUrl = (string) config('website.url');
        $websiteHost = parse_url($websiteUrl, PHP_URL_HOST);

        if (parse_url($websiteUrl, PHP_URL_SCHEME) !== 'https') {
            $this->add($findings, 'blocker', 'production-canonical-url', null, 'APP_URL must use HTTPS for the production canonical host.');
        }

        if ($websiteHost !== config('website.production_host')) {
            $this->add($findings, 'blocker', 'production-canonical-host', null, 'APP_URL must use the approved production hostname before indexing is enabled.');
        }

        if (! in_array(parse_url($websiteUrl, PHP_URL_PATH), [null, '', '/'], true) || parse_url($websiteUrl, PHP_URL_QUERY) !== null || parse_url($websiteUrl, PHP_URL_FRAGMENT) !== null) {
            $this->add($findings, 'blocker', 'production-canonical-base', null, 'APP_URL must not include a path, query string or fragment.');
        }

        if (! config('app.key')) {
            $this->add($findings, 'blocker', 'production-app-key', null, 'APP_KEY is not configured.');
        }

        if (config('session.secure') !== true) {
            $this->add($findings, 'blocker', 'production-session-cookie', null, 'SESSION_SECURE_COOKIE must be true for the HTTPS production website.');
        }

        if (config('session.http_only') !== true) {
            $this->add($findings, 'blocker', 'production-session-http-only', null, 'SESSION_HTTP_ONLY must remain true in production.');
        }

        if (parse_url((string) config('website.social_image'), PHP_URL_SCHEME) !== 'https') {
            $this->add($findings, 'blocker', 'production-social-image', null, 'The production social image must use an absolute HTTPS URL.');
        }

        if (! config('website.search_verification.google')) {
            $this->add($findings, 'warning', 'google-verification', null, 'Google Search Console verification is not configured.');
        }

        if (! config('website.search_verification.bing')) {
            $this->add($findings, 'warning', 'bing-verification', null, 'Bing Webmaster verification is not configured.');
        }

        if (! config('website.indexnow.key')) {
            $this->add($findings, 'warning', 'indexnow-key', null, 'IndexNow is not configured.');
        }
    }

    private function auditRedirects(array &$findings, $publishedPages, array $locales): int
    {
        $basePaths = collect(['/','/search'])
            ->merge($publishedPages->map(fn (ContentPage $page): string => '/'.$page->slug))
            ->merge(ArticleCategory::active()
                ->whereHas('articles', fn ($query) => $query->published()->where('type', 'article'))
                ->pluck('slug')
                ->map(fn (string $slug): string => '/articles/category/'.$slug))
            ->merge(ArticleAuthor::active()
                ->whereHas('articles', fn ($query) => $query->published()->where('type', 'article'))
                ->pluck('slug')
                ->map(fn (string $slug): string => '/articles/author/'.$slug))
            ->unique();
        $canonicalPaths = $basePaths
            ->flatMap(function (string $path) use ($locales): array {
                return array_map(function (string $locale) use ($path): string {
                    if ($locale === config('website.default_locale')) {
                        return $path;
                    }

                    return '/'.$locale.($path === '/' ? '' : $path);
                }, $locales);
            })
            ->map(fn (string $path): string => PageRedirects::normalize($path))
            ->flip();
        $redirects = PageRedirect::query()->where('active', true)->get();
        $redirectsBySource = $redirects->keyBy('source_path');
        $reservedPrefixes = ['/admin', '/up', '/robots.txt', '/sitemap.xml', '/sitemaps', '/indexnow-key.txt', '/contact/lead'];

        foreach ($redirects as $redirect) {
            $source = PageRedirects::normalize((string) $redirect->source_path);
            $target = PageRedirects::normalize((string) $redirect->target_path);

            if ($source !== $redirect->source_path || $target !== $redirect->target_path) {
                $this->add($findings, 'blocker', 'redirect-not-normalized', $source, 'Redirect source and target paths must be normalized.');
            }

            if (! in_array($redirect->status_code, [301, 308], true)) {
                $this->add($findings, 'blocker', 'redirect-status', $source, 'Active redirects must use permanent status 301 or 308.');
            }

            if ($source === $target) {
                $this->add($findings, 'blocker', 'redirect-loop', $source, 'Redirect source and target are identical.');
            }

            if ($canonicalPaths->has($source)) {
                $this->add($findings, 'blocker', 'redirect-source-conflict', $source, 'An active redirect replaces a canonical public URL.');
            }

            if (collect($reservedPrefixes)->contains(fn (string $prefix): bool => $source === $prefix || str_starts_with($source, $prefix.'/'))) {
                $this->add($findings, 'blocker', 'redirect-reserved-source', $source, 'A protected application path cannot be a redirect source.');
            }

            if ($redirectsBySource->has($target)) {
                $this->add($findings, 'blocker', 'redirect-chain', $source, "Redirect target [{$target}] is another active redirect; use its final canonical target.");
            }

            if (! $canonicalPaths->has($target)) {
                $this->add($findings, 'blocker', 'redirect-target-missing', $source, "Redirect target [{$target}] is not a canonical public route.");
            }
        }

        return $redirects->count();
    }

    private function add(array &$findings, string $severity, string $code, ?string $page, string $message): void
    {
        $findings[] = compact('severity', 'code', 'page', 'message');
    }
}
