<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('content_pages') || ! Schema::hasColumn('content_pages', 'primary_query')) {
            return;
        }

        foreach ($this->profiles() as $slug => $profile) {
            $page = DB::table('content_pages')
                ->select(['id', 'body', 'primary_query', 'search_intent'])
                ->where('slug', $slug)
                ->first();

            if (! $page) {
                continue;
            }

            $updates = [];

            if ($this->jsonIsEmpty($page->primary_query)) {
                $updates['primary_query'] = $this->json($profile['primary_query']);
            }

            if (blank($page->search_intent)) {
                $updates['search_intent'] = $profile['search_intent'];
            }

            if (isset($profile['body']) && $this->hasEnglishBody($page->body, $profile['previous_body_en'])) {
                $updates['body'] = $this->json($profile['body']);
            }

            if ($updates !== []) {
                $updates['updated_at'] = now();
                DB::table('content_pages')->where('id', $page->id)->update($updates);
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('content_pages') || ! Schema::hasColumn('content_pages', 'primary_query')) {
            return;
        }

        foreach ($this->profiles() as $slug => $profile) {
            $page = DB::table('content_pages')
                ->select(['id', 'body', 'primary_query', 'search_intent'])
                ->where('slug', $slug)
                ->first();

            if (! $page) {
                continue;
            }

            $updates = [];

            if ($this->jsonEquals($page->primary_query, $profile['primary_query'])) {
                $updates['primary_query'] = null;
            }

            if ($page->search_intent === $profile['search_intent']) {
                $updates['search_intent'] = null;
            }

            if (isset($profile['body']) && $this->jsonEquals($page->body, $profile['body'])) {
                $updates['body'] = $this->json([
                    'en' => $profile['previous_body_en'],
                    'fa' => $profile['previous_body_fa'],
                    'ps' => $profile['previous_body_ps'],
                ]);
            }

            if ($updates !== []) {
                $updates['updated_at'] = now();
                DB::table('content_pages')->where('id', $page->id)->update($updates);
            }
        }
    }

    private function profiles(): array
    {
        return [
            'custom-software-development-afghanistan' => [
                'primary_query' => [
                    'en' => 'custom software development in Afghanistan',
                    'fa' => 'توسعه نرم‌افزار اختصاصی در افغانستان',
                    'ps' => 'په افغانستان کې د ځانګړي سافټویر جوړول',
                ],
                'search_intent' => 'commercial',
                'previous_body_en' => '<h2>Software should fit the business</h2><p>We analyze your operation, simplify the workflow and develop a maintainable system with clear permissions, auditability and reporting.</p>',
                'previous_body_fa' => '<h2>نرم‌افزار باید با تجارت هماهنگ باشد</h2><p>عملیات شما را تحلیل، روند را ساده و یک سیستم قابل توسعه با صلاحیت‌ها، ثبت فعالیت و گزارش‌دهی روشن می‌سازیم.</p>',
                'previous_body_ps' => '<h2>سافټویر باید له سوداګرۍ سره برابر وي</h2><p>ستاسو عملیات څېړو، کاري بهیر ساده کوو او د روښانه صلاحیتونو، ثبت او راپورونو لرونکی سیسټم جوړوو.</p>',
                'body' => [
                    'en' => '<h2>Custom software should fit the business</h2><p>Custom software is useful when spreadsheets, disconnected applications or a generic package can no longer support the way an organization works. Fida Technologies studies the workflow first, then designs a maintainable system around the people, decisions, controls and reports that matter.</p><h2>What we can develop</h2><ul><li>ERP and MIS platforms that connect finance and operations</li><li>Workflow applications for approvals, records and reporting</li><li>Customer, supplier, employee and partner portals</li><li>SaaS products with subscriptions and administration tools</li><li>Secure APIs, integrations and mobile application backends</li><li>Modern replacements for difficult legacy applications</li></ul><h2>Designed for practical operations in Afghanistan</h2><p>A project can include English, Dari and Pashto interfaces, right-to-left layouts, multi-currency accounting, branch-level access, roles and permissions, activity history, document workflows and exports. The approved scope determines which capabilities are included.</p><h2>From discovery to deployment</h2><ol><li><strong>Discover:</strong> map users, responsibilities, existing data, problems and required decisions.</li><li><strong>Design:</strong> agree on the product scope, interface direction, architecture and delivery milestones.</li><li><strong>Build:</strong> develop and test the system through reviewable releases.</li><li><strong>Deploy:</strong> prepare the environment, migrate approved data, train users and document handover.</li><li><strong>Improve:</strong> support the released scope and estimate new requirements separately.</li></ol><h2>How to request a useful estimate</h2><p>Describe the current workflow, the people who use it, the records you keep, the reports you need and the main problem you want to solve. We can then recommend whether a focused application, integration, existing Fida product or broader custom platform is the better fit.</p>',
                    'fa' => '<h2>نرم‌افزار اختصاصی باید با تجارت هماهنگ باشد</h2><p>زمانی که فایل‌های اکسل، برنامه‌های جداگانه یا یک نرم‌افزار عمومی دیگر پاسخ‌گوی روش کار سازمان نباشد، نرم‌افزار اختصاصی ارزش پیدا می‌کند. Fida Technologies نخست روند کاری را بررسی و سپس سیستم قابل توسعه‌ای را مطابق کاربران، تصمیم‌ها، کنترول‌ها و گزارش‌های مهم طراحی می‌کند.</p><h2>چه سیستم‌هایی می‌توانیم توسعه دهیم</h2><ul><li>پلتفرم‌های ERP و MIS برای یکپارچه‌سازی مالی و عملیات</li><li>برنامه‌های مدیریت روند، تأییدی، اسناد و گزارش‌دهی</li><li>پورتال مشتری، تأمین‌کننده، کارمند و شریک</li><li>محصولات SaaS با اشتراک و ابزار مدیریت</li><li>API امن، یکپارچه‌سازی و بک‌اند اپلیکیشن موبایل</li><li>جایگزین مدرن برای سیستم‌های قدیمی و دشوار</li></ul><h2>طراحی‌شده برای عملیات واقعی در افغانستان</h2><p>پروژه می‌تواند رابط انگلیسی، دری و پشتو، چیدمان راست‌به‌چپ، حسابداری چندارزی، دسترسی شعبه‌ای، نقش و صلاحیت، تاریخچه فعالیت، گردش اسناد و خروجی معلومات را شامل شود. محدوده تأییدشده مشخص می‌کند کدام قابلیت‌ها شامل است.</p><h2>از شناخت تا راه‌اندازی</h2><ol><li><strong>شناخت:</strong> کاربران، مسئولیت‌ها، معلومات موجود، مشکلات و تصمیم‌های لازم مشخص می‌شود.</li><li><strong>طراحی:</strong> محدوده محصول، جهت رابط، معماری و مراحل تحویل توافق می‌شود.</li><li><strong>توسعه:</strong> سیستم در نسخه‌های قابل بررسی ساخته و آزمایش می‌شود.</li><li><strong>راه‌اندازی:</strong> محیط آماده، معلومات تأییدشده منتقل، کاربران آموزش و تحویل مستند می‌شود.</li><li><strong>بهبود:</strong> محدوده نشرشده پشتیبانی و نیازهای جدید جداگانه برآورد می‌شود.</li></ol><h2>برای دریافت برآورد مفید چه معلوماتی بدهید</h2><p>روند فعلی، کاربران، اسناد، گزارش‌های لازم و مشکل اصلی را توضیح دهید. سپس می‌توانیم مشخص کنیم یک برنامه متمرکز، یکپارچه‌سازی، محصول موجود فیدا یا پلتفرم اختصاصی گسترده کدام مناسب‌تر است.</p>',
                    'ps' => '<h2>ځانګړی سافټویر باید له سوداګرۍ سره برابر وي</h2><p>کله چې Excel فایلونه، جلا پروګرامونه یا عمومي سافټویر نور د ادارې د کار طریقه نه شي پوره کولی، ځانګړی سافټویر ارزښت پیدا کوي. Fida Technologies لومړی کاري بهیر څېړي او وروسته د مهمو کاروونکو، پرېکړو، کنټرولونو او راپورونو مطابق د پراختیا وړ سیسټم ډیزاین کوي.</p><h2>موږ کوم سیسټمونه جوړولی شو</h2><ul><li>د مالي او عملیاتو د یوځای کولو لپاره ERP او MIS پلېټفارمونه</li><li>د تاییدونو، اسنادو او راپورونو لپاره کاري بهیر اپلېکېشنونه</li><li>د مشتریانو، عرضه کوونکو، کارکوونکو او شریکانو پورټلونه</li><li>د ګډون او اډمین وسیلو لرونکي SaaS محصولات</li><li>خوندي API، ادغامونه او د موبایل اپلېکېشن بیک‌اېنډ</li><li>د زړو او ستونزمنو سیسټمونو عصري بدیلونه</li></ul><h2>په افغانستان کې د عملي عملیاتو لپاره ډیزاین</h2><p>پروژه کېدای شي انګلیسي، دري او پښتو انترفېسونه، ښي نه چپ ډیزاین، څو اسعارو حسابداري، د څانګو لاسرسی، رولونه او صلاحیتونه، د فعالیت تاریخ، د اسنادو بهیر او export شامل کړي. تایید شوي حدود ټاکي چې کومې وړتیاوې پکې شاملې دي.</p><h2>له پېژندنې تر پلي کولو</h2><ol><li><strong>پېژندنه:</strong> کاروونکي، مسؤلیتونه، شته معلومات، ستونزې او اړینې پرېکړې ټاکل کېږي.</li><li><strong>ډیزاین:</strong> د محصول حدود، انترفېس، معماري او د سپارلو پړاوونه هوکړه کېږي.</li><li><strong>جوړول:</strong> سیسټم د کتنې وړ نسخو کې جوړېږي او ازمویل کېږي.</li><li><strong>پلي کول:</strong> چاپېریال چمتو، تایید شوي معلومات لېږدول، کاروونکي روزل او مستند سپارل کېږي.</li><li><strong>ښه‌والی:</strong> خپاره شوي حدود ملاتړ کېږي او نوې اړتیاوې جلا اټکل کېږي.</li></ol><h2>د ګټور اټکل لپاره څه معلومات ورکړئ</h2><p>اوسنی کاري بهیر، کاروونکي، اسناد، اړین راپورونه او اصلي ستونزه تشریح کړئ. بیا موږ وړاندیز کولی شو چې یو ځانګړی اپلېکېشن، ادغام، د فیدا موجود محصول یا پراخ ځانګړی پلېټفارم کوم یو مناسب دی.</p>',
                ],
            ],
            'technology-company-afghanistan' => [
                'primary_query' => [
                    'en' => 'technology company in Afghanistan',
                    'fa' => 'شرکت تکنالوژی در افغانستان',
                    'ps' => 'په افغانستان کې د ټکنالوژۍ شرکت',
                ],
                'search_intent' => 'local',
            ],
        ];
    }

    private function jsonIsEmpty(mixed $value): bool
    {
        if ($value === null || $value === '' || $value === 'null') {
            return true;
        }

        $decoded = json_decode((string) $value, true);

        return ! is_array($decoded) || collect($decoded)->filter(fn (mixed $item): bool => filled($item))->isEmpty();
    }

    private function hasEnglishBody(mixed $value, string $expected): bool
    {
        $decoded = json_decode((string) $value, true);

        return is_array($decoded) && ($decoded['en'] ?? null) === $expected;
    }

    private function jsonEquals(mixed $value, array $expected): bool
    {
        $decoded = json_decode((string) $value, true);

        return is_array($decoded) && $decoded === $expected;
    }

    private function json(array $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }
};
