<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContentPage extends Model
{
    protected $fillable = [
        'type',
        'slug',
        'title',
        'eyebrow',
        'summary',
        'body',
        'meta_title',
        'meta_description',
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
            'schema' => 'array',
            'metadata' => 'array',
            'featured' => 'boolean',
            'published_at' => 'datetime',
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
}
