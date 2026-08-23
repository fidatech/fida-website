<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('description')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->boolean('active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('article_authors', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name', 120);
            $table->json('role')->nullable();
            $table->json('bio')->nullable();
            $table->text('avatar_url')->nullable();
            $table->boolean('active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('content_pages', function (Blueprint $table): void {
            $table->foreignId('article_category_id')
                ->nullable()
                ->after('type')
                ->constrained('article_categories')
                ->nullOnDelete();
            $table->foreignId('article_author_id')
                ->nullable()
                ->after('article_category_id')
                ->constrained('article_authors')
                ->nullOnDelete();
        });

        Schema::table('leads', function (Blueprint $table): void {
            $table->string('interest_slug', 190)->nullable()->after('source_url')->index();
        });

        $now = now();
        DB::table('article_categories')->insert([
            [
                'slug' => 'business-software-planning',
                'name' => json_encode(['en' => 'Business Software Planning', 'fa' => 'پلان‌گذاری نرم‌افزار تجارتی', 'ps' => 'د سوداګریز سافټویر پلان'], JSON_UNESCAPED_UNICODE),
                'description' => json_encode(['en' => 'Practical guidance for evaluating requirements, scope, implementation and software partners.', 'fa' => 'راهنمای عملی برای ارزیابی نیازها، محدوده، تطبیق و شریک نرم‌افزاری.', 'ps' => 'د اړتیاوو، حدودو، پلي کولو او سافټویر شریک د ارزونې عملي لارښود.'], JSON_UNESCAPED_UNICODE),
                'meta_title' => json_encode(['en' => 'Business Software Planning Insights | Fida Technologies', 'fa' => 'دیدگاه‌های پلان نرم‌افزار تجارتی | فیدا', 'ps' => 'د سوداګریز سافټویر پلان لیدلوري | فیدا'], JSON_UNESCAPED_UNICODE),
                'meta_description' => json_encode(['en' => 'Practical multilingual guidance for planning, selecting and implementing business software.', 'fa' => 'راهنمای عملی چندزبانه برای پلان، انتخاب و تطبیق نرم‌افزار تجارتی.', 'ps' => 'د سوداګریز سافټویر د پلان، ټاکنې او پلي کولو څوژبی عملي لارښود.'], JSON_UNESCAPED_UNICODE),
                'active' => true,
                'sort_order' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'accounting-finance-systems',
                'name' => json_encode(['en' => 'Accounting & Finance Systems', 'fa' => 'سیستم‌های حسابداری و مالی', 'ps' => 'د حسابدارۍ او مالي سیسټمونه'], JSON_UNESCAPED_UNICODE),
                'description' => json_encode(['en' => 'Guidance for evaluating accounting controls, connected operations and financial reporting.', 'fa' => 'راهنمای ارزیابی کنترول حسابداری، عملیات مرتبط و گزارش‌دهی مالی.', 'ps' => 'د حسابدارۍ کنټرول، تړلو عملیاتو او مالي راپورونو د ارزونې لارښود.'], JSON_UNESCAPED_UNICODE),
                'meta_title' => json_encode(['en' => 'Accounting Software Insights | Fida Technologies', 'fa' => 'دیدگاه‌های نرم‌افزار حسابداری | فیدا', 'ps' => 'د حسابدارۍ سافټویر لیدلوري | فیدا'], JSON_UNESCAPED_UNICODE),
                'meta_description' => json_encode(['en' => 'Practical multilingual guidance about accounting software controls, workflows and reports.', 'fa' => 'راهنمای عملی چندزبانه درباره کنترول، روند و گزارش نرم‌افزار حسابداری.', 'ps' => 'د حسابدارۍ سافټویر کنټرولونو، بهیرونو او راپورونو څوژبی عملي لارښود.'], JSON_UNESCAPED_UNICODE),
                'active' => true,
                'sort_order' => 20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $planningCategoryId = DB::table('article_categories')->where('slug', 'business-software-planning')->value('id');
        $accountingCategoryId = DB::table('article_categories')->where('slug', 'accounting-finance-systems')->value('id');

        DB::table('content_pages')
            ->where('type', 'article')
            ->whereNull('article_category_id')
            ->where('slug', 'accounting-software-selection-afghanistan')
            ->update(['article_category_id' => $accountingCategoryId]);
        DB::table('content_pages')
            ->where('type', 'article')
            ->whereNull('article_category_id')
            ->where('slug', '!=', 'accounting-software-selection-afghanistan')
            ->update(['article_category_id' => $planningCategoryId]);

        DB::table('content_pages')->where('type', 'service')->orderBy('id')->get()->each(function (object $page): void {
            $metadata = json_decode((string) $page->metadata, true) ?: [];

            if (array_key_exists('service', $metadata)) {
                return;
            }

            $metadata['service'] = [
                'engagement' => ['en' => 'Confirmed workflow and written scope', 'fa' => 'روند تأییدشده و محدوده کتبی', 'ps' => 'تایید شوی بهیر او لیکلي حدود'],
                'delivery' => ['en' => 'Reviewable stages defined for the engagement', 'fa' => 'مراحل قابل بررسی مطابق همکاری', 'ps' => 'د همکارۍ لپاره د کتنې وړ پړاوونه'],
                'handover' => ['en' => 'Documented handover and agreed support boundaries', 'fa' => 'تحویل مستند و حدود توافق‌شده پشتیبانی', 'ps' => 'مستند سپارل او هوکړه شوي د ملاتړ حدود'],
                'capabilities' => [
                    ['en' => 'Workflow discovery', 'fa' => 'شناخت روند', 'ps' => 'د کاري بهیر پېژندنه'],
                    ['en' => 'Scope confirmation', 'fa' => 'تأیید محدوده', 'ps' => 'د حدودو تایید'],
                    ['en' => 'Testing and review', 'fa' => 'آزمایش و بررسی', 'ps' => 'ازموینه او کتنه'],
                    ['en' => 'Controlled handover', 'fa' => 'تحویل کنترول‌شده', 'ps' => 'کنټرول شوې سپارنه'],
                ],
            ];

            DB::table('content_pages')->where('id', $page->id)->update([
                'metadata' => json_encode($metadata, JSON_UNESCAPED_UNICODE),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table): void {
            $table->dropIndex(['interest_slug']);
            $table->dropColumn('interest_slug');
        });

        Schema::table('content_pages', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('article_author_id');
            $table->dropConstrainedForeignId('article_category_id');
        });

        Schema::dropIfExists('article_authors');
        Schema::dropIfExists('article_categories');
    }
};
