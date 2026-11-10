<?php

// One-off production cleanup requested by Fida on 2026-11-10.
// Deletes article drafts in review that the daily generator created and no editor reviewed.
// A JSON backup of every deleted row is written to storage/app before deletion.

require getcwd().'/vendor/autoload.php';
$app = require getcwd().'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::table('content_pages')
    ->where('type', 'article')
    ->where('status', 'review')
    ->whereNull('published_at')
    ->get()
    ->filter(function (object $page): bool {
        $metadata = json_decode((string) $page->metadata, true);
        $automation = is_array($metadata) ? ($metadata['automation'] ?? null) : null;

        return is_array($automation)
            && filter_var($automation['generated'] ?? false, FILTER_VALIDATE_BOOL)
            && ! filter_var($automation['editorial_reviewed'] ?? false, FILTER_VALIDATE_BOOL);
    })
    ->values();

echo 'Unreviewed generated drafts found: '.$rows->count().PHP_EOL;

if ($rows->isEmpty()) {
    exit(0);
}

$backup = storage_path('app/deleted-auto-article-drafts-'.date('Ymd-His').'.json');
$written = file_put_contents($backup, json_encode($rows->all(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
if ($written === false || $written === 0) {
    fwrite(STDERR, 'Backup could not be written; nothing was deleted.'.PHP_EOL);
    exit(1);
}
chmod($backup, 0600);
echo 'Backup written: storage/app/'.basename($backup).PHP_EOL;

foreach ($rows as $row) {
    echo ' - '.$row->slug.PHP_EOL;
}

$deleted = DB::table('content_pages')->whereIn('id', $rows->pluck('id')->all())->delete();
echo 'Deleted: '.$deleted.PHP_EOL;

$remaining = DB::table('content_pages')->where('type', 'article')->where('status', 'review')->count();
echo 'Article drafts still in review (hand-written or reviewed): '.$remaining.PHP_EOL;
