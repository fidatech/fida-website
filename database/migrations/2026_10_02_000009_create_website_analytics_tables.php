<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_page_views', function (Blueprint $table): void {
            $table->id();
            $table->timestamp('occurred_at')->index();
            $table->date('day')->index();
            $table->char('visitor_key', 64)->index();
            $table->char('session_key', 64)->nullable()->index();
            $table->string('path', 512)->index();
            $table->string('route_name', 128)->nullable();
            $table->string('page_slug', 180)->nullable()->index();
            $table->string('locale', 5)->default('en')->index();
            $table->text('referrer_url')->nullable();
            $table->string('referrer_host')->nullable()->index();
            $table->string('source', 100)->nullable()->index();
            $table->string('medium', 50)->nullable()->index();
            $table->string('campaign', 150)->nullable();
            $table->string('search_engine', 50)->nullable()->index();
            $table->string('search_query')->nullable();
            $table->string('country_code', 2)->nullable()->index();
            $table->string('device_type', 30)->nullable()->index();
            $table->string('browser', 60)->nullable();
            $table->string('platform', 60)->nullable();
            $table->boolean('is_bot')->default(false)->index();
            $table->string('bot_name', 100)->nullable()->index();
            $table->string('user_agent', 1000)->nullable();
            $table->char('ip_hash', 64)->nullable();
            $table->unsignedSmallInteger('status_code')->nullable();
            $table->timestamps();

            $table->index(['day', 'is_bot']);
            $table->index(['day', 'page_slug']);
            $table->index(['day', 'country_code']);
        });

        Schema::create('website_analytics_events', function (Blueprint $table): void {
            $table->id();
            $table->timestamp('occurred_at')->index();
            $table->date('day')->index();
            $table->char('visitor_key', 64)->nullable()->index();
            $table->char('session_key', 64)->nullable()->index();
            $table->string('event_name', 80)->index();
            $table->string('event_label')->nullable();
            $table->string('path', 512)->nullable();
            $table->string('page_slug', 180)->nullable()->index();
            $table->string('locale', 5)->default('en')->index();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['day', 'event_name']);
        });

        Schema::create('search_console_metrics', function (Blueprint $table): void {
            $table->id();
            $table->string('metric_type', 30)->index();
            $table->string('dimension', 512);
            $table->unsignedInteger('clicks')->default(0);
            $table->unsignedInteger('impressions')->default(0);
            $table->decimal('ctr', 8, 6)->default(0);
            $table->decimal('position', 8, 2)->nullable();
            $table->date('period_start');
            $table->date('period_end');
            $table->timestamp('imported_at');
            $table->timestamps();

            $table->index(['metric_type', 'impressions']);
            $table->index(['period_end', 'metric_type']);
        });

        $snapshot = database_path('data/gsc-snapshot-2026-10-02.json');

        if (is_file($snapshot)) {
            $payload = json_decode((string) file_get_contents($snapshot), true);
            $now = now();
            $rows = [];

            foreach (($payload['metrics'] ?? []) as $type => $metrics) {
                foreach ($metrics as $metric) {
                    $rows[] = [
                        'metric_type' => $type,
                        'dimension' => mb_substr((string) ($metric['dimension'] ?? ''), 0, 512),
                        'clicks' => (int) ($metric['clicks'] ?? 0),
                        'impressions' => (int) ($metric['impressions'] ?? 0),
                        'ctr' => (float) ($metric['ctr'] ?? 0),
                        'position' => isset($metric['position']) ? (float) $metric['position'] : null,
                        'period_start' => $payload['period_start'],
                        'period_end' => $payload['period_end'],
                        'imported_at' => $now,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            foreach (array_chunk($rows, 250) as $chunk) {
                DB::table('search_console_metrics')->insert($chunk);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('search_console_metrics');
        Schema::dropIfExists('website_analytics_events');
        Schema::dropIfExists('website_page_views');
    }
};
