<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One-off cleanup requested by Fida: remove the AI-generated article drafts that the daily
     * generator left in review. Published articles, hand-written drafts and generated drafts
     * that an editor already reviewed are not touched.
     */
    public function up(): void
    {
        if (! Schema::hasTable('content_pages')) {
            return;
        }

        $ids = DB::table('content_pages')
            ->select(['id', 'metadata'])
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
            ->pluck('id')
            ->all();

        if ($ids !== []) {
            DB::table('content_pages')->whereIn('id', $ids)->delete();
        }
    }

    public function down(): void
    {
        // Deleted drafts cannot be restored.
    }
};
