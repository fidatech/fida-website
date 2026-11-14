<?php

namespace App\Services;

use App\Models\ArticleCategory;
use App\Models\ContentPage;
use App\Models\SearchConsoleMetric;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use RuntimeException;

class AutoArticleService
{
    public function settings(): array
    {
        $setting = SiteSetting::query()->where('key', 'content.automation')->first();
        $value = is_array($setting?->value) ? $setting->value : [];
        $dailyTime = (string) ($value['daily_time'] ?? '09:00');

        return [
            'enabled' => (bool) ($value['enabled'] ?? true),
            'auto_publish' => false,
            'daily_time' => preg_match('/^\d{2}:\d{2}$/', $dailyTime) ? $dailyTime : '09:00',
            'timezone' => (string) ($value['timezone'] ?? 'Asia/Kabul'),
            'category_id' => isset($value['category_id']) ? (int) $value['category_id'] : null,
            'themes' => trim((string) ($value['themes'] ?? 'ERP, accounting, database, POS, business systems, industry software, digital transformation and practical software buying guidance for Afghanistan')),
            'last_generated_on' => $value['last_generated_on'] ?? null,
            'last_page_id' => $value['last_page_id'] ?? null,
            'last_error' => $value['last_error'] ?? null,
        ];
    }

    public function saveSettings(array $data): void
    {
        $current = $this->settings();

        SiteSetting::query()->updateOrCreate(
            ['key' => 'content.automation'],
            [
                'group' => 'content',
                'value' => [
                    'enabled' => (bool) ($data['enabled'] ?? false),
                    'auto_publish' => false,
                    'daily_time' => $data['daily_time'] ?? $current['daily_time'],
                    'timezone' => 'Asia/Kabul',
                    'category_id' => $data['category_id'] ?? $current['category_id'],
                    'themes' => trim((string) ($data['themes'] ?? $current['themes'])),
                    'last_generated_on' => $current['last_generated_on'],
                    'last_page_id' => $current['last_page_id'],
                    'last_error' => $current['last_error'],
                ],
                'type' => 'json',
                'is_public' => false,
            ],
        );
    }

    public function due(): bool
    {
        $settings = $this->settings();

        if (! $settings['enabled']) {
            return false;
        }

        $now = now($settings['timezone']);
        if ($settings['last_generated_on'] === $now->toDateString()) {
            return false;
        }

        [$hour, $minute] = array_map('intval', explode(':', $settings['daily_time']));

        return $now->greaterThanOrEqualTo($now->copy()->setTime($hour, $minute));
    }

