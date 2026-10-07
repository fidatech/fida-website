<?php

use Database\Seeders\SearchAuthorityExpansionSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('content_pages')) {
            return;
        }

        // Production already contains the public website. Fresh installs are
        // populated later by DatabaseSeeder so tests can control fixtures.
        if (! DB::table('content_pages')->where('slug', 'about')->exists()) {
            return;
        }

        app(SearchAuthorityExpansionSeeder::class)->run();
    }

    public function down(): void
    {
        if (! Schema::hasTable('content_pages')) {
            return;
        }

        DB::table('content_pages')
            ->whereIn('slug', [
                'software-company-afghanistan',
                'database-systems-afghanistan',
                'pos-software-afghanistan',
            ])
            ->delete();
    }
};
