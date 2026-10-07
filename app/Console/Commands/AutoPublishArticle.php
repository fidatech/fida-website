<?php

namespace App\Console\Commands;

use App\Services\AutoArticleService;
use App\Services\WebsiteContentAiService;
use Illuminate\Console\Command;
use Throwable;

class AutoPublishArticle extends Command
{
    protected $signature = 'website:auto-article {--force : Generate even when the daily schedule is not due}';

    protected $description = 'Generate the next multilingual website article from search opportunities and editorial themes';

    public function handle(AutoArticleService $automation, WebsiteContentAiService $ai): int
    {
        if (! $this->option('force') && ! $automation->due()) {
            $this->line('No article is due.');

            return self::SUCCESS;
        }

        try {
            $page = $automation->generate($ai, (bool) $this->option('force'));
            $this->info("Generated {$page->slug} ({$page->status}).");

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());
            report($exception);

            return self::FAILURE;
        }
    }
}
