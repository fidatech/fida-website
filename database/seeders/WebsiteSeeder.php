<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class WebsiteSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            ContentPage::query()->updateOrCreate(['slug' => $page['slug']], $page);
        }
    }

    private function pages(): array
    {
        return [
            $this->page(
                slug: 'erp-systems-afghanistan',
                title: ['en' => 'ERP Systems in Afghanistan', 'fa' => 'سیستم‌های ERP در افغانستان', 'ps' => 'په افغانستان کې ERP سیسټمونه'],
                eyebrow: ['en' => 'Connected business operations', 'fa' => 'عملیات یکپارچه تجارتی', 'ps' => 'یوځای سوداګریز عملیات'],
                summary: [
                    'en' => 'Bring finance, inventory, HR, sales, procurement and management reporting into one secure system designed for Afghan businesses.',
                    'fa' => 'مالی، گدام، منابع بشری، فروش، تدارکات و گزارش‌دهی مدیریتی را در یک سیستم امن برای تجارت‌های افغانستان یکجا سازید.',
                    'ps' => 'مالي، زېرمتون، بشري سرچینې، پلور، تدارکات او مدیریتي راپورونه د افغان سوداګریو لپاره په یوه خوندي سیسټم کې یوځای کړئ.',
                ],
                body: [
                    'en' => '<h2>One source of truth for your business</h2><p>Fida Technologies develops modular ERP platforms for companies that need stronger financial control, traceable approvals and real-time operational visibility.</p><h2>Modules designed around real workflows</h2><ul><li>International-standard accounting and multi-currency ledgers</li><li>Sales, purchases, inventory and warehouse control</li><li>HR, attendance, payroll, roles and permissions</li><li>Approvals, audit logs, alerts and management dashboards</li><li>Branch-level reporting with consolidated financial statements</li></ul><h2>Local understanding, professional architecture</h2><p>Our systems support English, Dari and Pashto, while remaining ready for APIs, mobile applications and future integrations.</p>',
                    'fa' => '<h2>یک منبع واحد و دقیق برای تجارت شما</h2><p>Fida Technologies پلتفرم‌های ERP ماژولار را برای شرکت‌هایی توسعه می‌دهد که به کنترول قوی مالی، تأییدی‌های قابل پیگیری و دید زنده عملیاتی نیاز دارند.</p><h2>ماژول‌های مطابق روند واقعی</h2><ul><li>حسابداری معیاری و دفاتر چندارزی</li><li>فروش، خرید، موجودی و مدیریت گدام</li><li>منابع بشری، حاضری، معاشات و صلاحیت‌ها</li><li>تأییدی‌ها، ثبت فعالیت‌ها، هشدارها و داشبوردها</li><li>گزارش‌های شعبه‌ای و صورت‌های مالی تلفیقی</li></ul>',
                    'ps' => '<h2>ستاسو د سوداګرۍ لپاره یوه کره سرچینه</h2><p>Fida Technologies د هغو شرکتونو لپاره ماډیولر ERP پلېټفارمونه جوړوي چې قوي مالي کنټرول، د تاییدونو بشپړ تعقیب او د عملیاتو ژوندی انځور غواړي.</p><h2>د واقعي کاري بهیر مطابق ماډیولونه</h2><ul><li>نړیواله معیاري حسابداري او څو اسعارو لیجرونه</li><li>پلور، پېرود، زېرمتون او ګدام</li><li>بشري سرچینې، حاضري، معاشونه او صلاحیتونه</li><li>تاییدونه، د فعالیت ثبت، خبرتیاوې او ډشبورډونه</li><li>د څانګو راپورونه او یوځای مالي راپورونه</li></ul>',
                ],
                metaTitle: ['en' => 'ERP Systems in Afghanistan | Fida Technologies', 'fa' => 'سیستم‌های ERP در افغانستان | Fida Technologies', 'ps' => 'په افغانستان کې ERP سیسټمونه | Fida Technologies'],
                metaDescription: ['en' => 'Modern ERP systems for Afghan businesses: accounting, inventory, HR, approvals, multi-currency operations and management reporting.', 'fa' => 'سیستم‌های مدرن ERP برای تجارت‌های افغانستان؛ حسابداری، گدام، منابع بشری، تأییدی‌ها و گزارش‌دهی.', 'ps' => 'د افغان سوداګریو لپاره عصري ERP؛ حسابداري، زېرمتون، بشري سرچینې، تاییدونه او راپورونه.'],
            ),
            $this->page(
                slug: 'custom-software-development-afghanistan',
                title: ['en' => 'Custom Software Development in Afghanistan', 'fa' => 'توسعه نرم‌افزار اختصاصی در افغانستان', 'ps' => 'په افغانستان کې د ځانګړي سافټویر جوړول'],
                eyebrow: ['en' => 'Built around your workflow', 'fa' => 'مطابق روند کاری شما', 'ps' => 'ستاسو د کاري بهیر مطابق'],
                summary: ['en' => 'Secure web and business applications designed for your processes, users and growth plans.', 'fa' => 'وب‌اپلیکیشن‌ها و سیستم‌های امن مطابق روندها، کاربران و پلان رشد شما.', 'ps' => 'خوندي وېب او سوداګریز اپلېکېشنونه ستاسو د پروسو، کاروونکو او ودې مطابق.'],
                body: ['en' => '<h2>Software should fit the business</h2><p>We analyze your operation, simplify the workflow and develop a maintainable system with clear permissions, auditability and reporting.</p>', 'fa' => '<h2>نرم‌افزار باید با تجارت هماهنگ باشد</h2><p>عملیات شما را تحلیل، روند را ساده و یک سیستم قابل توسعه با صلاحیت‌ها، ثبت فعالیت و گزارش‌دهی روشن می‌سازیم.</p>', 'ps' => '<h2>سافټویر باید له سوداګرۍ سره برابر وي</h2><p>ستاسو عملیات څېړو، کاري بهیر ساده کوو او د روښانه صلاحیتونو، ثبت او راپورونو لرونکی سیسټم جوړوو.</p>'],
                metaTitle: ['en' => 'Software Development Company in Afghanistan | Fida', 'fa' => 'شرکت توسعه نرم‌افزار در افغانستان | فیدا', 'ps' => 'په افغانستان کې د سافټویر شرکت | فیدا'],
                metaDescription: ['en' => 'Custom software development for businesses in Afghanistan, including ERP, SaaS, portals, APIs and mobile backends.', 'fa' => 'توسعه نرم‌افزار اختصاصی، ERP، SaaS، پورتال، API و بک‌اند موبایل در افغانستان.', 'ps' => 'په افغانستان کې ځانګړی سافټویر، ERP، SaaS، پورټلونه، API او موبایل بیک‌اېنډ.'],
            ),
            $this->page(
                slug: 'accounting-software-afghanistan',
                title: ['en' => 'Accounting Software in Afghanistan', 'fa' => 'نرم‌افزار حسابداری در افغانستان', 'ps' => 'په افغانستان کې د حسابدارۍ سافټویر'],
                eyebrow: ['en' => 'Clear financial control', 'fa' => 'کنترول روشن مالی', 'ps' => 'روښانه مالي کنټرول'],
                summary: ['en' => 'Multi-currency accounting, ledgers, journals and professional financial statements for growing businesses.', 'fa' => 'حسابداری چندارزی، دفاتر، ژورنال و صورت‌های مالی حرفه‌ای برای تجارت‌های در حال رشد.', 'ps' => 'د ودې په حال سوداګریو لپاره څو اسعارو حسابداري، لیجرونه، ژورنالونه او مالي راپورونه.'],
                body: ['en' => '<h2>Know where the business stands</h2><p>Track every transaction with linked entries, account statements, approvals and reliable balance sheet, profit and loss, trial balance and cash-flow reports.</p>', 'fa' => '<h2>موقعیت واقعی مالی تجارت را بدانید</h2><p>هر معامله را با ثبت‌های مرتبط، صورت‌حساب، تأییدی و گزارش‌های بیلانس، سود و زیان، تراز آزمایشی و جریان نقدی پیگیری کنید.</p>', 'ps' => '<h2>د سوداګرۍ واقعي مالي حالت وپېژنئ</h2><p>هره معامله له تړلو ثبتونو، حساب‌لیکونو، تاییدونو، بیلانس، ګټې او زیان، ازمایښتي بیلانس او نغدي جریان سره تعقیب کړئ.</p>'],
                metaTitle: ['en' => 'Accounting Software Afghanistan | Fida Technologies', 'fa' => 'نرم‌افزار حسابداری افغانستان | Fida Technologies', 'ps' => 'د حسابدارۍ سافټویر افغانستان | Fida Technologies'],
                metaDescription: ['en' => 'Professional multi-currency accounting software for Afghan companies with ledgers, statements, approvals and financial reports.', 'fa' => 'نرم‌افزار حسابداری چندارزی برای شرکت‌های افغانستان با دفاتر، صورت‌حساب، تأییدی و گزارش‌های مالی.', 'ps' => 'د افغان شرکتونو لپاره څو اسعارو حسابداري، لیجرونه، حساب‌لیکونه، تاییدونه او مالي راپورونه.'],
            ),
            $this->page(
                slug: 'mobile-app-development-afghanistan',
                title: ['en' => 'Mobile App Development in Afghanistan', 'fa' => 'توسعه اپلیکیشن موبایل در افغانستان', 'ps' => 'په افغانستان کې د موبایل اپلېکېشن جوړول'],
                eyebrow: ['en' => 'Android, iOS and reliable backends', 'fa' => 'اندروید، iOS و بک‌اند قابل اعتماد', 'ps' => 'Android، iOS او باوري بیک‌اېنډ'],
                summary: ['en' => 'Fast multilingual mobile applications connected to secure APIs and practical administration systems.', 'fa' => 'اپلیکیشن‌های سریع و چندزبانه متصل به API امن و سیستم مدیریتی عملی.', 'ps' => 'چټک څوژبي موبایل اپلېکېشنونه له خوندي API او عملي مدیریتي سیسټم سره.'],
                body: ['en' => '<h2>One product across mobile and web</h2><p>We develop responsive mobile experiences, secure Laravel APIs, offline-aware workflows, notifications and administration platforms.</p>', 'fa' => '<h2>یک محصول در موبایل و وب</h2><p>تجربه سریع موبایل، API امن لاراول، روندهای مناسب اینترنت ضعیف، اعلان‌ها و سیستم مدیریت را توسعه می‌دهیم.</p>', 'ps' => '<h2>یو محصول په موبایل او وېب کې</h2><p>چټک موبایل تجربه، خوندي Laravel API، د کمزوري انټرنېټ لپاره مناسب بهیر، خبرتیاوې او مدیریتي سیسټم جوړوو.</p>'],
                metaTitle: ['en' => 'Mobile App Development Afghanistan | Fida Technologies', 'fa' => 'توسعه اپلیکیشن موبایل افغانستان | فیدا', 'ps' => 'د موبایل اپلېکېشن جوړول افغانستان | فیدا'],
                metaDescription: ['en' => 'Android and iOS application development in Afghanistan with secure Laravel APIs and multilingual admin systems.', 'fa' => 'توسعه اپلیکیشن اندروید و iOS در افغانستان با API امن لاراول و سیستم مدیریتی چندزبانه.', 'ps' => 'په افغانستان کې Android او iOS اپلېکېشنونه له خوندي Laravel API او څوژبي اډمین سره.'],
            ),
        ];
    }

    private function page(string $slug, array $title, array $eyebrow, array $summary, array $body, array $metaTitle, array $metaDescription): array
    {
        return [
            'slug' => $slug,
            'type' => 'solution',
            'title' => $title,
            'eyebrow' => $eyebrow,
            'summary' => $summary,
            'body' => $body,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'status' => 'published',
            'featured' => true,
            'published_at' => now(),
        ];
    }
}
