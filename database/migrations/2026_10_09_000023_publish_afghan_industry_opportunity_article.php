<?php

use Database\Seeders\AfghanIndustryOpportunitySeeder;
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

        if (! DB::table('content_pages')->where('slug', 'about')->exists()) {
            return;
        }

        app(AfghanIndustryOpportunitySeeder::class)->run();
    }

    public function down(): void
    {
        if (! Schema::hasTable('content_pages')) {
            return;
        }

        DB::table('content_pages')
            ->where('slug', 'industry-software-opportunities-afghanistan')
            ->delete();
    }
};