    public function generate(WebsiteContentAiService $ai, bool $force = false): ContentPage
    {
        $settings = $this->settings();

        if (! $force && ! $this->due()) {
            throw new RuntimeException('Automatic article generation is not due yet.');
        }

        $latestPeriod = SearchConsoleMetric::query()->max('period_end');
        $searchOpportunities = SearchConsoleMetric::query()
            ->when($latestPeriod, fn ($q) => $q->where('period_end', $latestPeriod))
            ->where('metric_type', 'query')
            ->where('impressions', '>=', 3)
            ->orderByDesc('impressions')
            ->limit(40)
            ->get(['dimension','clicks','impressions','ctr','position'])
            ->toArray();

        // Drafts awaiting review are included so the AI does not pick a topic or slug that an
        // earlier unpublished draft already uses.
        $existing = ContentPage::query()
            ->whereIn('type', ['article','service','solution','industry','page','product'])
            ->where(fn ($query) => $query->where('status', 'published')->orWhere('type', 'article'))
            ->orderByDesc('updated_at')
            ->get(['slug','type','status','title','primary_query'])
            ->map(fn (ContentPage $page) => [
                'slug' => $page->slug,
                'type' => $page->type,
                'status' => $page->status,
                'title' => (array) $page->title,
                'primary_query' => (array) $page->primary_query,
            ])->values()->all();

        try {
            $generated = $ai->generateArticle([
                'editorial_themes' => $settings['themes'],
                'search_console_period_end' => $latestPeriod,
                'search_opportunities' => $searchOpportunities,
                'existing_content' => $existing,
            ]);

            $this->validateGeneratedArticle($generated, $existing);

            $slug = $this->uniqueSlug($generated);

            $categoryId = $settings['category_id'];
            if ($categoryId && ! ArticleCategory::query()->whereKey($categoryId)->where('active', true)->exists()) {
                $categoryId = null;
            }
            $categoryId ??= ArticleCategory::query()->where('slug', 'business-software-planning')->value('id');

            $page = ContentPage::query()->create([
                'type' => 'article',
                'article_category_id' => $categoryId,
                'slug' => $slug,
                'title' => $this->translations($generated['title'] ?? []),
                'eyebrow' => $this->translations($generated['eyebrow'] ?? []),
                'summary' => $this->translations($generated['summary'] ?? []),
                'body' => $this->htmlTranslations($generated['body'] ?? []),
                'meta_title' => $this->translations($generated['meta_title'] ?? []),
                'meta_description' => $this->translations($generated['meta_description'] ?? []),
                'primary_query' => $this->translations($generated['primary_query'] ?? []),
                'search_intent' => 'informational',
                'robots_directive' => config('website.discovery.default_robots'),
                'sitemap_included' => true,
                'sitemap_priority' => 0.7,
                'sitemap_change_frequency' => 'monthly',
                'sitemap_last_modified_at' => now(),
                'metadata' => [
                    'related_slugs' => collect($generated['related_slugs'] ?? [])
                        ->map(fn ($slug) => Str::slug((string) $slug))
                        ->filter(fn ($slug) => ContentPage::query()->where('slug', $slug)->exists())
                        ->unique()->take(8)->values()->all(),
                    'automation' => [
                        'generated' => true,
                        'editor_note' => mb_substr(strip_tags((string) ($generated['editor_note'] ?? '')), 0, 500),
                        'generated_at' => now()->toIso8601String(),
                        'editorial_reviewed' => false,
                        'fact_checked' => false,
                        'translations_reviewed' => false,
                        'reviewed_content_hash' => null,
                        'quality' => [
                            'distinctive_value' => mb_substr(strip_tags((string) data_get($generated, 'quality.distinctive_value', '')), 0, 1000),
                            'facts_to_verify' => collect(data_get($generated, 'quality.facts_to_verify', []))->map(fn ($item) => mb_substr(strip_tags((string) $item), 0, 500))->filter()->take(12)->values()->all(),
                            'sources_needed' => collect(data_get($generated, 'quality.sources_needed', []))->map(fn ($item) => mb_substr(strip_tags((string) $item), 0, 500))->filter()->take(12)->values()->all(),
                        ],
                    ],
                ],
                'status' => 'review',
                'featured' => false,
                'sort_order' => 1300,
                'published_at' => null,
            ]);

            $this->recordResult($page, null);

            return $page;
        } catch (\Throwable $exception) {
            $this->recordResult(null, $exception->getMessage());
            throw $exception;
        }
    }

