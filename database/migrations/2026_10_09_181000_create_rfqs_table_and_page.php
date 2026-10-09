<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfqs', function (Blueprint $table): void {
            $table->id();
            $table->string('reference', 30)->nullable()->unique();
            $table->string('organization', 190);
            $table->string('organization_type', 40)->index();
            $table->string('contact_name', 120);
            $table->string('job_title', 120)->nullable();
            $table->string('email', 190)->index();
            $table->string('phone', 40)->nullable();
            $table->string('procurement_type', 60)->index();
            $table->string('project_title', 220);
            $table->date('submission_deadline')->nullable()->index();
            $table->string('location', 160)->nullable();
            $table->string('budget', 80)->nullable();
            $table->text('requirements');
            $table->json('attachments')->nullable();
            $table->string('locale', 5)->default('en');
            $table->text('source_url')->nullable();
            $table->string('status', 30)->default('new')->index();
            $table->text('internal_notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        ContentPage::query()->firstOrCreate(
            ['slug' => 'request-for-quotation'],
            [
                'type' => 'page',
                'title' => ['en' => 'Request for Quotation (RFQ)', 'fa' => 'درخواست قیمت (RFQ)', 'ps' => 'د نرخ غوښتنه (RFQ)'],
                'eyebrow' => ['en' => 'Government, NGO & enterprise procurement', 'fa' => 'تدارکات دولت، NGO و سازمان‌ها', 'ps' => 'د دولت، NGO او سازمانونو تدارکات'],
                'summary' => [
                    'en' => 'Submit an RFQ, RFP, TOR, BoQ or technical requirement for software, infrastructure, data centers, networks, servers, hardware, AI, IoT, integration or managed IT services.',
                    'fa' => 'RFQ، RFP، TOR، BoQ یا نیازمندی تخنیکی خود را برای نرم‌افزار، زیربنا، دیتاسنتر، شبکه، سرور، تجهیزات، AI، IoT، یکپارچه‌سازی یا خدمات IT ارسال کنید.',
                    'ps' => 'د سافټویر، زیربنا، ډیټا سنټر، شبکې، سرور، تجهیزاتو، AI، IoT، ادغام یا IT خدماتو لپاره RFQ، RFP، TOR، BoQ یا تخنیکي اړتیا راولېږئ.',
                ],
                'body' => [
                    'en' => '<h2>A structured channel for formal procurement</h2><p>This form is intended for government agencies, NGOs, INGOs, donors, banks, enterprises and procurement teams that need a written technical and commercial response. Submit the available requirement once; Fida will review the scope, requested specifications, deadline, delivery expectations and any attached documents before responding.</p><h2>What you can request</h2><ul><li>ERP, MIS, finance, HR, workflow and custom enterprise software</li><li>Web portals, websites, SaaS platforms and mobile applications</li><li>AI automation, IoT and smart monitoring systems</li><li>Data centers, server rooms, servers, storage, virtualization and backup</li><li>LAN/WAN, wireless, routing, switching, structured cabling and network operations</li><li>Cybersecurity, firewalls, endpoint and infrastructure security</li><li>Enterprise hardware, technology supply and accessories</li><li>Systems integration, installation, configuration, commissioning and training</li><li>Support contracts and managed IT services</li></ul><h2>What happens after submission</h2><p>The system generates an RFQ reference number and sends the request to info@fida.af. Our team can then clarify eligibility, specifications, brands, quantities, licensing, delivery locations, warranty, training, support and commercial terms before issuing a quotation.</p>',
                    'fa' => '<h2>مسیر منظم برای تدارکات رسمی</h2><p>این فورم برای ادارات دولتی، NGO، INGO، تمویل‌کنندگان، بانک‌ها، شرکت‌ها و تیم‌های تدارکات است که پاسخ تخنیکی و تجارتی کتبی نیاز دارند. نیازمندی و اسناد موجود را یک‌بار ارسال کنید تا Fida محدوده، مشخصات، مهلت و توقعات تحویل را بررسی کند.</p><h2>چه مواردی را می‌توانید درخواست کنید؟</h2><ul><li>ERP، MIS، مالی، HR و نرم‌افزار اختصاصی</li><li>پورتال، وب‌سایت، SaaS و اپلیکیشن موبایل</li><li>AI، IoT و سیستم‌های هوشمند</li><li>دیتاسنتر، سرور، ذخیره‌سازی، مجازی‌سازی و بکاپ</li><li>شبکه، وایرلس، روتینگ، سویچینگ و کابل‌کشی</li><li>امنیت سایبری و تجهیزات سازمانی</li><li>نصب، تنظیمات، یکپارچه‌سازی، آموزش و پشتیبانی</li></ul>',
                    'ps' => '<h2>د رسمي تدارکاتو لپاره منظم چینل</h2><p>دا فورمه د دولتي ادارو، NGO، INGO، تمویلوونکو، بانکونو، شرکتونو او تدارکاتي ټیمونو لپاره ده چې لیکلي تخنیکي او سوداګریز ځواب ته اړتیا لري. موجوده اړتیا او اسناد یو ځل راولېږئ څو Fida حدود، مشخصات، مهلت او د سپارلو تمې وارزوي.</p><h2>څه شی غوښتلی شئ؟</h2><ul><li>ERP، MIS، مالي، HR او ځانګړی سافټویر</li><li>پورټل، وېب‌سایټ، SaaS او موبایل اپلېکېشن</li><li>AI، IoT او هوښیار سیسټمونه</li><li>ډیټا سنټر، سرور، ذخیره، مجازي کول او بیک اپ</li><li>شبکه، وایرلس، روټینګ، سویچینګ او کیبلینګ</li><li>سایبري امنیت او سازماني تجهیزات</li><li>نصب، تنظیمات، ادغام، روزنه او ملاتړ</li></ul>',
                ],
                'meta_title' => ['en' => 'Submit RFQ / RFP for IT Projects Afghanistan | Fida', 'fa' => 'ارسال RFQ و RFP پروژه‌های IT افغانستان | Fida', 'ps' => 'د IT پروژو RFQ او RFP وسپارئ | Fida'],
                'meta_description' => [
                    'en' => 'Submit an RFQ, RFP, TOR or BoQ to Fida Technologies for ERP, software, data center, network, servers, cybersecurity, hardware and IT projects in Afghanistan.',
                    'fa' => 'RFQ، RFP، TOR یا BoQ خود را برای ERP، نرم‌افزار، دیتاسنتر، شبکه، سرور، امنیت، تجهیزات و پروژه‌های IT به Fida ارسال کنید.',
                    'ps' => 'د ERP، سافټویر، ډیټا سنټر، شبکې، سرور، امنیت، تجهیزاتو او IT پروژو لپاره RFQ، RFP، TOR یا BoQ Fida ته واستوئ.',
                ],
                'primary_query' => ['en' => 'IT RFQ Afghanistan', 'fa' => 'درخواست قیمت پروژه IT افغانستان', 'ps' => 'په افغانستان کې د IT نرخ غوښتنه'],
                'search_intent' => 'transactional',
                'robots_directive' => config('website.discovery.default_robots'),
                'sitemap_included' => true,
                'sitemap_priority' => 0.9,
                'sitemap_change_frequency' => 'monthly',
                'metadata' => [
                    'faqs' => [
                        [
                            'question' => ['en' => 'What documents can I attach?', 'fa' => 'چه اسنادی را می‌توانم ضمیمه کنم؟', 'ps' => 'کوم اسناد ضمیمه کولی شم؟'],
                            'answer' => ['en' => 'You can attach up to five PDF, Word, Excel or PowerPoint files such as an RFQ, RFP, TOR, BoQ, compliance sheet or technical specification.', 'fa' => 'می‌توانید تا پنج فایل PDF، Word، Excel یا PowerPoint مانند RFQ، RFP، TOR، BoQ، جدول مطابقت یا مشخصات تخنیکی ضمیمه کنید.', 'ps' => 'تر پنځو PDF، Word، Excel یا PowerPoint فایلونو لکه RFQ، RFP، TOR، BoQ، مطابقت جدول یا تخنیکي مشخصات ضمیمه کولی شئ.'],
                        ],
                        [
                            'question' => ['en' => 'Will I receive a reference number?', 'fa' => 'آیا شماره مرجع دریافت می‌کنم؟', 'ps' => 'ایا مرجع شمېره ترلاسه کوم؟'],
                            'answer' => ['en' => 'Yes. Every accepted submission receives a unique RFQ reference number that can be used in follow-up communication.', 'fa' => 'بله. هر درخواست پذیرفته‌شده یک شماره مرجع اختصاصی RFQ دریافت می‌کند.', 'ps' => 'هو. هره منل شوې غوښتنه ځانګړې RFQ مرجع شمېره ترلاسه کوي.'],
                        ],
                        [
                            'question' => ['en' => 'Can Fida quote hardware and services together?', 'fa' => 'آیا Fida تجهیزات و خدمات را یکجا قیمت می‌دهد؟', 'ps' => 'ایا Fida تجهیزات او خدمات یوځای نرخ کولی شي؟'],
                            'answer' => ['en' => 'Yes, when the scope requires both. The quotation can separate equipment, software, licenses, installation, configuration, training, warranty and support.', 'fa' => 'بله، در صورت نیاز پروژه. پیشنهاد می‌تواند تجهیزات، نرم‌افزار، لایسنس، نصب، تنظیمات، آموزش، تضمین و پشتیبانی را جدا نشان دهد.', 'ps' => 'هو، که پروژه دواړو ته اړتیا ولري. نرخپاڼه تجهیزات، سافټویر، لایسنس، نصب، تنظیمات، روزنه، تضمین او ملاتړ جلا ښودلی شي.'],
                        ],
                    ],
                    'related_slugs' => ['government-ngo-technology-procurement-afghanistan', 'government-public-sector-software-afghanistan', 'ngo-ingo-software-afghanistan'],
                ],
                'status' => 'published',
                'featured' => true,
                'sort_order' => 2,
                'published_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        ContentPage::query()->where('slug', 'request-for-quotation')->delete();
        Schema::dropIfExists('rfqs');
    }
};
