<?php

use Database\Seeders\SearchAuthorityContentWaveTwoSeeder;
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

        app(SearchAuthorityContentWaveTwoSeeder::class)->run();
    }

    public function down(): void
    {
        if (! Schema::hasTable('content_pages')) {
            return;
        }

        DB::table('content_pages')->whereIn('slug', [
            'multi-currency-accounting-software-afghanistan',
            'cash-bank-management-software-afghanistan',
            'payroll-software-afghanistan-guide',
            'restaurant-pos-software-afghanistan',
            'wholesale-distribution-software-afghanistan',
            'fmcg-distribution-software-afghanistan',
            'cargo-logistics-software-afghanistan-guide',
            'mining-erp-afghanistan-guide',
        ])->delete();
    }
};
