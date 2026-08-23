<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleAuthor extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'role',
        'bio',
        'avatar_url',
        'active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'role' => 'array',
            'bio' => 'array',
            'active' => 'boolean',
        ];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(ContentPage::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
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
}
