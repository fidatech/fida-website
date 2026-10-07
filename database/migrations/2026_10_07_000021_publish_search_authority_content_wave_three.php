<?php

use Database\Seeders\SearchAuthorityContentWaveThreeSeeder;
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

        app(SearchAuthorityContentWaveThreeSeeder::class)->run();
    }

    public function down(): void
    {
        if (! Schema::hasTable('content_pages')) {
            return;
        }

        DB::table('content_pages')->whereIn('slug', [
            'receivables-payables-software-afghanistan',
            'auto-parts-shop-software-afghanistan',
            'agriculture-software-afghanistan-guide',
            'document-approval-workflow-afghanistan-guide',
            'ngo-project-management-software-afghanistan',
            'asset-management-software-afghanistan-guide',
            'clinic-management-software-afghanistan',
            'school-fee-accounting-software-afghanistan',
            'construction-finance-software-afghanistan',
            'property-rental-management-software-afghanistan',
        ])->delete();
    }
};
