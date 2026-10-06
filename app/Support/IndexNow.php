<?php

namespace App\Support;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class IndexNow
{
    public function submit(array $urls): Response
    {
        $key = (string) config('website.indexnow.key');
        $host = parse_url((string) config('website.url'), PHP_URL_HOST);

        if (! config('website.indexable')) {
            throw new RuntimeException('IndexNow submission is disabled while WEBSITE_INDEXABLE is false.');
        }

        if ($key === '') {
            throw new RuntimeException('INDEXNOW_KEY is not configured.');
        }

        if (! is_string($host) || $host === '') {
            throw new RuntimeException('APP_URL must contain a valid public hostname.');
        }

        $urls = collect($urls)
            ->filter(fn (mixed $url): bool => is_string($url) && parse_url($url, PHP_URL_HOST) === $host)
            ->unique()
            ->values()
            ->all();

        if ($urls === []) {
            throw new RuntimeException('No same-host URLs were provided for submission.');
        }

        return Http::acceptJson()
            ->timeout(10)
            ->post((string) config('website.indexnow.endpoint'), [
                'host' => $host,
                'key' => $key,
                'keyLocation' => rtrim((string) config('website.url'), '/').'/'.config('website.indexnow.key').'.txt',
                'urlList' => $urls,
            ])
            ->throw();
    }
}
