<?php

namespace App\Console\Commands;

use App\Models\ContentPage;
use App\Support\IndexNow;
use App\Support\LocalizedUrl;
use Illuminate\Console\Command;
use Throwable;

class SubmitIndexNow extends Command
{
    protected $signature = 'website:indexnow {urls?* : Optional same-host URLs; all published URLs are used when omitted}';

    protected $description = 'Submit published website URLs to search engines through IndexNow';

    public function handle(IndexNow $indexNow): int
    {
        $urls = $this->argument('urls');

        if ($urls === []) {
            $urls = $this->publishedUrls();
        }

        try {
            $response = $indexNow->submit($urls);
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info(sprintf('Submitted %d URLs to IndexNow (HTTP %d).', count($urls), $response->status()));

        return self::SUCCESS;
    }

    private function publishedUrls(): array
    {
        $paths = ContentPage::published()
            ->orderBy('slug')
            ->pluck('slug')
            ->map(fn (string $slug): string => '/'.$slug)
            ->prepend('/')
            ->all();

        return collect(config('website.locales'))
            ->keys()
            ->flatMap(fn (string $locale) => array_map(
                fn (string $path): string => LocalizedUrl::path($path, $locale),
                $paths,
            ))
            ->unique()
            ->values()
            ->all();
    }
}
