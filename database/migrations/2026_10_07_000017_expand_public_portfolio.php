<?php

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

        $page = DB::table('content_pages')
            ->select(['id'])
            ->where('slug', 'projects')
            ->first();

        if (! $page) {
            return;
        }

        $body = [
            'en' => '<h2>Core ERP and business platforms</h2><ul><li><strong>Realist ERP</strong> — real estate, property, construction, contracts, accounting and operations.</li><li><strong>Petromin ERP</strong> — ERP for engine-oil and lubricant businesses.</li><li><strong>Tameer ERP</strong> — ERP for cement and construction-material businesses.</li><li><strong>WeSarafi</strong> — Sarafi, exchange, remittance and financial operations.</li><li><strong>Prime Sarafi</strong> — multi-currency Sarafi and remittance platform.</li><li><strong>YuanRemit</strong> — Yuan/CNY remittance management.</li><li><strong>CargoFlow</strong> — cargo, shipment and logistics management.</li><li><strong>Darmal ERP</strong> — pharmacy, pharmaceutical wholesale and distribution.</li><li><strong>OGRAYI</strong> — mobile account and balance management.</li><li><strong>Fida Business Suite</strong> — installable desktop business and Sarafi/Hawala management.</li><li><strong>Chilgoza Market System</strong> — offline-first pine-nut market purchasing, sales and accounting.</li><li><strong>Fida Mining ERP</strong> — mining operations, production, equipment, finance and reporting.</li><li><strong>Approval-Based Expense System</strong> — expense requests, approvals, payment control and management reporting.</li><li><strong>HesabPro</strong> — small-business accounting, inventory and daily operations.</li></ul><h2>Industry-specific systems</h2><ul><li><strong>Solar & Electrical ERP</strong> — ERP for solar, electrical and electrician companies.</li><li><strong>Market Tenant Management System</strong> — shops, tenants, rents, payments and market operations.</li><li><strong>Building Management System (BMS)</strong> — buildings, units, tenants, services, maintenance and finance.</li><li><strong>Salt Mining ERP</strong> — extraction, processing, warehouses, HR, finance and sales.</li><li><strong>Carton Factory ERP</strong> — raw materials, production, inventory, sales and finance.</li><li><strong>Tailor Shop Management System</strong> — customers, measurements, orders, tailoring workflow and payments.</li><li><strong>Garment Business ERP</strong> — purchasing, production, inventory, wholesale/retail and finance.</li></ul><h2>Web and digital platforms</h2><ul><li><strong>Real Estate Company Website Platform</strong> — property/project publishing, CMS, company pages and lead workflows.</li><li><strong>Technology Company Website Platform</strong> — corporate technology website with CMS, solutions, products, industries, projects and RFQ workflows.</li><li><strong>StatementGrid</strong> — web-based statement and document utility platform.</li><li><strong>ContentOS</strong> — AI-assisted multi-site research, publishing and distribution platform.</li></ul><h2>Portfolio policy</h2><p>This page presents Fida Technologies products, reusable solution platforms and approved public project categories. Availability and implementation status vary by solution. Client identities, private source code, screenshots and measurable implementation results are published only when permission and supporting evidence are available.</p>',
            'fa' => '<h2>ERP و پلتفرم‌های اصلی تجارتی</h2><ul><li><strong>Realist ERP</strong> — املاک، ساختمان، قراردادها، حسابداری و عملیات.</li><li><strong>Petromin ERP</strong> — ERP برای شرکت‌های روغن موتور و لوبریکنت.</li><li><strong>Tameer ERP</strong> — ERP برای شرکت‌های سمنت و مواد ساختمانی.</li><li><strong>WeSarafi</strong> — صرافی، تبادله، حواله و عملیات مالی.</li><li><strong>Prime Sarafi</strong> — پلتفرم چندارزی صرافی و حواله.</li><li><strong>YuanRemit</strong> — مدیریت حواله یوان/CNY.</li><li><strong>CargoFlow</strong> — مدیریت کارگو، محموله و لوژستیک.</li><li><strong>Darmal ERP</strong> — دواخانه، عمده‌فروشی و توزیع دارویی.</li><li><strong>OGRAYI</strong> — مدیریت حساب و بیلانس موبایل.</li><li><strong>Fida Business Suite</strong> — نرم‌افزار دسکتاپ برای تجارت و صرافی/حواله.</li><li><strong>Chilgoza Market System</strong> — خرید، فروش و حسابداری آفلاین‌فرست برای بازار چلغوزه.</li><li><strong>Fida Mining ERP</strong> — عملیات معدن، تولید، تجهیزات، مالی و گزارش‌دهی.</li><li><strong>Approval-Based Expense System</strong> — درخواست مصرف، تأییدی، کنترول پرداخت و گزارش مدیریت.</li><li><strong>HesabPro</strong> — حسابداری، موجودی و عملیات روزمره تجارت کوچک.</li></ul><h2>سیستم‌های تخصصی صنایع</h2><ul><li><strong>Solar & Electrical ERP</strong> — ERP برای شرکت‌های سولر، برق و الکتریشن.</li><li><strong>Market Tenant Management System</strong> — دکان‌ها، مستأجران، کرایه، پرداخت و عملیات مارکیت.</li><li><strong>Building Management System (BMS)</strong> — ساختمان، واحدها، مستأجر، خدمات، مراقبت و مالی.</li><li><strong>Salt Mining ERP</strong> — استخراج نمک، پروسس، گدام‌ها، HR، مالی و فروش.</li><li><strong>Carton Factory ERP</strong> — مواد خام، تولید، موجودی، فروش و مالی.</li><li><strong>Tailor Shop Management System</strong> — مشتری، اندازه، سفارش، روند خیاطی و پرداخت.</li><li><strong>Garment Business ERP</strong> — خرید، تولید، موجودی، عمده/پرچون و مالی.</li></ul><h2>پلتفرم‌های وب و دیجیتال</h2><ul><li><strong>Real Estate Company Website Platform</strong> — نشر املاک و پروژه‌ها، CMS و مدیریت لید.</li><li><strong>Technology Company Website Platform</strong> — وب‌سایت شرکتی تکنالوژی با CMS، راهکارها، محصولات، صنایع، پروژه‌ها و RFQ.</li><li><strong>StatementGrid</strong> — ابزار وب برای اسناد و استیتمنت‌ها.</li><li><strong>ContentOS</strong> — پلتفرم چندسایتی تحقیق، نشر و توزیع محتوا با کمک AI.</li></ul><h2>سیاست پورتفولیو</h2><p>این صفحه محصولات، پلتفرم‌های قابل استفاده مجدد و دسته‌های پروژه‌ای تأییدشده فیدا را نشان می‌دهد. وضعیت و موجودیت هر راهکار متفاوت است. هویت مشتری، سورس خصوصی، تصاویر و نتایج قابل اندازه‌گیری فقط با اجازه و شواهد مناسب نشر می‌شود.</p>',
            'ps' => '<h2>اصلي ERP او سوداګریز پلېټفارمونه</h2><ul><li><strong>Realist ERP</strong> — املاک، ودانیزې چارې، قراردادونه، حسابداري او عملیات.</li><li><strong>Petromin ERP</strong> — د انجن تېلو او لوبریکینټ شرکتونو ERP.</li><li><strong>Tameer ERP</strong> — د سمنټو او ساختماني موادو شرکتونو ERP.</li><li><strong>WeSarafi</strong> — صرافي، تبادله، حواله او مالي عملیات.</li><li><strong>Prime Sarafi</strong> — څو اسعارو صرافي او حواله پلېټفارم.</li><li><strong>YuanRemit</strong> — د یوان/CNY حوالو مدیریت.</li><li><strong>CargoFlow</strong> — کارګو، بار او لوژستیک مدیریت.</li><li><strong>Darmal ERP</strong> — درملتون، عمده پلور او درملو وېش.</li><li><strong>OGRAYI</strong> — موبایل حساب او بیلانس مدیریت.</li><li><strong>Fida Business Suite</strong> — د سوداګرۍ او صرافي/حوالې ډیسټاپ سیسټم.</li><li><strong>Chilgoza Market System</strong> — د چلغوزو بازار لپاره آفلاین-فرسټ پېرود، پلور او حسابداري.</li><li><strong>Fida Mining ERP</strong> — د کانونو عملیات، تولید، وسایل، مالي او راپورونه.</li><li><strong>Approval-Based Expense System</strong> — د مصارفو غوښتنې، تایید، تادیاتو کنټرول او مدیریتي راپورونه.</li><li><strong>HesabPro</strong> — د کوچنیو سوداګریو حسابداري، سټاک او ورځني عملیات.</li></ul><h2>سکتوري سیسټمونه</h2><ul><li><strong>Solar & Electrical ERP</strong> — د سولر، برېښنا او الکتریشن شرکتونو ERP.</li><li><strong>Market Tenant Management System</strong> — دوکانونه، کرایه کوونکي، کرایه، تادیات او بازار عملیات.</li><li><strong>Building Management System (BMS)</strong> — ودانۍ، واحدونه، کرایه کوونکي، خدمات، ساتنه او مالي.</li><li><strong>Salt Mining ERP</strong> — د مالګې استخراج، پروسس، ګودامونه، HR، مالي او پلور.</li><li><strong>Carton Factory ERP</strong> — خام مواد، تولید، سټاک، پلور او مالي.</li><li><strong>Tailor Shop Management System</strong> — مشتریان، اندازه، فرمایش، د خیاطۍ بهیر او تادیات.</li><li><strong>Garment Business ERP</strong> — پېرود، تولید، سټاک، عمده/پرچون او مالي.</li></ul><h2>وېب او ډیجیټل پلېټفارمونه</h2><ul><li><strong>Real Estate Company Website Platform</strong> — د املاکو او پروژو خپرول، CMS او د مشتری غوښتنو بهیر.</li><li><strong>Technology Company Website Platform</strong> — د ټکنالوژۍ شرکت وېب‌سایټ له CMS، حللارو، محصولاتو، سکتورونو، پروژو او RFQ سره.</li><li><strong>StatementGrid</strong> — د اسنادو او سټېټمنټونو وېب وسیله.</li><li><strong>ContentOS</strong> — د AI په مرسته څو-سایټه څېړنه، خپرونه او توزیع.</li></ul><h2>د پورټفولیو تګلاره</h2><p>دا پاڼه د فیدا محصولات، بیاکارېدونکي حللارې او تایید شوې عامه پروژې ښيي. د هر حل شتون او حالت توپیر لري. د مشتری هویت، شخصي سورس، انځورونه او اندازه کېدونکې پایلې یوازې له اجازې او شواهدو وروسته خپرېږي.</p>',
        ];

        DB::table('content_pages')->where('id', $page->id)->update([
            'title' => $this->json([
                'en' => 'Products & Projects',
                'fa' => 'محصولات و پروژه‌ها',
                'ps' => 'محصولات او پروژې',
            ]),
            'eyebrow' => $this->json([
                'en' => 'A broader Fida software portfolio',
                'fa' => 'پورتفولیوی گسترده نرم‌افزار فیدا',
                'ps' => 'د فیدا پراخ سافټویر پورټفولیو',
            ]),
            'summary' => $this->json([
                'en' => 'Explore Fida Technologies products, ERP platforms, business systems, industry solutions, website platforms and digital tools.',
                'fa' => 'محصولات، ERPها، سیستم‌های تجارتی، راهکارهای صنعتی، پلتفرم‌های وب‌سایت و ابزارهای دیجیتال Fida Technologies را بررسی کنید.',
                'ps' => 'د Fida Technologies محصولات، ERP پلېټفارمونه، سوداګریز سیسټمونه، سکتوري حللارې، وېب‌سایټ پلېټفارمونه او ډیجیټل وسایل وګورئ.',
            ]),
            'body' => $this->json($body),
            'meta_title' => $this->json([
                'en' => 'ERP, Software Products & Projects | Fida Technologies',
                'fa' => 'محصولات، ERP و پروژه‌های نرم‌افزار | Fida Technologies',
                'ps' => 'ERP، سافټویر محصولات او پروژې | Fida Technologies',
            ]),
            'meta_description' => $this->json([
                'en' => 'Explore Fida Technologies ERP platforms, financial systems, industry software, website platforms and digital products for Afghanistan.',
                'fa' => 'ERPها، سیستم‌های مالی، نرم‌افزارهای صنعتی، پلتفرم‌های وب‌سایت و محصولات دیجیتال Fida Technologies را بررسی کنید.',
                'ps' => 'د Fida Technologies ERP پلېټفارمونه، مالي سیسټمونه، سکتوري سافټویر، وېب پلېټفارمونه او ډیجیټل محصولات وګورئ.',
            ]),
            'sitemap_last_modified_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // The portfolio expansion is additive public content and is intentionally not reverted.
    }

    private function json(array $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }
};
