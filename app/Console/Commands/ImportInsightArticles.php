<?php

namespace App\Console\Commands;

use App\Services\InsightArticleImporter;
use Illuminate\Console\Command;

class ImportInsightArticles extends Command
{
    protected $signature = 'website:import-insights
        {--check : Validate the article files without writing to the database}
        {--strict : Exit with a failure when any article file is invalid}';

    protected $description = 'Publish approved Insights articles stored in database/content/insights';

    public function handle(InsightArticleImporter $importer): int
    {
        if ($this->option('check')) {
            $errors = $importer->validate();
            foreach ($errors as $file => $message) {
                $this->error("{$file}: {$message}");
            }
            $this->info($errors === [] ? 'All Insights article files are valid.' : count($errors).' invalid article file(s).');

            return $errors === [] ? self::SUCCESS : self::FAILURE;
        }

        $result = $importer->import();

        foreach (['created', 'updated'] as $outcome) {
            foreach ($result[$outcome] as $slug) {
                $this->info(ucfirst($outcome)." {$slug}.");
            }
        }

        foreach ($result['skipped'] as $slug) {
            $this->warn("Skipped {$slug}: a page with this slug is managed in the admin panel.");
        }

        foreach ($result['errors'] as $file => $message) {
            $this->error("{$file}: {$message}");
        }

        $this->line(sprintf(
            '%d created, %d updated, %d unchanged, %d skipped, %d invalid.',
            count($result['created']), count($result['updated']), count($result['unchanged']),
            count($result['skipped']), count($result['errors']),
        ));

        return $this->option('strict') && $result['errors'] !== [] ? self::FAILURE : self::SUCCESS;
    }
}
