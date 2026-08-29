<?php

namespace App\Console\Commands;

use App\Support\WebsiteReleaseAudit;
use Illuminate\Console\Command;

class AuditWebsiteRelease extends Command
{
    protected $signature = 'website:release-audit
        {--production : Include production environment and indexing checks}
        {--show-warnings : Print warning details as well as blockers}
        {--json : Output the complete report as JSON}';

    protected $description = 'Audit multilingual content, discovery controls, internal links and production release settings';

    public function handle(WebsiteReleaseAudit $audit): int
    {
        $report = $audit->run((bool) $this->option('production'));

        if ($this->option('json')) {
            $this->line((string) json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            return $report['ready'] ? self::SUCCESS : self::FAILURE;
        }

        $visibleFindings = collect($report['findings'])
            ->filter(fn (array $finding): bool => $finding['severity'] === 'blocker' || (bool) $this->option('show-warnings'))
            ->map(fn (array $finding): array => [
                strtoupper($finding['severity']),
                $finding['code'],
                $finding['page'] ? '/'.$finding['page'] : 'Website',
                $finding['message'],
            ])
            ->all();

        if ($visibleFindings !== []) {
            $this->table(['Severity', 'Code', 'Page', 'Finding'], $visibleFindings);
        }

        $summary = $report['summary'];
        $this->line(sprintf(
            'Release audit: %d public pages, %d localized routes, %d related links, %d blockers, %d warnings.',
            $summary['public_pages'],
            $summary['localized_routes'],
            $summary['related_links'],
            $summary['blockers'],
            $summary['warnings'],
        ));

        if ($summary['warnings'] > 0 && ! $this->option('show-warnings')) {
            $warningSummary = collect($summary['warning_codes'])
                ->map(fn (int $count, string $code): string => "{$code}={$count}")
                ->implode(', ');
            $this->comment('Warning summary: '.$warningSummary.'.');
            $this->comment('Run with --show-warnings or --json to review non-blocking findings.');
        }

        if (! $report['ready']) {
            $this->error('Release audit failed. Resolve every blocker before launch.');

            return self::FAILURE;
        }

        $this->info('Release audit passed with no blockers.');

        return self::SUCCESS;
    }
}
