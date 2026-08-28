<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentPage extends Model
{
    protected $fillable = [
        'type',
        'article_category_id',
        'article_author_id',
        'slug',
        'title',
        'eyebrow',
        'summary',
        'body',
        'meta_title',
        'meta_description',
        'primary_query',
        'search_intent',
        'robots_directive',
        'sitemap_included',
        'sitemap_priority',
        'sitemap_change_frequency',
        'sitemap_last_modified_at',
        'social_image_url',
        'author_name',
        'reviewer_name',
        'reviewed_at',
        'schema',
        'metadata',
        'status',
        'featured',
        'sort_order',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'eyebrow' => 'array',
            'summary' => 'array',
            'body' => 'array',
            'meta_title' => 'array',
            'meta_description' => 'array',
            'primary_query' => 'array',
            'schema' => 'array',
            'metadata' => 'array',
            'featured' => 'boolean',
            'sitemap_included' => 'boolean',
            'sitemap_priority' => 'decimal:1',
            'sitemap_last_modified_at' => 'datetime',
            'published_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where(function (Builder $query): void {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeSitemapEligible(Builder $query): Builder
    {
        return $query
            ->where('sitemap_included', true)
            ->where('robots_directive', 'not like', 'noindex%');
    }

    public function articleCategory(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function articleAuthor(): BelongsTo
    {
        return $this->belongsTo(ArticleAuthor::class);
    }

    public function translation(string $field, ?string $locale = null): mixed
    {
        $locale ??= app()->getLocale();
        $translations = $this->getAttribute($field);

        if (! is_array($translations)) {
            return $translations;
        }

        return $translations[$locale]
            ?? $translations[config('website.default_locale')]
            ?? collect($translations)->first();
    }

    public function faqs(?string $locale = null): array
    {
        $locale ??= app()->getLocale();
        $fallbackLocale = config('website.default_locale');

        return collect(data_get($this->metadata, 'faqs', []))
            ->map(function (array $faq) use ($locale, $fallbackLocale): array {
                $question = trim((string) data_get($faq, "question.{$locale}"));
                $answer = trim((string) data_get($faq, "answer.{$locale}"));
                $contentLocale = $locale;

                if ($question === '' || $answer === '') {
                    $question = trim((string) data_get($faq, "question.{$fallbackLocale}"));
                    $answer = trim((string) data_get($faq, "answer.{$fallbackLocale}"));
                    $contentLocale = $fallbackLocale;
                }

                return [
                    'question' => $question,
                    'answer' => $answer,
                    'locale' => $contentLocale,
                ];
            })
            ->filter(fn (array $faq): bool => $faq['question'] !== '' && $faq['answer'] !== '')
            ->values()
            ->all();
    }

    public function metadataTranslation(string $path, ?string $locale = null): mixed
    {
        $locale ??= app()->getLocale();
        $value = data_get($this->metadata, $path);

        if (! is_array($value)) {
            return $value;
        }

        return $value[$locale]
            ?? $value[config('website.default_locale')]
            ?? collect($value)->first();
    }

    public function primaryQuery(?string $locale = null): string
    {
        return trim((string) $this->translation('primary_query', $locale));
    }

    public function robotsDirective(): string
    {
        $directive = trim((string) $this->robots_directive);

        return array_key_exists($directive, config('website.discovery.robots'))
            ? $directive
            : (string) config('website.discovery.default_robots');
    }

    public function sitemapPriority(float $fallback = 0.8): string
    {
        $priority = (float) ($this->sitemap_priority ?? $fallback);

        if ($priority < 0.1 || $priority > 1.0) {
            $priority = $fallback;
        }

        return number_format($priority, 1, '.', '');
    }

    public function sitemapChangeFrequency(?string $fallback = null): ?string
    {
        $frequency = (string) ($this->sitemap_change_frequency ?: $fallback);

        return array_key_exists($frequency, config('website.sitemap.change_frequencies', []))
            ? $frequency
            : null;
    }

    public function socialImage(): ?string
    {
        return filled($this->social_image_url)
            ? (string) $this->social_image_url
            : config('website.social_image');
    }

    public function byline(): ?string
    {
        return $this->articleAuthor?->name ?: (filled($this->author_name) ? (string) $this->author_name : null);
    }

    public function publicationStatus(): string
    {
        if ($this->status === 'published' && $this->published_at?->isFuture()) {
            return 'scheduled';
        }

        return (string) ($this->status ?: 'draft');
    }

    public function relatedSlugs(): array
    {
        return collect(data_get($this->metadata, 'related_slugs', []))
            ->filter(fn (mixed $slug): bool => is_string($slug) && $slug !== $this->slug)
            ->unique()
            ->values()
            ->all();
    }

    public function serviceProfile(?string $locale = null): ?array
    {
        if ($this->type !== 'service' || ! is_array(data_get($this->metadata, 'service'))) {
            return null;
        }

        $locale ??= app()->getLocale();

        return [
            'engagement' => (string) $this->metadataTranslation('service.engagement', $locale),
            'delivery' => (string) $this->metadataTranslation('service.delivery', $locale),
            'handover' => (string) $this->metadataTranslation('service.handover', $locale),
            'capabilities' => $this->localizedMetadataList('service.capabilities', $locale),
        ];
    }

    public function solutionProfile(?string $locale = null): ?array
    {
        if ($this->type !== 'solution' || ! is_array(data_get($this->metadata, 'solution'))) {
            return null;
        }

        $locale ??= app()->getLocale();

        return [
            'outcomes' => (string) $this->metadataTranslation('solution.outcomes', $locale),
            'control' => (string) $this->metadataTranslation('solution.control', $locale),
            'decisions' => (string) $this->metadataTranslation('solution.decisions', $locale),
            'capabilities' => $this->localizedMetadataList('solution.capabilities', $locale),
        ];
    }

    public function industryProfile(?string $locale = null): ?array
    {
        if ($this->type !== 'industry' || ! is_array(data_get($this->metadata, 'industry'))) {
            return null;
        }

        $locale ??= app()->getLocale();

        return [
            'operations' => (string) $this->metadataTranslation('industry.operations', $locale),
            'control' => (string) $this->metadataTranslation('industry.control', $locale),
            'decisions' => (string) $this->metadataTranslation('industry.decisions', $locale),
            'capabilities' => $this->localizedMetadataList('industry.capabilities', $locale),
        ];
    }

    public function productProfile(?string $locale = null): ?array
    {
        if ($this->type !== 'product' || ! is_array(data_get($this->metadata, 'product'))) {
            return null;
        }

        $locale ??= app()->getLocale();
        $features = collect(data_get($this->metadata, 'product.features', []))
            ->map(function (mixed $feature) use ($locale): string {
                if (! is_array($feature)) {
                    return trim((string) $feature);
                }

                return trim((string) ($feature[$locale]
                    ?? $feature[config('website.default_locale')]
                    ?? collect($feature)->first()));
            })
            ->filter()
            ->values()
            ->all();

        $accent = (string) data_get($this->metadata, 'product.accent', '#c9ff4a');

        if (! preg_match('/^#[0-9a-f]{6}$/i', $accent)) {
            $accent = '#c9ff4a';
        }

        return [
            'code' => (string) data_get($this->metadata, 'product.code', strtoupper($this->slug)),
            'accent' => $accent,
            'category' => (string) $this->metadataTranslation('product.category', $locale),
            'platform' => (string) $this->metadataTranslation('product.platform', $locale),
            'deployment' => (string) $this->metadataTranslation('product.deployment', $locale),
            'status' => (string) $this->metadataTranslation('product.status', $locale),
            'features' => $features,
        ];
    }

    public function callToAction(?string $locale = null): ?array
    {
        if (! is_array(data_get($this->metadata, 'cta'))) {
            return null;
        }

        $locale ??= app()->getLocale();
        $availableIntents = array_keys(config('website.lead_intents', []));
        $primaryIntent = (string) data_get($this->metadata, 'cta.primary_intent', 'proposal');
        $secondaryIntent = (string) data_get($this->metadata, 'cta.secondary_intent');

        if (! in_array($primaryIntent, $availableIntents, true)) {
            $primaryIntent = 'proposal';
        }

        if (! in_array($secondaryIntent, $availableIntents, true)) {
            $secondaryIntent = null;
        }

        return [
            'heading' => trim((string) $this->metadataTranslation('cta.heading', $locale)),
            'description' => trim((string) $this->metadataTranslation('cta.description', $locale)),
            'primary_label' => trim((string) $this->metadataTranslation('cta.primary_label', $locale)),
            'primary_intent' => $primaryIntent,
            'secondary_label' => trim((string) $this->metadataTranslation('cta.secondary_label', $locale)),
            'secondary_intent' => $secondaryIntent,
        ];
    }

    private function localizedMetadataList(string $path, string $locale): array
    {
        return collect(data_get($this->metadata, $path, []))
            ->map(function (mixed $item) use ($locale): string {
                if (! is_array($item)) {
                    return trim((string) $item);
                }

                return trim((string) ($item[$locale]
                    ?? $item[config('website.default_locale')]
                    ?? collect($item)->first()));
            })
            ->filter()
            ->values()
            ->all();
    }
}
