<?php

namespace App\Support;

use App\Jobs\SubmitIndexNowUrls;
use App\Models\ContentPage;

final class DiscoveryPublisher
{
    public function schedule(ContentPage $page, ?string $previousSlug = null): void
    {
        if (! config('website.indexable') || blank(config('website.indexnow.key'))) {
            return;
        }

        SubmitIndexNowUrls::dispatch($this->urlsFor($page, $previousSlug))->afterResponse();
    }

    public function urlsFor(ContentPage $page, ?string $previousSlug = null): array
    {
        $slugs = collect([$page->slug, $previousSlug])->filter()->unique();

        return collect(array_keys(config('website.locales')))
            ->flatMap(function (string $locale) use ($slugs): array {
                return $slugs->map(fn (string $slug): string => LocalizedUrl::path('/'.$slug, $locale))->all();
            })
            ->unique()
            ->values()
            ->all();
    }
}
