<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_ai_insights', function (Blueprint $table): void {
            $table->id();
            $table->string('provider', 40);
            $table->string('model', 120);
            $table->longText('content');
            $table->json('input_summary')->nullable();
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });

        DB::table('website_page_views')
            ->where(function ($query): void {
                foreach ([
                    '%guzzlehttp/%',
                    '%curl/%',
                    '%wget/%',
                    '%python-requests/%',
                    '%postmanruntime/%',
                    '%okhttp/%',
                    '%axios/%',
                    '%headlesschrome/%',
                    '%lighthouse%',
                    '%pagespeed%',
                ] as $pattern) {
                    $query->orWhereRaw('LOWER(user_agent) LIKE ?', [$pattern]);
                }
            })
            ->update([
                'is_bot' => true,
                'bot_name' => DB::raw("CASE
                    WHEN LOWER(user_agent) LIKE '%guzzlehttp/%' THEN 'Automated HTTP client'
                    WHEN LOWER(user_agent) LIKE '%curl/%' THEN 'cURL'
                    WHEN LOWER(user_agent) LIKE '%wget/%' THEN 'Wget'
                    WHEN LOWER(user_agent) LIKE '%python-requests/%' THEN 'Python requests'
                    WHEN LOWER(user_agent) LIKE '%headlesschrome/%' THEN 'Headless Chrome'
                    WHEN LOWER(user_agent) LIKE '%lighthouse%' THEN 'Lighthouse'
                    WHEN LOWER(user_agent) LIKE '%pagespeed%' THEN 'PageSpeed'
                    ELSE 'Automated client'
                END"),
            ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_ai_insights');
    }
};
