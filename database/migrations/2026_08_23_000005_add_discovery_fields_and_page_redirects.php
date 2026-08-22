<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_pages', function (Blueprint $table): void {
            $table->json('primary_query')->nullable()->after('meta_description');
            $table->string('search_intent', 30)->nullable()->after('primary_query');
            $table->string('robots_directive', 120)
                ->default('index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1')
                ->after('search_intent');
            $table->text('social_image_url')->nullable()->after('robots_directive');
            $table->string('author_name', 120)->nullable()->after('social_image_url');
            $table->string('reviewer_name', 120)->nullable()->after('author_name');
            $table->timestamp('reviewed_at')->nullable()->after('reviewer_name');
        });

        Schema::create('page_redirects', function (Blueprint $table): void {
            $table->id();
            $table->string('source_path')->unique();
            $table->string('target_path');
            $table->unsignedSmallInteger('status_code')->default(301);
            $table->boolean('active')->default(true)->index();
            $table->unsignedBigInteger('hits')->default(0);
            $table->timestamp('last_hit_at')->nullable();
            $table->timestamps();
        });

        DB::table('content_pages')
            ->where('slug', 'erp-systems-afghanistan')
            ->update([
                'primary_query' => json_encode([
                    'en' => 'ERP systems in Afghanistan',
                    'fa' => 'سیستم‌های ERP در افغانستان',
                    'ps' => 'په افغانستان کې ERP سیسټمونه',
                ], JSON_UNESCAPED_UNICODE),
                'search_intent' => 'commercial',
            ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('page_redirects');

        Schema::table('content_pages', function (Blueprint $table): void {
            $table->dropColumn([
                'primary_query',
                'search_intent',
                'robots_directive',
                'social_image_url',
                'author_name',
                'reviewer_name',
                'reviewed_at',
            ]);
        });
    }
};