    private function validateGeneratedArticle(array $generated, array $existing): void
    {
        if (data_get($generated, 'quality.publishable') !== true) {
            throw new RuntimeException('The AI could not produce a draft that passed the people-first quality check. Try a stronger topic or add better source context.');
        }

        $distinctiveValue = trim(strip_tags((string) data_get($generated, 'quality.distinctive_value', '')));
        if (mb_strlen($distinctiveValue) < 40) {
            throw new RuntimeException('The generated draft does not explain what unique value it adds for the reader.');
        }

        $required = ['title', 'summary', 'body', 'meta_title', 'meta_description', 'primary_query'];
        $minimumWords = ['en' => 280, 'fa' => 200, 'ps' => 200];

        foreach (['en', 'fa', 'ps'] as $locale) {
            foreach ($required as $field) {
                if (trim(strip_tags((string) data_get($generated, "{$field}.{$locale}", ''))) === '') {
                    throw new RuntimeException("The generated article is incomplete: {$field}.{$locale} is missing.");
                }
            }

            $body = (string) data_get($generated, "body.{$locale}", '');
            if ($this->wordCount(strip_tags($body)) < $minimumWords[$locale]) {
                throw new RuntimeException("The generated {$locale} article is too thin for editorial review.");
            }

            if (substr_count(mb_strtolower($body), '<h2') < 2) {
                throw new RuntimeException("The generated {$locale} article needs clearer substantive sections.");
            }
        }

        $existingQueries = collect($existing)
            ->flatMap(fn (array $page) => array_values((array) ($page['primary_query'] ?? [])))
            ->map(fn ($query) => $this->normalizeTopic((string) $query))
            ->filter()
            ->unique();

        foreach ((array) ($generated['primary_query'] ?? []) as $query) {
            $normalized = $this->normalizeTopic((string) $query);
            if ($normalized !== '' && $existingQueries->contains($normalized)) {
                throw new RuntimeException('The AI selected a primary search topic already covered by existing website content.');
            }
        }
    }

    private function uniqueSlug(array $generated): string
    {
        $candidates = [
            Str::slug((string) ($generated['slug'] ?? '')),
            Str::limit(Str::slug((string) data_get($generated, 'title.en', '')), 110, ''),
            Str::limit(Str::slug((string) data_get($generated, 'primary_query.en', '')), 110, ''),
        ];

        foreach ($candidates as $candidate) {
            $candidate = trim($candidate, '-');
            if ($candidate !== '' && ! ContentPage::query()->where('slug', $candidate)->exists()) {
                return $candidate;
            }
        }

        throw new RuntimeException('AI selected an invalid or duplicate article slug. Generate again.');
    }

    private function normalizeTopic(string $value): string
    {
        $value = mb_strtolower(trim(strip_tags($value)));
        $value = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $value) ?? $value;

        return trim(preg_replace('/\s+/u', ' ', $value) ?? $value);
    }

    private function wordCount(string $value): int
    {
        return $value === '' ? 0 : count(preg_split('/\s+/u', trim($value), -1, PREG_SPLIT_NO_EMPTY) ?: []);
    }

    private function recordResult(?ContentPage $page, ?string $error): void
    {
        $current = $this->settings();

        SiteSetting::query()->updateOrCreate(
            ['key' => 'content.automation'],
            [
                'group' => 'content',
                'value' => [
                    ...$current,
                    'last_generated_on' => $page ? now('Asia/Kabul')->toDateString() : $current['last_generated_on'],
                    'last_page_id' => $page?->id ?? $current['last_page_id'],
                    'last_error' => $error ? mb_substr($error, 0, 1000) : null,
                ],
                'type' => 'json',
                'is_public' => false,
            ],
        );
    }

    private function translations(mixed $values): array
    {
        $values = is_array($values) ? $values : [];

        return collect(['en','fa','ps'])->mapWithKeys(function (string $locale) use ($values): array {
            $value = trim(strip_tags((string) ($values[$locale] ?? '')));
            return [$locale => mb_substr($value, 0, 60000)];
        })->filter()->all();
    }

    private function htmlTranslations(mixed $values): array
    {
        $values = is_array($values) ? $values : [];

        return collect(['en','fa','ps'])->mapWithKeys(function (string $locale) use ($values): array {
            $value = (string) ($values[$locale] ?? '');
            $value = preg_replace('/<\s*(script|iframe|object|embed)[^>]*>.*?<\/\s*\1\s*>/is', '', $value) ?? $value;
            $value = preg_replace('/\s+on\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $value) ?? $value;
            $value = preg_replace('/javascript\s*:/i', '', $value) ?? $value;
            $value = strip_tags($value, '<h2><h3><p><ul><ol><li><strong><em><a>');
            return [$locale => mb_substr(trim($value), 0, 60000)];
        })->filter()->all();
    }
}
