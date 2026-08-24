<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_pages', function (Blueprint $table): void {
            $table->boolean('sitemap_included')->default(true)->index()->after('robots_directive');
            $table->decimal('sitemap_priority', 2, 1)->default(0.8)->after('sitemap_included');
            $table->string('sitemap_change_frequency', 20)->nullable()->after('sitemap_priority');
            $table->timestamp('sitemap_last_modified_at')->nullable()->after('sitemap_change_frequency');
        });
    }

    public function down(): void
    {
        Schema::table('content_pages', function (Blueprint $table): void {
            $table->dropIndex(['sitemap_included']);
            $table->dropColumn([
                'sitemap_included',
                'sitemap_priority',
                'sitemap_change_frequency',
                'sitemap_last_modified_at',
            ]);
        });
    }
};
