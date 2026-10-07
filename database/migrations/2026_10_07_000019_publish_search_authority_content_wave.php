<?php

use Database\Seeders\SearchAuthorityContentWaveSeeder;
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

        app(SearchAuthorityContentWaveSeeder::class)->run();
    }

    public function down(): void
    {
        if (! Schema::hasTable('content_pages')) {
            return;
        }

        DB::table('content_pages')->whereIn('slug', [
            'erp-cost-afghanistan',
            'database-for-business-afghanistan',
            'supermarket-pos-software-afghanistan-guide',
            'warehouse-inventory-software-afghanistan-guide',
            'accounting-software-afghanistan-buyers-guide',
            'ngo-erp-finance-software-afghanistan-guide',
            'sarafi-software-afghanistan-guide',
            'pharmacy-software-afghanistan-guide',
        ])->delete();
    }
};
