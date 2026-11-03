<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class GovernmentNgoCapabilitySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->capabilityPages() as $page) {
            ContentPage::query()->firstOrCreate(['slug' => $page['slug']], $page);
        }

        if (! SiteSetting::query()->where('key', 'release.gov_ngo_capabilities_v1')->exists()) {
            ContentPage::query()->where('slug', 'solutions')->update([
            'title' => [
                'en' => 'Enterprise Technology Solutions in Afghanistan',
                'fa' => 'راهکارهای تکنالوژی سازمانی در افغانستان',
                'ps' => 'په افغانستان کې د سازماني ټکنالوژۍ حللارې',
            ],
            'eyebrow' => [
                'en' => 'Software, infrastructure and technology delivery',
                'fa' => 'نرم‌افزار، زیربنا و تحویل تکنالوژی',
                'ps' => 'سافټویر، زیربنا او د ټکنالوژۍ سپارنه',
            ],
            'summary' => [
                'en' => 'Explore Fida capabilities across enterprise software, web and mobile development, AI, IoT, data centers, networks, cloud, cybersecurity, hardware supply, systems integration and managed IT services.',
                'fa' => 'توانایی‌های فدا در نرم‌افزار سازمانی، توسعه وب و موبایل، AI، IoT، دیتاسنتر، شبکه، کلود، امنیت سایبری، تجهیزات، یکپارچه‌سازی و خدمات مدیریت‌شده IT را بررسی کنید.',
                'ps' => 'د فدا وړتیاوې په سازماني سافټویر، وېب او موبایل، AI، IoT، ډیټا سنټر، شبکو، کلاوډ، سایبري امنیت، تجهیزاتو، ادغام او مدیریت شوو IT خدمتونو کې وګورئ.',
            ],
            'body' => [
                'en' => '<h2>One technology partner across software and infrastructure</h2><p>Fida Technologies supports organizations that need more than a standalone application. We can combine software engineering, infrastructure, networks, servers, security, hardware supply, deployment, documentation, training and support into one accountable scope.</p><h2>Built for institutional procurement</h2><p>Government agencies, NGOs, INGOs, banks, telecoms and large organizations can engage Fida through an RFQ, RFP, tender or direct scope. A response can separate equipment, licenses, implementation, configuration, training, support, warranty assumptions and commercial terms so procurement teams can compare the offer clearly.</p><h2>From requirement to handover</h2><ul><li>Requirements and site assessment</li><li>Architecture and bill of quantities</li><li>Software development or configuration</li><li>Hardware and licensed technology supply where required</li><li>Installation, integration, testing and commissioning</li><li>Training, documentation and controlled handover</li><li>Support and maintenance under agreed service levels</li></ul>',
                'fa' => '<h2>یک شریک تکنالوژی برای نرم‌افزار و زیربنا</h2><p>Fida Technologies برای سازمان‌هایی کار می‌کند که بیشتر از یک برنامه مستقل نیاز دارند. نرم‌افزار، زیربنا، شبکه، سرور، امنیت، تجهیزات، نصب، اسناد، آموزش و پشتیبانی می‌تواند در یک محدوده پاسخگو یکجا شود.</p><h2>مناسب برای تدارکات سازمانی</h2><p>ادارات دولتی، NGO، INGO، بانک‌ها، مخابرات و سازمان‌های بزرگ می‌توانند از طریق RFQ، RFP، tender یا محدوده مستقیم با فدا کار کنند.</p>',
                'ps' => '<h2>د سافټویر او زیربنا لپاره یو ټکنالوژۍ شریک</h2><p>Fida Technologies له هغو ادارو سره کار کوي چې یوازې یو اپلېکېشن نه، بلکې سافټویر، زیربنا، شبکه، سرور، امنیت، تجهیزات، نصب، اسناد، روزنه او ملاتړ په یوه مسؤل حدود کې غواړي.</p><h2>د سازماني تدارکاتو لپاره مناسب</h2><p>دولت، NGO، INGO، بانکونه، مخابرات او لوی سازمانونه کولای شي د RFQ، RFP، tender یا مستقیم scope له لارې له فدا سره کار وکړي.</p>',
            ],
            'meta_title' => [
                'en' => 'Enterprise Technology Solutions Afghanistan | Fida Technologies',
                'fa' => 'راهکارهای تکنالوژی سازمانی افغانستان | فدا',
                'ps' => 'د سازماني ټکنالوژۍ حللارې افغانستان | فدا',
            ],
            'meta_description' => [
                'en' => 'Enterprise technology partner in Afghanistan for ERP, web, mobile, AI, IoT, data centers, networks, cloud, cybersecurity, hardware supply and systems integration.',
                'fa' => 'شریک تکنالوژی سازمانی در افغانستان برای ERP، وب، موبایل، AI، IoT، دیتاسنتر، شبکه، کلود، امنیت سایبری، تجهیزات و یکپارچه‌سازی.',
                'ps' => 'په افغانستان کې د ERP، وېب، موبایل، AI، IoT، ډیټا سنټر، شبکو، کلاوډ، سایبري امنیت، تجهیزاتو او ادغام لپاره سازماني ټکنالوژۍ شریک.',
            ],
            'primary_query' => [
                'en' => 'enterprise technology solutions Afghanistan',
                'fa' => 'راهکارهای تکنالوژی سازمانی افغانستان',
                'ps' => 'د سازماني ټکنالوژۍ حللارې افغانستان',
            ],
            'search_intent' => 'commercial',
            'status' => 'published',
            'featured' => true,
            'sitemap_included' => true,
            'sitemap_priority' => 0.9,
            'sitemap_change_frequency' => 'monthly',
        ]);

            SiteSetting::query()->updateOrCreate(
                ['key' => 'release.gov_ngo_capabilities_v1'],
                [
                    'group' => 'release',
                    'value' => ['applied_at' => now()->toAtomString()],
                    'type' => 'json',
                    'is_public' => false,
                ],
            );
        }

        ContentPage::query()->firstOrCreate(
            ['slug' => 'government-ngo-technology-solutions-afghanistan'],
            $this->institutionalPage(),
        );

        ContentPage::query()->firstOrCreate(
            ['slug' => 'request-for-quotation'],
            [
                'type' => 'page',
                'title' => [
                    'en' => 'Request for Quotation (RFQ)',
                    'fa' => 'درخواست قیمت (RFQ)',
                    'ps' => 'د نرخ غوښتنه (RFQ)',
                ],
                'eyebrow' => [
                    'en' => 'Government, NGO and enterprise procurement',
                    'fa' => 'تدارکات دولت، NGO و سازمان‌ها',
                    'ps' => 'د دولت، NGO او سازماني تدارکات',
                ],
                'summary' => [
                    'en' => 'Submit an RFQ, RFP or tender requirement to Fida Technologies for software, infrastructure, data centers, networks, hardware, implementation, training and support.',
                    'fa' => 'RFQ، RFP یا نیازمندی tender خود را برای نرم‌افزار، زیربنا، دیتاسنتر، شبکه، تجهیزات، تطبیق، آموزش و پشتیبانی به Fida Technologies ارسال کنید.',
                    'ps' => 'خپل RFQ، RFP یا tender د سافټویر، زیربنا، ډیټا سنټر، شبکې، تجهیزاتو، پلي کولو، روزنې او ملاتړ لپاره Fida Technologies ته وسپارئ.',
                ],
                'body' => [
                    'en' => '<h2>A procurement-ready intake channel</h2><p>Use this form to send a formal quotation request, RFP, tender invitation, bill of quantities, technical scope or statement of work. Fida reviews the requirement before confirming commercial terms.</p><h2>What to include</h2><ul><li>Organization and procurement reference</li><li>Required software, equipment or professional services</li><li>Technical specifications, quantities and delivery location</li><li>Submission deadline and expected implementation timeline</li><li>Mandatory compliance, warranty, training or support requirements</li></ul><p>For sensitive documents, provide only information you are authorized to share. Fida will use the submitted material to evaluate and respond to the request.</p>',
                    'fa' => '<h2>کانال آماده برای تدارکات</h2><p>از این فورم برای ارسال RFQ، RFP، دعوت tender، BOQ، محدوده تخنیکی یا statement of work استفاده کنید. فدا پیش از تأیید شرایط تجارتی نیازمندی را بررسی می‌کند.</p>',
                    'ps' => '<h2>د تدارکاتو لپاره چمتو کانال</h2><p>دا فورم د RFQ، RFP، tender بلنې، BOQ، تخنیکي scope یا statement of work د استولو لپاره وکاروئ. فدا د سوداګریزو شرایطو تر تایید مخکې اړتیا ارزوي.</p>',
                ],
                'meta_title' => [
                    'en' => 'Submit RFQ / RFP / Tender to Fida Technologies Afghanistan',
                    'fa' => 'ارسال RFQ / RFP / Tender به فدا تکنالوژی افغانستان',
                    'ps' => 'Fida Technologies افغانستان ته RFQ / RFP / Tender وسپارئ',
                ],
                'meta_description' => [
                    'en' => 'Submit a formal RFQ, RFP or tender requirement for software, ERP, data centers, networks, servers, hardware, cybersecurity, implementation or support in Afghanistan.',
                    'fa' => 'RFQ، RFP یا tender رسمی برای نرم‌افزار، ERP، دیتاسنتر، شبکه، سرور، تجهیزات، امنیت سایبری، تطبیق یا پشتیبانی در افغانستان ارسال کنید.',
                    'ps' => 'په افغانستان کې د سافټویر، ERP، ډیټا سنټر، شبکې، سرور، تجهیزاتو، سایبري امنیت، پلي کولو یا ملاتړ لپاره رسمي RFQ، RFP یا tender واستوئ.',
                ],
                'primary_query' => [
                    'en' => 'RFQ technology company Afghanistan',
                    'fa' => 'درخواست قیمت شرکت تکنالوژی افغانستان',
                    'ps' => 'د ټکنالوژۍ شرکت د نرخ غوښتنه افغانستان',
                ],
                'search_intent' => 'transactional',
                'metadata' => [
                    'faqs' => [
                        [
                            'question' => ['en' => 'What can I request through the RFQ form?', 'fa' => 'از طریق فورم RFQ چه چیزهایی را می‌توان درخواست کرد؟', 'ps' => 'د RFQ فورم له لارې څه غوښتل کېدای شي؟'],
                            'answer' => ['en' => 'You can request software, ERP, web or mobile development, AI or IoT solutions, data-center and network infrastructure, servers, cybersecurity, enterprise hardware, systems integration, training, support or a combined scope.', 'fa' => 'می‌توانید نرم‌افزار، ERP، وب یا موبایل، AI یا IoT، دیتاسنتر و شبکه، سرور، امنیت سایبری، تجهیزات سازمانی، یکپارچه‌سازی، آموزش، پشتیبانی یا محدوده ترکیبی درخواست کنید.', 'ps' => 'تاسو سافټویر، ERP، وېب یا موبایل، AI یا IoT، ډیټا سنټر او شبکه، سرور، سایبري امنیت، سازماني تجهیزات، ادغام، روزنه، ملاتړ یا ګډ scope غوښتلای شئ.'],
                        ],
                        [
                            'question' => ['en' => 'Can government or NGO procurement teams attach an RFQ or RFP document?', 'fa' => 'آیا تیم تدارکات دولت یا NGO می‌تواند سند RFQ یا RFP ضمیمه کند؟', 'ps' => 'ایا د دولت یا NGO تدارکاتي ټیم د RFQ یا RFP سند ضمیمه کولای شي؟'],
                            'answer' => ['en' => 'Yes. The form accepts common procurement document formats and stores the document with the request for authorized review.', 'fa' => 'بله. فورم فرمت‌های معمول اسناد تدارکاتی را می‌پذیرد و سند را همراه درخواست برای بررسی مجاز نگهداری می‌کند.', 'ps' => 'هو. فورم د تدارکاتو عام سندي فارمیټونه مني او سند د مجازې ارزونې لپاره له غوښتنې سره ساتي.'],
                        ],
                        [
                            'question' => ['en' => 'Where is the RFQ notification sent?', 'fa' => 'اطلاع RFQ به کجا ارسال می‌شود؟', 'ps' => 'د RFQ خبرتیا چیرته استول کېږي؟'],
                            'answer' => ['en' => 'New RFQ submissions are recorded in the Fida administration system and a notification is sent to info@fida.af for review.', 'fa' => 'RFQ جدید در سیستم مدیریت فدا ثبت می‌شود و اطلاع آن برای بررسی به info@fida.af ارسال می‌گردد.', 'ps' => 'نوی RFQ د فدا په اډمین سیسټم کې ثبتېږي او د ارزونې خبرتیا info@fida.af ته استول کېږي.'],
                        ],
                    ],
                ],
                'status' => 'published',
                'featured' => false,
                'sort_order' => 12,
                'sitemap_included' => true,
                'sitemap_priority' => 0.8,
                'sitemap_change_frequency' => 'monthly',
                'published_at' => now(),
            ],
        );
    }

    private function institutionalPage(): array
    {
        return [
            'type' => 'solution',
            'slug' => 'government-ngo-technology-solutions-afghanistan',
            'title' => [
                'en' => 'Government & NGO Technology Solutions',
                'fa' => 'راهکارهای تکنالوژی برای دولت و NGO',
                'ps' => 'د دولت او NGO لپاره د ټکنالوژۍ حللارې',
            ],
            'eyebrow' => [
                'en' => 'Institutional technology delivery in Afghanistan',
                'fa' => 'تحویل تکنالوژی سازمانی در افغانستان',
                'ps' => 'په افغانستان کې سازماني ټکنالوژۍ سپارنه',
            ],
            'summary' => [
                'en' => 'A procurement-ready technology partner for government agencies, NGOs, INGOs, donors and large institutions across software, infrastructure, networks, data centers, hardware, security and managed services.',
                'fa' => 'شریک تکنالوژی آماده تدارکات برای ادارات دولتی، NGO، INGO، دونرها و سازمان‌های بزرگ در نرم‌افزار، زیربنا، شبکه، دیتاسنتر، تجهیزات، امنیت و خدمات IT.',
                'ps' => 'د دولت، NGO، INGO، تمویلوونکو او لویو ادارو لپاره د سافټویر، زیربنا، شبکې، ډیټا سنټر، تجهیزاتو، امنیت او IT خدمتونو تدارکاتو ته چمتو ټکنالوژۍ شریک.',
            ],
            'body' => [
                'en' => '<h2>Technology delivery that procurement teams can evaluate</h2><p>Government and development-sector projects often combine software, equipment, configuration, installation, documentation, training and support. Fida Technologies structures these components clearly so technical teams and procurement teams can review the same scope without mixing product supply with professional services.</p><h2>What Fida can deliver</h2><ul><li>Custom ERP, MIS, finance, HR, workflow and reporting platforms</li><li>Government, NGO and programme web portals and mobile applications</li><li>AI assistants, document workflows and controlled automation</li><li>IoT, monitoring and smart infrastructure integrations</li><li>Data-center, server-room, compute, storage, backup and virtualization projects</li><li>LAN/WAN, routing, switching, Wi-Fi and structured network infrastructure</li><li>Cybersecurity controls, firewalls, hardening and infrastructure protection</li><li>Enterprise hardware and technology supply against an approved BOQ</li><li>Systems integration, migration, testing, commissioning and handover</li><li>Training, documentation, maintenance and managed support</li></ul><h2>Procurement-ready project structure</h2><p>Where required, a technical and commercial response can separate equipment, licenses, implementation, installation, configuration, testing, training, warranty assumptions, support and optional services. Brands, quantities, delivery locations and acceptance requirements are confirmed against the approved RFQ, RFP, tender, BOQ or statement of work.</p><h2>Controlled implementation and handover</h2><p>Projects can be organized around discovery or site assessment, architecture and BOQ, implementation, testing, acceptance, documentation, training and support. The exact deliverables depend on the approved scope; Fida does not imply certifications, warranties or vendor authorizations that are not explicitly confirmed for the project.</p><h2>Start with the formal requirement</h2><p>Procurement and technical teams can send the RFQ, RFP, tender document, BOQ or scope through the Fida RFQ channel. The request receives a reference number, is stored in the administration system and is sent to the Fida procurement inbox for review.</p>',
                'fa' => '<h2>تحویل تکنالوژی قابل ارزیابی برای تدارکات</h2><p>پروژه‌های دولت و سکتور انکشافی معمولاً نرم‌افزار، تجهیزات، تنظیم، نصب، اسناد، آموزش و پشتیبانی را یکجا نیاز دارند. فدا این بخش‌ها را واضح تفکیک می‌کند تا تیم تخنیکی و تدارکات یک محدوده مشترک را بررسی کنند.</p><h2>قابلیت‌های پروژه</h2><ul><li>ERP، MIS، مالی، HR و workflow سفارشی</li><li>پورتال‌های دولت و NGO و اپلیکیشن‌های موبایل</li><li>AI، اتوماسیون و پردازش اسناد</li><li>IoT و monitoring</li><li>دیتاسنتر، سرور، storage، backup و virtualization</li><li>شبکه، Wi-Fi و structured cabling</li><li>امنیت سایبری و firewall</li><li>تجهیزات سازمانی مطابق BOQ</li><li>integration، testing، commissioning و handover</li><li>آموزش، اسناد و پشتیبانی</li></ul><h2>ساختار آماده تدارکات</h2><p>پاسخ تخنیکی و تجارتی می‌تواند تجهیزات، لایسنس، تطبیق، نصب، تنظیم، testing، training، warranty assumptions و support را جداگانه نشان دهد.</p>',
                'ps' => '<h2>د تدارکاتو لپاره د ارزونې وړ ټکنالوژۍ سپارنه</h2><p>د دولت او پراختیايي سکتور پروژې اکثره سافټویر، تجهیزات، تنظیم، نصب، اسناد، روزنه او ملاتړ یوځای غواړي. فدا دا برخې روښانه جلا کوي څو تخنیکي او تدارکاتي ټیمونه یو واحد scope وارزوي.</p><h2>د پروژې وړتیاوې</h2><ul><li>Custom ERP، MIS، مالي، HR او workflow</li><li>دولت او NGO پورټلونه او موبایل اپلېکېشنونه</li><li>AI، اتومات او د اسنادو پروسس</li><li>IoT او monitoring</li><li>ډیټا سنټر، سرور، storage، backup او virtualization</li><li>شبکه، Wi-Fi او structured cabling</li><li>سایبري امنیت او firewall</li><li>د BOQ مطابق سازماني تجهیزات</li><li>integration، testing، commissioning او handover</li><li>روزنه، اسناد او ملاتړ</li></ul><h2>د تدارکاتو لپاره چمتو جوړښت</h2><p>تخنیکي او سوداګریز ځواب کې تجهیزات، لایسنس، پلي کول، نصب، تنظیم، testing، training، warranty assumptions او support جلا ښودل کېدای شي.</p>',
            ],
            'meta_title' => [
                'en' => 'Government & NGO IT Solutions Afghanistan | Fida Technologies',
                'fa' => 'راهکارهای IT دولت و NGO افغانستان | فدا تکنالوژی',
                'ps' => 'د دولت او NGO IT حللارې افغانستان | فدا',
            ],
            'meta_description' => [
                'en' => 'Technology partner for government and NGO projects in Afghanistan: ERP, web, mobile, AI, data centers, networks, servers, cybersecurity, hardware supply and implementation.',
                'fa' => 'شریک تکنالوژی پروژه‌های دولت و NGO در افغانستان: ERP، وب، موبایل، AI، دیتاسنتر، شبکه، سرور، امنیت، تجهیزات و تطبیق.',
                'ps' => 'په افغانستان کې د دولت او NGO پروژو لپاره ټکنالوژۍ شریک: ERP، وېب، موبایل، AI، ډیټا سنټر، شبکه، سرور، امنیت، تجهیزات او پلي کول.',
            ],
            'primary_query' => [
                'en' => 'government NGO IT solutions Afghanistan',
                'fa' => 'راهکارهای تکنالوژی دولت و NGO افغانستان',
                'ps' => 'د دولت او NGO ټکنالوژۍ حللارې افغانستان',
            ],
            'search_intent' => 'commercial',
            'metadata' => [
                'solution' => [
                    'outcomes' => [
                        'en' => 'A clearly scoped institutional technology project with measurable acceptance and handover.',
                        'fa' => 'پروژه تکنالوژی سازمانی با scope، acceptance و handover واضح.',
                        'ps' => 'روښانه scope، acceptance او handover لرونکې سازماني ټکنالوژۍ پروژه.',
                    ],
                    'control' => [
                        'en' => 'BOQ, specifications, responsibilities, changes, acceptance and support boundaries stay explicit.',
                        'fa' => 'BOQ، مشخصات، مسئولیت، تغییرات، acceptance و حدود support واضح می‌ماند.',
                        'ps' => 'BOQ، مشخصات، مسؤلیتونه، بدلونونه، acceptance او د support حدود روښانه پاتې کېږي.',
                    ],
                    'decisions' => [
                        'en' => 'Procurement, architecture, implementation, acceptance and support decisions are documented before handover.',
                        'fa' => 'تصامیم تدارکات، معماری، تطبیق، acceptance و support پیش از handover ثبت می‌شود.',
                        'ps' => 'د تدارکاتو، معمارۍ، پلي کولو، acceptance او support پرېکړې تر handover مخکې مستندېږي.',
                    ],
                    'capabilities' => [
                        ['en' => 'Custom ERP & enterprise software'],
                        ['en' => 'Government & NGO portals'],
                        ['en' => 'Mobile & field applications'],
                        ['en' => 'AI & intelligent automation'],
                        ['en' => 'Data centers & server infrastructure'],
                        ['en' => 'Network engineering & operations'],
                        ['en' => 'Cybersecurity implementation'],
                        ['en' => 'Enterprise hardware supply'],
                        ['en' => 'Systems integration & deployment'],
                        ['en' => 'Training, documentation & support'],
                    ],
                ],
                'faqs' => [
                    [
                        'question' => ['en' => 'Can Fida respond to government or NGO RFQs and tenders?', 'fa' => 'آیا فدا به RFQ و tender دولت یا NGO پاسخ می‌دهد؟', 'ps' => 'ایا فدا د دولت یا NGO RFQ او tender ته ځواب ورکوي؟'],
                        'answer' => ['en' => 'Yes. Fida can review a formal RFQ, RFP, tender, BOQ or statement of work and prepare a scope-based technical and commercial response where the requirement fits Fida capabilities.', 'fa' => 'بله. فدا می‌تواند RFQ، RFP، tender، BOQ یا statement of work را بررسی و در صورت مطابقت با توانایی‌ها پاسخ تخنیکی و تجارتی مبتنی بر scope آماده کند.', 'ps' => 'هو. فدا RFQ، RFP، tender، BOQ یا statement of work ارزولای شي او د وړتیاوو سره د مطابقت په صورت کې scope-based تخنیکي او سوداګریز ځواب برابرولای شي.'],
                    ],
                    [
                        'question' => ['en' => 'Can one project include both hardware and software?', 'fa' => 'آیا یک پروژه می‌تواند hardware و software را یکجا شامل کند؟', 'ps' => 'ایا یوه پروژه hardware او software دواړه شاملولای شي؟'],
                        'answer' => ['en' => 'Yes. A combined scope can cover software, equipment, licenses, networking, servers, installation, configuration, integration, testing, training and support, with each component separated in the response.', 'fa' => 'بله. scope ترکیبی می‌تواند software، تجهیزات، لایسنس، شبکه، سرور، نصب، تنظیم، integration، testing، training و support را شامل کند و هر بخش جدا نشان داده شود.', 'ps' => 'هو. ګډ scope کې software، تجهیزات، لایسنس، شبکه، سرور، نصب، تنظیم، integration، testing، training او support شاملېدای شي او هره برخه جلا ښودل کېږي.'],
                    ],
                    [
                        'question' => ['en' => 'Does Fida supply specific brands or guarantee vendor authorization?', 'fa' => 'آیا فدا برند مشخص یا vendor authorization را تضمین می‌کند؟', 'ps' => 'ایا فدا ځانګړی brand یا vendor authorization تضمینوي؟'],
                        'answer' => ['en' => 'Brands, availability, warranty and any vendor authorization are confirmed per project and quotation. Fida does not claim an authorization or certification unless it can be documented for that requirement.', 'fa' => 'برند، موجودی، warranty و هر vendor authorization برای هر پروژه و quotation جداگانه تأیید می‌شود. فدا بدون سند، authorization یا certification را ادعا نمی‌کند.', 'ps' => 'brand، availability، warranty او vendor authorization د هرې پروژې او quotation لپاره جلا تاییدېږي. فدا بې اسناده authorization یا certification نه ادعا کوي.'],
                    ],
                    [
                        'question' => ['en' => 'How should a procurement team start?', 'fa' => 'تیم تدارکات چگونه شروع کند؟', 'ps' => 'تدارکاتي ټیم څنګه پیل وکړي؟'],
                        'answer' => ['en' => 'Submit the RFQ, RFP, tender, BOQ or technical scope through the Fida RFQ page. Include the procurement reference, deadline, delivery location and mandatory technical or compliance requirements.', 'fa' => 'RFQ، RFP، tender، BOQ یا scope تخنیکی را از صفحه RFQ فدا ارسال کنید و reference، deadline، محل تحویل و شرایط اجباری را شامل سازید.', 'ps' => 'RFQ، RFP، tender، BOQ یا تخنیکي scope د فدا RFQ پاڼې له لارې واستوئ او reference، deadline، delivery location او اجباري شرایط شامل کړئ.'],
                    ],
                ],
                'cta' => [
                    'heading' => ['en' => 'Send your institutional requirement to Fida', 'fa' => 'نیازمندی سازمانی خود را به فدا ارسال کنید', 'ps' => 'خپله سازماني اړتیا فدا ته واستوئ'],
                    'description' => ['en' => 'Submit an RFQ, RFP, tender, BOQ or combined software-and-infrastructure requirement for review.', 'fa' => 'RFQ، RFP، tender، BOQ یا نیازمندی ترکیبی software و infrastructure را برای بررسی ارسال کنید.', 'ps' => 'RFQ، RFP، tender، BOQ یا ګډ software او infrastructure اړتیا د ارزونې لپاره وسپارئ.'],
                    'primary_label' => ['en' => 'Submit formal RFQ', 'fa' => 'ارسال RFQ رسمی', 'ps' => 'رسمي RFQ وسپارئ'],
                    'primary_intent' => 'tender',
                ],
                'audiences' => ['Government', 'NGO', 'INGO', 'UN and international organizations', 'Donor programmes', 'Banks and regulated institutions'],
            ],
            'status' => 'published',
            'featured' => true,
            'sort_order' => 5,
            'sitemap_included' => true,
            'sitemap_priority' => 0.9,
            'sitemap_change_frequency' => 'monthly',
            'published_at' => now(),
        ];
    }


    private function capabilityPages(): array
    {
        $definitions = [
            [
                'slug' => 'web-digital-platforms-afghanistan',
                'title' => ['en' => 'Web Development & Digital Platforms', 'fa' => 'توسعه وب و پلتفرم‌های دیجیتال', 'ps' => 'د وېب جوړول او ډیجیټل پلېټفارمونه'],
                'query' => ['en' => 'web development company Afghanistan', 'fa' => 'شرکت طراحی و توسعه وب افغانستان', 'ps' => 'د وېب جوړولو شرکت افغانستان'],
                'summary' => ['en' => 'Corporate websites, government and NGO portals, SaaS platforms, customer portals and secure web applications designed for institutional use.', 'fa' => 'وب‌سایت‌های شرکتی، پورتال‌های دولت و NGO، پلتفرم‌های SaaS، پورتال مشتری و اپلیکیشن‌های امن وب.', 'ps' => 'شرکتي وېب‌سایټونه، د دولت او NGO پورټلونه، SaaS پلېټفارمونه، د مشتری پورټلونه او خوندي وېب اپلېکېشنونه.'],
                'capabilities' => ['Corporate and institutional websites', 'Government and NGO portals', 'SaaS and web applications', 'CMS and publishing workflows', 'API integrations', 'Accessibility and performance'],
            ],
            [
                'slug' => 'ai-automation-solutions-afghanistan',
                'title' => ['en' => 'AI & Intelligent Automation Solutions', 'fa' => 'راهکارهای AI و اتوماسیون هوشمند', 'ps' => 'د AI او هوښیار اتومات حللارې'],
                'query' => ['en' => 'AI automation solutions Afghanistan', 'fa' => 'راهکارهای هوش مصنوعی افغانستان', 'ps' => 'د مصنوعي ځیرکتیا حللارې افغانستان'],
                'summary' => ['en' => 'AI assistants, document processing, knowledge search, workflow automation and decision-support systems connected to controlled business processes.', 'fa' => 'دستیارهای AI، پردازش اسناد، جستجوی دانش، اتوماسیون روند و سیستم‌های پشتیبانی تصمیم.', 'ps' => 'AI مرستیالان، د اسنادو پروسس، د پوهې لټون، د کاري بهیر اتومات او د پرېکړې ملاتړ سیسټمونه.'],
                'capabilities' => ['AI assistants', 'Document extraction', 'Knowledge search', 'Workflow automation', 'Analytics and decision support', 'Human review controls'],
            ],
            [
                'slug' => 'iot-smart-infrastructure-afghanistan',
                'title' => ['en' => 'IoT & Smart Infrastructure', 'fa' => 'IoT و زیربنای هوشمند', 'ps' => 'IoT او هوښیار زیربنا'],
                'query' => ['en' => 'IoT solutions Afghanistan', 'fa' => 'راهکارهای IoT افغانستان', 'ps' => 'د IoT حللارې افغانستان'],
                'summary' => ['en' => 'Connected sensors, telemetry, asset monitoring and smart infrastructure integrations for facilities, utilities, logistics and field operations.', 'fa' => 'سنسورها، telemetry، نظارت دارایی و یکپارچه‌سازی زیربنای هوشمند برای تأسیسات، خدمات، لوژستیک و عملیات ساحوی.', 'ps' => 'سنسورونه، telemetry، د شتمنیو څارنه او د تاسیساتو، خدماتو، لوژستیک او ساحوي عملیاتو لپاره هوښیار زیربنا.'],
                'capabilities' => ['Sensors and telemetry', 'Remote monitoring', 'Asset tracking', 'Environmental monitoring', 'Gateway integration', 'Operational dashboards'],
            ],
            [
                'slug' => 'data-center-it-infrastructure-afghanistan',
                'title' => ['en' => 'Data Center & IT Infrastructure', 'fa' => 'دیتاسنتر و زیربنای IT', 'ps' => 'ډیټا سنټر او IT زیربنا'],
                'query' => ['en' => 'data center infrastructure Afghanistan', 'fa' => 'دیتاسنتر و زیربنای IT افغانستان', 'ps' => 'ډیټا سنټر او IT زیربنا افغانستان'],
                'summary' => ['en' => 'Data-center and server-room design, racks, power, UPS, cooling coordination, compute, storage, backup and infrastructure monitoring.', 'fa' => 'طراحی دیتاسنتر و اتاق سرور، rack، برق، UPS، هماهنگی cooling، compute، storage، backup و monitoring.', 'ps' => 'د ډیټا سنټر او سرور خونې ډیزاین، rack، برېښنا، UPS، cooling، compute، storage، backup او monitoring.'],
                'capabilities' => ['Data-center design', 'Server rooms and racks', 'UPS and power planning', 'Servers and storage', 'Backup architecture', 'Monitoring and documentation'],
            ],
            [
                'slug' => 'network-infrastructure-operations-afghanistan',
                'title' => ['en' => 'Network Infrastructure & Operations', 'fa' => 'زیربنا و عملیات شبکه', 'ps' => 'د شبکې زیربنا او عملیات'],
                'query' => ['en' => 'network infrastructure company Afghanistan', 'fa' => 'شرکت شبکه و زیربنا افغانستان', 'ps' => 'د شبکې زیربنا شرکت افغانستان'],
                'summary' => ['en' => 'LAN, WAN, routing, switching, wireless, structured cabling, network monitoring and operational administration for secure connectivity.', 'fa' => 'LAN، WAN، routing، switching، wireless، structured cabling، monitoring و مدیریت عملیاتی شبکه.', 'ps' => 'LAN، WAN، routing، switching، wireless، structured cabling، monitoring او د شبکې عملیاتي اداره.'],
                'capabilities' => ['LAN and WAN', 'Routing and switching', 'Enterprise Wi-Fi', 'Structured cabling', 'Network monitoring', 'Operations and administration'],
            ],
            [
                'slug' => 'cloud-server-infrastructure-afghanistan',
                'title' => ['en' => 'Cloud & Server Infrastructure', 'fa' => 'زیربنای کلود و سرور', 'ps' => 'د کلاوډ او سرور زیربنا'],
                'query' => ['en' => 'server cloud infrastructure Afghanistan', 'fa' => 'کلود و سرور افغانستان', 'ps' => 'کلاوډ او سرور افغانستان'],
                'summary' => ['en' => 'Physical servers, virtualization, private cloud, approved public cloud, backup, disaster recovery and hybrid infrastructure planning.', 'fa' => 'سرور فزیکی، virtualization، private cloud، public cloud تأییدشده، backup، disaster recovery و زیربنای hybrid.', 'ps' => 'فزیکي سرورونه، virtualization، private cloud، تایید شوی public cloud، backup، disaster recovery او hybrid زیربنا.'],
                'capabilities' => ['Physical servers', 'Virtualization', 'Private cloud', 'Hybrid infrastructure', 'Backup and recovery', 'Migration planning'],
            ],
            [
                'slug' => 'cybersecurity-solutions-afghanistan',
                'title' => ['en' => 'Cybersecurity & Infrastructure Security', 'fa' => 'امنیت سایبری و امنیت زیربنا', 'ps' => 'سایبري او د زیربنا امنیت'],
                'query' => ['en' => 'cybersecurity solutions Afghanistan', 'fa' => 'خدمات امنیت سایبری افغانستان', 'ps' => 'سایبري امنیت خدمتونه افغانستان'],
                'summary' => ['en' => 'Security architecture, firewalls, endpoint controls, identity, hardening, logging, backup protection and infrastructure security implementation.', 'fa' => 'معماری امنیت، firewall، endpoint، identity، hardening، logging، حفاظت backup و امنیت زیربنا.', 'ps' => 'امنیتي معماري، firewall، endpoint، identity، hardening، logging، backup ساتنه او د زیربنا امنیت.'],
                'capabilities' => ['Firewall deployment', 'Endpoint controls', 'Identity and access', 'Server hardening', 'Security logging', 'Backup protection'],
            ],
            [
                'slug' => 'enterprise-hardware-technology-supply-afghanistan',
                'title' => ['en' => 'Enterprise Hardware & Technology Supply', 'fa' => 'تجهیزات و تأمین تکنالوژی سازمانی', 'ps' => 'سازماني تجهیزات او د ټکنالوژۍ عرضه'],
                'query' => ['en' => 'enterprise IT hardware supplier Afghanistan', 'fa' => 'تأمین تجهیزات IT افغانستان', 'ps' => 'د IT تجهیزاتو عرضه کوونکی افغانستان'],
                'summary' => ['en' => 'Procurement and supply of enterprise servers, networking equipment, workstations, storage, UPS, peripherals and project technology under a defined BOQ.', 'fa' => 'تدارک و تأمین سرور، تجهیزات شبکه، workstation، storage، UPS، peripherals و تجهیزات پروژه مطابق BOQ.', 'ps' => 'د BOQ مطابق د سرورونو، شبکې تجهیزاتو، workstation، storage، UPS، peripherals او پروژوي ټکنالوژۍ تدارک او عرضه.'],
                'capabilities' => ['Servers and storage', 'Switches and routers', 'Firewalls', 'Workstations', 'UPS and power equipment', 'Project BOQ supply'],
            ],
            [
                'slug' => 'systems-integration-deployment-afghanistan',
                'title' => ['en' => 'Systems Integration & Deployment', 'fa' => 'یکپارچه‌سازی و تطبیق سیستم‌ها', 'ps' => 'د سیسټمونو ادغام او پلي کول'],
                'query' => ['en' => 'systems integration company Afghanistan', 'fa' => 'شرکت یکپارچه سازی سیستم افغانستان', 'ps' => 'د سیسټم ادغام شرکت افغانستان'],
                'summary' => ['en' => 'Integrate software, APIs, servers, networks, identity, data and devices, then test, commission, document and hand over the complete solution.', 'fa' => 'نرم‌افزار، API، سرور، شبکه، identity، data و device را یکپارچه، آزمایش، commissioning، مستند و تحویل کنید.', 'ps' => 'سافټویر، API، سرور، شبکه، identity، data او device یوځای، ازموینه، commissioning، مستند او وسپارئ.'],
                'capabilities' => ['Software and API integration', 'Infrastructure integration', 'Migration', 'Testing and commissioning', 'Documentation', 'Controlled handover'],
            ],
            [
                'slug' => 'managed-it-services-afghanistan',
                'title' => ['en' => 'IT Consulting, Support & Managed Services', 'fa' => 'مشاوره، پشتیبانی و خدمات مدیریت‌شده IT', 'ps' => 'IT مشوره، ملاتړ او مدیریت شوي خدمتونه'],
                'query' => ['en' => 'managed IT services Afghanistan', 'fa' => 'خدمات مدیریت شده IT افغانستان', 'ps' => 'مدیریت شوي IT خدمتونه افغانستان'],
                'summary' => ['en' => 'Technology consulting, infrastructure assessment, server and network administration, maintenance, monitoring, support, training and documentation.', 'fa' => 'مشاوره تکنالوژی، ارزیابی زیربنا، مدیریت سرور و شبکه، maintenance، monitoring، پشتیبانی، آموزش و documentation.', 'ps' => 'د ټکنالوژۍ مشوره، د زیربنا ارزونه، د سرور او شبکې اداره، maintenance، monitoring، ملاتړ، روزنه او documentation.'],
                'capabilities' => ['IT assessment', 'Network administration', 'Server administration', 'Monitoring', 'Maintenance and support', 'Training and documentation'],
            ],
        ];

        return collect($definitions)
            ->map(fn (array $definition, int $index): array => $this->page($definition, ($index + 1) * 10))
            ->all();
    }

    private function page(array $definition, int $sortOrder): array
    {
        $title = $definition['title'];
        $summary = $definition['summary'];
        $capabilityList = '<ul>'.collect($definition['capabilities'])->map(fn (string $item): string => '<li>'.e($item).'</li>')->implode('').'</ul>';

        return [
            'type' => 'solution',
            'slug' => $definition['slug'],
            'title' => $title,
            'eyebrow' => [
                'en' => 'Enterprise capability for institutional delivery',
                'fa' => 'توانایی سازمانی برای تحویل حرفه‌ای',
                'ps' => 'د مسلکي سپارنې لپاره سازماني وړتیا',
            ],
            'summary' => $summary,
            'body' => [
                'en' => '<h2>'.$title['en'].' for accountable projects</h2><p>'.$summary['en'].'</p><h2>Typical scope</h2>'.$capabilityList.'<h2>Government and NGO delivery</h2><p>For institutional procurement, the scope can be separated into equipment, licenses, professional services, installation, configuration, testing, training, documentation, support and warranty assumptions. Fida confirms brands, quantities, technical specifications and commercial terms against the approved RFQ, RFP, tender or statement of work.</p><h2>How an engagement starts</h2><p>Share the technical scope, BOQ, current environment, locations, required standards, deadline and support expectations. Fida can then prepare a scope-based technical and commercial response.</p>',
                'fa' => '<h2>'.$title['fa'].'</h2><p>'.$summary['fa'].'</p><h2>تحویل برای دولت و NGO</h2><p>محدوده می‌تواند تجهیزات، لایسنس، خدمات مسلکی، نصب، تنظیم، آزمایش، آموزش، اسناد، پشتیبانی و شرایط warranty را جداگانه مشخص کند.</p>',
                'ps' => '<h2>'.$title['ps'].'</h2><p>'.$summary['ps'].'</p><h2>د دولت او NGO لپاره سپارنه</h2><p>حدود کې تجهیزات، لایسنس، مسلکي خدمتونه، نصب، تنظیم، ازموینه، روزنه، اسناد، ملاتړ او warranty شرایط جلا ښودل کېدای شي.</p>',
            ],
            'meta_title' => [
                'en' => match ($definition['slug']) {
                    'cybersecurity-solutions-afghanistan' => 'Cybersecurity Solutions Afghanistan | Fida Technologies',
                    'enterprise-hardware-technology-supply-afghanistan' => 'Enterprise IT Hardware Afghanistan | Fida Technologies',
                    'managed-it-services-afghanistan' => 'Managed IT Services Afghanistan | Fida Technologies',
                    default => $title['en'].' Afghanistan | Fida Technologies',
                },
                'fa' => $title['fa'].' افغانستان | فدا',
                'ps' => $title['ps'].' افغانستان | فدا',
            ],
            'meta_description' => $summary,
            'primary_query' => $definition['query'],
            'search_intent' => 'commercial',
            'metadata' => [
                'solution' => [
                    'outcomes' => ['en' => 'A documented, testable and supportable technology outcome.', 'fa' => 'نتیجه تکنالوژی مستند، قابل آزمایش و قابل پشتیبانی.', 'ps' => 'مستند، د ازموینې وړ او د ملاتړ وړ ټکنالوژیکه پایله.'],
                    'control' => ['en' => 'Scope, specifications, responsibilities, acceptance and changes are controlled.', 'fa' => 'محدوده، مشخصات، مسئولیت، پذیرش و تغییرات کنترول می‌شود.', 'ps' => 'حدود، مشخصات، مسؤلیت، منل او بدلونونه کنټرولېږي.'],
                    'decisions' => ['en' => 'Architecture, procurement, implementation and support decisions are recorded before handover.', 'fa' => 'تصامیم معماری، تدارکات، تطبیق و پشتیبانی پیش از تحویل ثبت می‌شود.', 'ps' => 'د معمارۍ، تدارکاتو، پلي کولو او ملاتړ پرېکړې تر سپارنې مخکې ثبتېږي.'],
                    'capabilities' => collect($definition['capabilities'])->map(fn (string $item): array => ['en' => $item])->all(),
                ],
                'faqs' => [
                    [
                        'question' => ['en' => 'Can this capability be included in a government or NGO RFQ?', 'fa' => 'آیا این توانایی در RFQ دولت یا NGO شامل می‌شود؟', 'ps' => 'ایا دا وړتیا د دولت یا NGO په RFQ کې شاملېدای شي؟'],
                        'answer' => ['en' => 'Yes. Fida can respond to a defined RFQ, RFP, tender or statement of work and separate supply, implementation, configuration, training, support and other commercial components as required.', 'fa' => 'بله. فدا می‌تواند به RFQ، RFP، tender یا statement of work مشخص پاسخ دهد و بخش‌های supply، تطبیق، تنظیم، آموزش و پشتیبانی را جدا کند.', 'ps' => 'هو. فدا مشخص RFQ، RFP، tender یا statement of work ته ځواب ورکولای شي او عرضه، پلي کول، تنظیم، روزنه او ملاتړ جلا ښودلای شي.'],
                    ],
                    [
                        'question' => ['en' => 'Does Fida provide installation and documentation?', 'fa' => 'آیا فدا نصب و اسناد را ارائه می‌کند؟', 'ps' => 'ایا فدا نصب او اسناد برابروي؟'],
                        'answer' => ['en' => 'Installation, configuration, testing, commissioning, documentation and training can be included when they are part of the approved project scope.', 'fa' => 'نصب، تنظیم، آزمایش، commissioning، اسناد و آموزش در صورت شمول در محدوده تأییدشده قابل ارائه است.', 'ps' => 'نصب، تنظیم، ازموینه، commissioning، اسناد او روزنه د تایید شوو حدودو په صورت کې شاملېدای شي.'],
                    ],
                ],
                'cta' => [
                    'heading' => ['en' => 'Send the technical requirement to Fida', 'fa' => 'نیازمندی تخنیکی را به فدا ارسال کنید', 'ps' => 'تخنیکي اړتیا فدا ته واستوئ'],
                    'description' => ['en' => 'Use the RFQ channel for a BOQ, RFP, tender, infrastructure scope or combined technology requirement.', 'fa' => 'برای BOQ، RFP، tender، محدوده زیربنا یا نیازمندی ترکیبی از کانال RFQ استفاده کنید.', 'ps' => 'د BOQ، RFP، tender، زیربنا scope یا ګډې ټکنالوژۍ اړتیا لپاره RFQ وکاروئ.'],
                    'primary_label' => ['en' => 'Submit RFQ', 'fa' => 'ارسال RFQ', 'ps' => 'RFQ وسپارئ'],
                    'primary_intent' => 'tender',
                ],
            ],
            'status' => 'published',
            'featured' => true,
            'sort_order' => $sortOrder,
            'sitemap_included' => true,
            'sitemap_priority' => 0.8,
            'sitemap_change_frequency' => 'monthly',
            'published_at' => now(),
        ];
    }
}
