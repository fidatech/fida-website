<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class EnterpriseAuthoritySeeder extends Seeder
{
    private const PREVIOUS_ABOUT_BODY_EN = '<h2>We begin with the operation, not the feature list</h2><p>Fida Technologies works with organizations that need clearer control, connected records and software designed around how their teams actually work. Discovery comes before architecture so the product solves the right operational problem.</p><h2>What guides our work</h2><ul><li>Business rules should be explicit and testable</li><li>Permissions, approvals and activity history should protect accountability</li><li>Reports should support decisions, not only display data</li><li>English, Dari and Pashto experiences should be usable from the initial design</li><li>Software should remain maintainable as the organization grows</li></ul><h2>From first discussion to continued improvement</h2><p>Our process covers workflow discovery, solution design, development, testing, deployment, training and improvement. The exact stages and responsibilities are documented in each approved project scope.</p>';

    public function run(): void
    {
        $about = ContentPage::query()->where('slug', 'about')->first();

        if (! $about || $about->translation('body', 'en') !== self::PREVIOUS_ABOUT_BODY_EN) {
            return;
        }

        $about->update($this->aboutProfile());
    }

    private function aboutProfile(): array
    {
        return [
            'title' => [
                'en' => 'About Fida Technologies',
                'fa' => 'درباره Fida Technologies',
                'ps' => 'د Fida Technologies په اړه',
            ],
            'eyebrow' => [
                'en' => 'Enterprise technology. Afghan context.',
                'fa' => 'تکنالوژی سازمانی با شناخت افغانستان',
                'ps' => 'سازماني ټکنالوژي، د افغانستان له درک سره',
            ],
            'summary' => [
                'en' => 'An Afghanistan-based enterprise software company building ERP, MIS, financial, data, web and mobile systems for organizations with serious operational requirements.',
                'fa' => 'یک شرکت نرم‌افزار سازمانی در افغانستان که برای نهادهای دارای نیازهای جدی عملیاتی، سیستم‌های ERP، MIS، مالی، داده، وب و موبایل می‌سازد.',
                'ps' => 'په افغانستان کې د سازماني سافټویر شرکت چې د جدي عملیاتي اړتیاوو لرونکو ادارو لپاره ERP، MIS، مالي، ډیټا، وېب او موبایل سیسټمونه جوړوي.',
            ],
            'body' => [
                'en' => '<h2>Who we are</h2><p>Fida Technologies is an Afghanistan-based enterprise software and technology company. We design ERP, MIS, financial systems, custom applications, integrations, data platforms and mobile products around the real responsibilities, controls and reporting needs of an organization.</p><h2>Our story</h2><p>The technology experience behind Fida began in 2014 through professional software work, including experience with WeSoft Technologies and later technology work within government. Fida Technologies began operations in 2022 and was formally licensed in 2024. This distinction matters: the experience began before the company, while Fida itself has served organizations since 2022.</p><h2>Mission and direction</h2><p>Our mission is to help organizations replace disconnected records and difficult manual processes with secure, understandable and maintainable digital systems. Our direction is to build an Afghan technology company capable of delivering enterprise platforms that meet serious operational and institutional requirements.</p><h2>What we build</h2><ul><li>Enterprise resource planning and management information systems</li><li>Financial, accounting and multi-currency platforms</li><li>Custom enterprise applications, portals and workflow systems</li><li>System integrations, APIs, databases and data migration workflows</li><li>Mobile applications and connected administration platforms</li><li>Industry systems for real estate, construction, finance, Sarafi, logistics, pharmaceutical and other operational domains</li></ul><h2>How we deliver</h2><p>Each engagement begins with discovery and requirements analysis. The approved project scope can define architecture, interfaces, roles, permissions, reports, integrations, migration, delivery stages and acceptance responsibilities. Development proceeds through reviewable milestones before controlled deployment and handover.</p><h2>Security, accountability and reliability</h2><p>We design access around defined roles and responsibilities. Where the approved scope requires them, systems can include controlled approvals, activity history, audit trails, validation, backups, multilingual access and separation of sensitive duties. Security and hosting responsibilities are documented for the specific engagement rather than implied by a generic promise.</p><h2>Deployment, training and support</h2><p>Solutions may be deployed in an approved cloud, private hosting or on-premise environment when the architecture and operational requirements support it. Data migration, user acceptance testing, training, documentation, maintenance and service levels are defined in the proposal or agreement for each project.</p><h2>Built for serious organizations</h2><p>Fida works toward long-term relationships with enterprises, public institutions, NGOs, INGOs and other organizations that need dependable systems and accountable delivery. We do not publish client results, project statistics or institutional references unless they are verified and approved for public use.</p>',
                'fa' => '<h2>ما کی هستیم</h2><p>Fida Technologies یک شرکت نرم‌افزار سازمانی و تکنالوژی مستقر در افغانستان است. سیستم‌های ERP، MIS، مالی، برنامه‌های اختصاصی، یکپارچه‌سازی، پلتفرم‌های داده و محصولات موبایل را مطابق مسئولیت‌ها، کنترول‌ها و نیازهای واقعی گزارش‌دهی سازمان طراحی می‌کنیم.</p><h2>داستان ما</h2><p>تجربه تکنالوژی پشت Fida در سال ۲۰۱۴ با کار مسلکی نرم‌افزار آغاز شد؛ از جمله تجربه با WeSoft Technologies و سپس کار تکنالوژی در دولت. فعالیت Fida Technologies در ۲۰۲۲ آغاز شد و شرکت در ۲۰۲۴ رسماً جواز گرفت. این تفاوت مهم است: تجربه پیش از شرکت آغاز شده، اما خود فدا از ۲۰۲۲ به سازمان‌ها خدمت می‌کند.</p><h2>ماموریت و مسیر ما</h2><p>ماموریت ما کمک به سازمان‌ها برای جایگزینی اسناد پراکنده و روندهای دشوار دستی با سیستم‌های دیجیتال امن، قابل فهم و قابل نگهداری است. مسیر ما ساختن یک شرکت تکنالوژی افغان است که توان تحویل پلتفرم‌های سازمانی برای نیازهای جدی عملیاتی و نهادی را داشته باشد.</p><h2>آنچه می‌سازیم</h2><ul><li>سیستم‌های ERP و سیستم معلومات مدیریت MIS</li><li>پلتفرم‌های مالی، حسابداری و چندارزی</li><li>برنامه‌های سازمانی اختصاصی، پورتال و مدیریت روند</li><li>یکپارچه‌سازی سیستم، API، دیتابیس و انتقال معلومات</li><li>اپلیکیشن موبایل و پلتفرم مدیریتی مرتبط</li><li>سیستم‌های املاک، ساختمان، مالی، صرافی، لوژستیک، دارویی و سایر حوزه‌های عملیاتی</li></ul><h2>روش تحویل ما</h2><p>هر همکاری با شناخت و تحلیل نیازمندی آغاز می‌شود. محدوده تأییدشده می‌تواند معماری، رابط، نقش، صلاحیت، گزارش، یکپارچه‌سازی، انتقال معلومات، مراحل تحویل و مسئولیت پذیرش را مشخص سازد. توسعه در مراحل قابل بررسی پیش می‌رود و سپس نصب و تحویل کنترول‌شده انجام می‌شود.</p><h2>امنیت، پاسخگویی و قابلیت اعتماد</h2><p>دسترسی را بر اساس نقش و مسئولیت تعریف‌شده طراحی می‌کنیم. مطابق محدوده تأییدشده، سیستم می‌تواند تأییدی کنترول‌شده، تاریخچه فعالیت، audit trail، اعتبارسنجی، بکاپ، دسترسی چندزبانه و تفکیک مسئولیت‌های حساس را شامل شود. مسئولیت امنیت و میزبانی برای هر پروژه به‌صورت مشخص مستند می‌شود.</p><h2>نصب، آموزش و پشتیبانی</h2><p>راهکار می‌تواند در محیط cloud تأییدشده، میزبانی خصوصی یا on-premise نصب شود، در صورتی که معماری و نیاز عملیاتی آن را مناسب بسازد. انتقال معلومات، UAT، آموزش، مستندسازی، نگهداری و SLA در پیشنهاد یا قرارداد هر پروژه تعریف می‌شود.</p><h2>برای سازمان‌های جدی</h2><p>فدا برای همکاری دوامدار با شرکت‌های بزرگ، نهادهای عمومی، NGO، INGO و سازمان‌هایی کار می‌کند که به سیستم قابل اعتماد و تحویل پاسخگو نیاز دارند. نتایج مشتری، آمار پروژه یا مراجع نهادی را بدون تأیید و اجازه نشر نمی‌کنیم.</p>',
                'ps' => '<h2>موږ څوک یو</h2><p>Fida Technologies په افغانستان کې د سازماني سافټویر او ټکنالوژۍ شرکت دی. موږ ERP، MIS، مالي سیسټمونه، ځانګړي اپلېکېشنونه، ادغامونه، ډیټا پلېټفارمونه او موبایل محصولات د ادارې د واقعي مسؤلیتونو، کنټرولونو او راپورونو مطابق طرحه کوو.</p><h2>زموږ کیسه</h2><p>د فدا تر شا د ټکنالوژۍ تجربه په ۲۰۱۴ کې د مسلکي سافټویر کار له لارې پیل شوه؛ پکې له WeSoft Technologies سره تجربه او وروسته په دولت کې د ټکنالوژۍ مسلکي کار شامل دی. د Fida Technologies فعالیت په ۲۰۲۲ کې پیل شو او شرکت په ۲۰۲۴ کې رسماً جواز ترلاسه کړ. دا توپیر مهم دی: تجربه د شرکت تر جوړېدو مخکې پیل شوې، خو فدا خپله له ۲۰۲۲ راهیسې ادارو ته خدمت کوي.</p><h2>ماموریت او لوری</h2><p>زموږ ماموریت دا دی چې له ادارو سره مرسته وکړو څو جلا اسناد او ستونزمن لاسي بهیرونه په خوندي، د پوهېدو وړ او د ساتنې وړ ډیجیټل سیسټمونو بدل کړي. زموږ لوری د داسې افغان ټکنالوژۍ شرکت جوړول دي چې د جدي عملیاتي او سازماني اړتیاوو لپاره سازماني پلېټفارمونه وسپاري.</p><h2>موږ څه جوړوو</h2><ul><li>ERP او د مدیریت معلوماتي MIS سیسټمونه</li><li>مالي، حسابدارۍ او څو اسعارو پلېټفارمونه</li><li>ځانګړي سازماني اپلېکېشنونه، پورټلونه او کاري بهیرونه</li><li>د سیسټم ادغام، API، ډیټابیس او د معلوماتو لېږد</li><li>موبایل اپلېکېشنونه او تړلي مدیریتي پلېټفارمونه</li><li>د املاکو، ودانیزو چارو، مالي، صرافۍ، لوژستیک، درملو او نورو عملیاتي برخو سیسټمونه</li></ul><h2>زموږ د سپارلو لاره</h2><p>هره همکاري له پېژندنې او د اړتیاوو له تحلیل څخه پیلېږي. تایید شوي حدود معماري، انترفېس، رولونه، صلاحیتونه، راپورونه، ادغامونه، د معلوماتو لېږد، د سپارلو پړاوونه او د منلو مسؤلیتونه ټاکلی شي. پراختیا د کتنې وړ پړاوونو کې کېږي او وروسته کنټرول شوی نصب او سپارل ترسره کېږي.</p><h2>امنیت، حساب ورکونه او باور</h2><p>لاسرسی د ټاکل شوو رولونو او مسؤلیتونو مطابق طرحه کوو. د تایید شوو حدودو پر بنسټ سیسټم کې کنټرول شوي تاییدونه، د فعالیت تاریخ، audit trail، validation، بیک‌اپ، څوژبی لاسرسی او د حساسو دندو جلاوالی شاملېدای شي. د امنیت او کوربه‌توب مسؤلیتونه د هرې پروژې لپاره په مشخص ډول مستند کېږي.</p><h2>نصب، روزنه او ملاتړ</h2><p>حللاره په تایید شوي cloud، شخصي کوربه‌توب یا on-premise چاپېریال کې نصب کېدای شي، که معماري او عملیاتي اړتیاوې یې مناسبې وي. د معلوماتو لېږد، UAT، روزنه، اسناد، ساتنه او SLA د هرې پروژې په وړاندیز یا تړون کې ټاکل کېږي.</p><h2>د جدي ادارو لپاره</h2><p>فدا له لویو شرکتونو، عامه ادارو، NGO، INGO او هغو سازمانونو سره اوږدمهاله همکارۍ ته کار کوي چې باوري سیسټم او حساب ورکوونکې سپارنه غواړي. موږ د مشتری پایلې، د پروژو شمېرې یا سازماني مراجع له تایید او د نشر له اجازې پرته نه خپروو.</p>',
            ],
            'meta_title' => [
                'en' => 'About Fida Technologies | Enterprise Software Afghanistan',
                'fa' => 'درباره Fida Technologies | نرم‌افزار سازمانی افغانستان',
                'ps' => 'د Fida Technologies په اړه | سازماني سافټویر افغانستان',
            ],
            'meta_description' => [
                'en' => 'Learn about Fida Technologies, its verified 2014–2024 history, enterprise software capabilities and delivery approach in Afghanistan.',
                'fa' => 'با تاریخ تأییدشده ۲۰۱۴ تا ۲۰۲۴، توانایی‌های نرم‌افزار سازمانی و روش تحویل Fida Technologies در افغانستان آشنا شوید.',
                'ps' => 'په افغانستان کې د Fida Technologies د ۲۰۱۴–۲۰۲۴ تایید شوی تاریخ، سازماني سافټویر وړتیاوې او د سپارلو لاره وپېژنئ.',
            ],
            'primary_query' => [
                'en' => 'Fida Technologies Afghanistan',
                'fa' => 'Fida Technologies افغانستان',
                'ps' => 'Fida Technologies افغانستان',
            ],
            'search_intent' => 'navigational',
            'metadata' => [
                'faqs' => [
                    $this->faq(
                        ['en' => 'When did Fida Technologies begin?', 'fa' => 'Fida Technologies چه زمانی آغاز شد؟', 'ps' => 'Fida Technologies کله پیل شو؟'],
                        ['en' => 'The technology experience behind Fida began in 2014. Fida Technologies began operations in 2022 and was formally licensed in 2024.', 'fa' => 'تجربه تکنالوژی پشت فدا در ۲۰۱۴ آغاز شد. فعالیت Fida Technologies در ۲۰۲۲ شروع و شرکت در ۲۰۲۴ رسماً جواز گرفت.', 'ps' => 'د فدا تر شا د ټکنالوژۍ تجربه په ۲۰۱۴ کې پیل شوه. د Fida Technologies فعالیت په ۲۰۲۲ کې پیل او شرکت په ۲۰۲۴ کې رسماً جواز ترلاسه کړ.'],
                    ),
                    $this->faq(
                        ['en' => 'Where is Fida Technologies based?', 'fa' => 'Fida Technologies در کجا مستقر است؟', 'ps' => 'Fida Technologies چېرته موقعیت لري؟'],
                        ['en' => 'Fida Technologies is based in Kabul, Afghanistan.', 'fa' => 'Fida Technologies در کابل، افغانستان مستقر است.', 'ps' => 'Fida Technologies په کابل، افغانستان کې موقعیت لري.'],
                    ),
                    $this->faq(
                        ['en' => 'What does Fida Technologies build?', 'fa' => 'Fida Technologies چه سیستم‌هایی می‌سازد؟', 'ps' => 'Fida Technologies څه جوړوي؟'],
                        ['en' => 'Fida builds ERP, MIS, financial systems, custom applications, data platforms, integrations, mobile applications and industry-specific software.', 'fa' => 'فدا ERP، MIS، سیستم مالی، برنامه اختصاصی، پلتفرم داده، یکپارچه‌سازی، اپلیکیشن موبایل و نرم‌افزار تخصصی صنایع می‌سازد.', 'ps' => 'فدا ERP، MIS، مالي سیسټمونه، ځانګړي اپلېکېشنونه، ډیټا پلېټفارمونه، ادغامونه، موبایل اپلېکېشنونه او سکتوري سافټویر جوړوي.'],
                    ),
                    $this->faq(
                        ['en' => 'How does an enterprise project begin?', 'fa' => 'یک پروژه سازمانی چگونه آغاز می‌شود؟', 'ps' => 'سازماني پروژه څنګه پیلېږي؟'],
                        ['en' => 'An engagement begins with discovery and requirements analysis before architecture, scope, delivery stages and acceptance responsibilities are agreed.', 'fa' => 'همکاری با شناخت و تحلیل نیازمندی آغاز می‌شود و سپس معماری، محدوده، مراحل تحویل و مسئولیت پذیرش توافق می‌گردد.', 'ps' => 'همکاري له پېژندنې او د اړتیاوو له تحلیل څخه پیلېږي او وروسته معماري، حدود، د سپارلو پړاوونه او د منلو مسؤلیتونه هوکړه کېږي.'],
                    ),
                ],
                'related_slugs' => ['technology-company-afghanistan', 'erp-systems-afghanistan', 'services'],
            ],
        ];
    }

    private function faq(array $question, array $answer): array
    {
        return compact('question', 'answer');
    }
}
