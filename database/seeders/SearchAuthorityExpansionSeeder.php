<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class SearchAuthorityExpansionSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->newPages() as $page) {
            ContentPage::query()->firstOrCreate(['slug' => $page['slug']], $page);
        }

        $this->strengthenTechnologyPage();
        $this->strengthenErpPage();
        $this->strengthenSupportingPages();
    }

    private function newPages(): array
    {
        $now = now();

        return [
            [
                'type' => 'page',
                'slug' => 'software-company-afghanistan',
                'title' => [
                    'en' => 'Software Company in Afghanistan',
                    'fa' => 'شرکت نرم‌افزار در افغانستان',
                    'ps' => 'په افغانستان کې د سافټویر شرکت',
                ],
                'eyebrow' => [
                    'en' => 'Enterprise software, web and mobile development',
                    'fa' => 'نرم‌افزار سازمانی، ویب و موبایل',
                    'ps' => 'سازماني سافټویر، وېب او موبایل',
                ],
                'summary' => [
                    'en' => 'Fida Technologies is a Kabul-based software company developing ERP, MIS, financial systems, databases, web applications, mobile apps and custom business software for organizations in Afghanistan.',
                    'fa' => 'Fida Technologies یک شرکت نرم‌افزار در کابل است که ERP، MIS، سیستم‌های مالی، دیتابیس، ویب‌اپلیکیشن، اپلیکیشن موبایل و نرم‌افزار اختصاصی برای سازمان‌های افغانستان می‌سازد.',
                    'ps' => 'Fida Technologies په کابل کې د سافټویر شرکت دی چې په افغانستان کې د ادارو لپاره ERP، MIS، مالي سیسټمونه، ډیټابیس، وېب اپلېکېشنونه، موبایل اپونه او ځانګړی سوداګریز سافټویر جوړوي.',
                ],
                'body' => [
                    'en' => '<h2>Software development for organizations in Afghanistan</h2><p><strong>Fida Technologies is a software company in Afghanistan</strong> focused on business and enterprise systems rather than generic one-size-fits-all packages. We design software around real users, approvals, records, reports, integrations and operating controls.</p><h2>Looking for software companies in Afghanistan?</h2><p>Software companies can differ substantially in focus. Some specialize in websites, some in mobile apps, and others in accounting or packaged products. Fida focuses on ERP, MIS, finance, workflow automation, databases, custom web applications, mobile applications and industry-specific platforms.</p><h2>What Fida develops</h2><ul><li>ERP and MIS platforms</li><li>Accounting, finance and multi-currency systems</li><li>Custom business software and management systems</li><li>Database-backed web applications and data platforms</li><li>Android and iOS applications with secure APIs</li><li>Websites, portals and SaaS products</li><li>System integrations, reporting and workflow automation</li></ul><h2>Built for Afghanistan and multilingual operations</h2><p>Projects can support English, Dari and Pashto, right-to-left interfaces, branch operations, multi-currency workflows, role-based access, approvals, audit history and reporting where required by the approved scope.</p><h2>Software company in Kabul</h2><p>Fida Technologies is based in Kabul, Afghanistan. Organizations can engage Fida for discovery, requirements analysis, architecture, development, testing, deployment, training and continued improvement.</p>',
                    'fa' => '<h2>توسعه نرم‌افزار برای سازمان‌های افغانستان</h2><p><strong>Fida Technologies یک شرکت نرم‌افزار در افغانستان است</strong> که روی سیستم‌های تجارتی و سازمانی تمرکز دارد. ما نرم‌افزار را مطابق کاربران واقعی، تأییدی‌ها، اسناد، گزارش‌ها، یکپارچه‌سازی و کنترول‌های عملیاتی طراحی می‌کنیم.</p><h2>به دنبال شرکت‌های نرم‌افزاری در افغانستان هستید؟</h2><p>شرکت‌های نرم‌افزاری می‌توانند تخصص‌های متفاوت داشته باشند. برخی روی ویب‌سایت، برخی روی موبایل و برخی روی حسابداری یا محصولات آماده تمرکز دارند. فدا روی ERP، MIS، سیستم مالی، اتوماسیون روند، دیتابیس، ویب‌اپلیکیشن اختصاصی، اپلیکیشن موبایل و پلتفرم‌های تخصصی صنایع کار می‌کند.</p><h2>فدا چه می‌سازد</h2><ul><li>پلتفرم‌های ERP و MIS</li><li>سیستم حسابداری، مالی و چندارزی</li><li>نرم‌افزار اختصاصی و سیستم مدیریت شرکت</li><li>ویب‌اپلیکیشن و پلتفرم داده مبتنی بر دیتابیس</li><li>اپلیکیشن Android و iOS با API امن</li><li>ویب‌سایت، پورتال و محصول SaaS</li><li>یکپارچه‌سازی سیستم، گزارش‌دهی و اتوماسیون روند</li></ul><h2>مناسب برای افغانستان و محیط چندزبانه</h2><p>پروژه‌ها می‌توانند انگلیسی، دری و پشتو، رابط راست‌به‌چپ، چند شعبه، چند ارز، نقش و صلاحیت، تأییدی، تاریخچه فعالیت و گزارش‌دهی را مطابق محدوده تأییدشده پشتیبانی کنند.</p><h2>شرکت نرم‌افزار در کابل</h2><p>Fida Technologies در کابل، افغانستان مستقر است و خدمات تحلیل نیازمندی، معماری، توسعه، آزمایش، نصب، آموزش و بهبود دوامدار را ارائه می‌کند.</p>',
                    'ps' => '<h2>په افغانستان کې د ادارو لپاره د سافټویر جوړول</h2><p><strong>Fida Technologies په افغانستان کې د سافټویر شرکت دی</strong> چې پر سوداګریزو او سازماني سیسټمونو تمرکز کوي. موږ سافټویر د واقعي کاروونکو، تاییدونو، اسنادو، راپورونو، ادغامونو او عملیاتي کنټرولونو مطابق جوړوو.</p><h2>په افغانستان کې د سافټویر شرکتونو په لټه کې یاست؟</h2><p>د سافټویر شرکتونه بېلابېل تخصصونه لري. ځینې وېب‌سایټونه، ځینې موبایل اپونه او ځینې حسابداري یا چمتو محصولات جوړوي. فدا په ERP، MIS، مالي سیسټمونو، کاري بهیر اتومات، ډیټابیس، ځانګړو وېب اپلېکېشنونو، موبایل اپونو او سکتوري پلېټفارمونو تمرکز کوي.</p><h2>فدا څه جوړوي</h2><ul><li>ERP او MIS پلېټفارمونه</li><li>حسابداري، مالي او څو اسعارو سیسټمونه</li><li>ځانګړی سوداګریز سافټویر او د شرکت مدیریت سیسټمونه</li><li>د ډیټابیس پر بنسټ وېب اپلېکېشنونه او ډیټا پلېټفارمونه</li><li>Android او iOS اپلېکېشنونه له خوندي API سره</li><li>وېب‌سایټونه، پورټلونه او SaaS محصولات</li><li>سیسټم ادغام، راپورونه او د کاري بهیر اتومات</li></ul><h2>د افغانستان او څوژبي عملیاتو لپاره</h2><p>پروژې د تایید شوو حدودو مطابق انګلیسي، دري او پښتو، ښي نه چپ انترفېس، څانګې، څو اسعار، رولونه او صلاحیتونه، تاییدونه، د فعالیت تاریخ او راپورونه ملاتړ کولی شي.</p><h2>په کابل کې د سافټویر شرکت</h2><p>Fida Technologies په کابل، افغانستان کې موقعیت لري او د اړتیاوو تحلیل، معماري، جوړول، ازموینه، نصب، روزنه او دوامداره ښه‌والی وړاندې کوي.</p>',
                ],
                'meta_title' => [
                    'en' => 'Software Company in Afghanistan | Fida Technologies',
                    'fa' => 'شرکت نرم‌افزار در افغانستان | Fida Technologies',
                    'ps' => 'په افغانستان کې د سافټویر شرکت | Fida Technologies',
                ],
                'meta_description' => [
                    'en' => 'Afghanistan software company for ERP, MIS, finance, databases, custom web applications and mobile apps. Fida Technologies is based in Kabul.',
                    'fa' => 'شرکت نرم‌افزار افغانستان برای ERP، MIS، سیستم مالی، دیتابیس، ویب‌اپلیکیشن اختصاصی و اپلیکیشن موبایل؛ مستقر در کابل.',
                    'ps' => 'په افغانستان کې د ERP، MIS، مالي سیسټمونو، ډیټابیس، ځانګړو وېب اپلېکېشنونو او موبایل اپونو سافټویر شرکت؛ په کابل کې.',
                ],
                'primary_query' => [
                    'en' => 'software company in Afghanistan',
                    'fa' => 'شرکت نرم افزار در افغانستان',
                    'ps' => 'په افغانستان کې د سافټویر شرکت',
                ],
                'search_intent' => 'commercial',
                'robots_directive' => 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
                'sitemap_included' => true,
                'sitemap_priority' => 0.9,
                'sitemap_change_frequency' => 'weekly',
                'sitemap_last_modified_at' => $now,
                'metadata' => [
                    'secondary_queries' => [
                        'software companies in Afghanistan',
                        'software development company Afghanistan',
                        'software company Kabul',
                        'IT company Afghanistan',
                        'شرکت نرم افزاری افغانستان',
                        'شرکت سافتویر افغانستان',
                        'شرکت برنامه نویسی افغانستان',
                        'سافټویر شرکت افغانستان',
                        'د سافټویر جوړولو شرکت افغانستان',
                    ],
                    'related_slugs' => ['technology-company-afghanistan', 'technology-companies-afghanistan', 'custom-software-development-afghanistan', 'erp-systems-afghanistan', 'database-systems-afghanistan', 'mobile-app-development-afghanistan'],
                    'faqs' => [
                        $this->faq(
                            ['en' => 'What type of software company is Fida Technologies?', 'fa' => 'Fida Technologies چه نوع شرکت نرم‌افزاری است؟', 'ps' => 'Fida Technologies څه ډول سافټویر شرکت دی؟'],
                            ['en' => 'Fida is a Kabul-based software and technology company focused on ERP, MIS, financial systems, databases, custom web applications, mobile apps and integrations.', 'fa' => 'فدا یک شرکت نرم‌افزار و تکنالوژی مستقر در کابل است که روی ERP، MIS، سیستم مالی، دیتابیس، ویب‌اپلیکیشن اختصاصی، موبایل و یکپارچه‌سازی تمرکز دارد.', 'ps' => 'فدا په کابل کې د سافټویر او ټکنالوژۍ شرکت دی چې ERP، MIS، مالي سیسټمونه، ډیټابیس، ځانګړي وېب اپلېکېشنونه، موبایل او ادغامونه جوړوي.'],
                        ),
                        $this->faq(
                            ['en' => 'Does Fida build custom software in Afghanistan?', 'fa' => 'آیا فدا در افغانستان نرم‌افزار اختصاصی می‌سازد؟', 'ps' => 'ایا فدا په افغانستان کې ځانګړی سافټویر جوړوي؟'],
                            ['en' => 'Yes. Projects can be designed around an organization’s users, workflows, permissions, reports, integrations and deployment requirements.', 'fa' => 'بله. پروژه می‌تواند مطابق کاربران، روندها، صلاحیت‌ها، گزارش‌ها، یکپارچه‌سازی و نیازهای نصب سازمان طراحی شود.', 'ps' => 'هو. پروژه د ادارې د کاروونکو، کاري بهیرونو، صلاحیتونو، راپورونو، ادغامونو او نصب اړتیاوو مطابق جوړېدای شي.'],
                        ),
                    ],
                ],
                'status' => 'published',
                'featured' => true,
                'sort_order' => 18,
                'published_at' => $now,
            ],
            [
                'type' => 'service',
                'slug' => 'database-systems-afghanistan',
                'title' => [
                    'en' => 'Database Systems & Development in Afghanistan',
                    'fa' => 'سیستم‌های دیتابیس و توسعه دیتابیس در افغانستان',
                    'ps' => 'په افغانستان کې د ډیټابیس سیسټمونه او پراختیا',
                ],
                'eyebrow' => [
                    'en' => 'Business databases, migration and connected applications',
                    'fa' => 'دیتابیس تجارتی، انتقال معلومات و برنامه‌های متصل',
                    'ps' => 'سوداګریز ډیټابیس، د معلوماتو لېږد او تړلي اپلېکېشنونه',
                ],
                'summary' => [
                    'en' => 'Design secure business database systems for accounting, customers, inventory, sales, operations and reporting, with APIs, migration and web or mobile access.',
                    'fa' => 'دیتابیس امن برای حسابداری، مشتریان، موجودی، فروش، عملیات و گزارش‌دهی همراه با API، انتقال معلومات و دسترسی ویب یا موبایل.',
                    'ps' => 'د حسابدارۍ، مشتریانو، موجودي، خرڅلاو، عملیاتو او راپورونو لپاره خوندي ډیټابیس سیسټمونه له API، معلوماتو لېږد او وېب یا موبایل لاسرسي سره.',
                ],
                'body' => [
                    'en' => '<h2>Database systems for real business records</h2><p>In Afghanistan, many buyers use the word <strong>database</strong> for the complete system that stores and manages company records. Fida can design both the database layer and the business application around it, so users work through controlled forms, permissions, workflows and reports instead of accessing raw tables.</p><h2>Database use cases</h2><ul><li>Accounting and finance databases</li><li>Customer and supplier databases</li><li>Inventory, warehouse and stock databases</li><li>Sales, invoice and POS databases</li><li>HR, payroll and attendance databases</li><li>Project, NGO, healthcare, education and sector-specific records</li></ul><h2>Database development and migration</h2><p>Projects may include data modelling, MySQL or other approved relational databases, secure APIs, validation, imports, exports, migration from spreadsheets or legacy systems, backups, audit history and integration with web or mobile applications.</p><h2>Database company in Kabul</h2><p>Fida Technologies is based in Kabul and develops database-backed systems for organizations that need reliable records, controlled access and useful reporting. The final architecture depends on the data volume, users, connectivity, integrations, security and deployment requirements.</p>',
                    'fa' => '<h2>سیستم دیتابیس برای اسناد واقعی تجارت</h2><p>در افغانستان بسیاری از مشتریان از واژه <strong>دیتابیس</strong> برای کل سیستمی استفاده می‌کنند که معلومات شرکت را ثبت و مدیریت می‌کند. فدا می‌تواند هم ساختار دیتابیس و هم برنامه تجارتی روی آن را طراحی کند تا کاربران از فورم‌ها، صلاحیت‌ها، روندها و گزارش‌های کنترول‌شده استفاده کنند.</p><h2>کاربردهای دیتابیس</h2><ul><li>دیتابیس حسابداری و مالی</li><li>دیتابیس مشتری و تأمین‌کننده</li><li>دیتابیس گدام، موجودی و stock</li><li>دیتابیس فروش، فاکتور و POS</li><li>دیتابیس منابع بشری، معاش و حاضری</li><li>دیتابیس پروژه، NGO، صحی، تعلیمی و سیستم‌های تخصصی</li></ul><h2>ساخت و انتقال دیتابیس</h2><p>پروژه می‌تواند طراحی ساختار معلومات، MySQL یا دیتابیس رابطه‌ای تأییدشده، API امن، validation، import/export، انتقال از Excel یا سیستم قدیمی، بکاپ، تاریخچه فعالیت و اتصال به ویب یا موبایل را شامل شود.</p><h2>شرکت دیتابیس در کابل</h2><p>Fida Technologies در کابل مستقر است و برای سازمان‌هایی که به اسناد قابل اعتماد، دسترسی کنترول‌شده و گزارش مفید نیاز دارند سیستم‌های مبتنی بر دیتابیس می‌سازد.</p>',
                    'ps' => '<h2>د واقعي سوداګریزو اسنادو لپاره ډیټابیس سیسټمونه</h2><p>په افغانستان کې ډېر مشتریان د <strong>ډیټابیس</strong> کلمه د هغه بشپړ سیسټم لپاره کاروي چې د شرکت معلومات ثبت او مدیریت کوي. فدا هم د ډیټابیس جوړښت او هم پرې ولاړ سوداګریز اپلېکېشن جوړولی شي، څو کاروونکي د کنټرول شوو فورمو، صلاحیتونو، بهیرونو او راپورونو له لارې کار وکړي.</p><h2>د ډیټابیس کارونې</h2><ul><li>د حسابدارۍ او مالي ډیټابیس</li><li>د مشتریانو او عرضه کوونکو ډیټابیس</li><li>د ګدام، موجودي او stock ډیټابیس</li><li>د خرڅلاو، انوایس او POS ډیټابیس</li><li>د بشري سرچینو، معاش او حاضري ډیټابیس</li><li>د پروژو، NGO، روغتیا، زده‌کړو او سکتوري معلوماتو ډیټابیس</li></ul><h2>د ډیټابیس جوړول او د معلوماتو لېږد</h2><p>پروژه کې د معلوماتو ماډل، MySQL یا بل تایید شوی relational database، خوندي API، validation، import/export، له Excel یا زاړه سیسټم څخه migration، بیک‌اپ، د فعالیت تاریخ او وېب یا موبایل سره ادغام شاملېدای شي.</p><h2>په کابل کې د ډیټابیس شرکت</h2><p>Fida Technologies په کابل کې موقعیت لري او د هغو ادارو لپاره د ډیټابیس پر بنسټ سیسټمونه جوړوي چې باوري اسناد، کنټرول شوی لاسرسی او ګټور راپورونه غواړي.</p>',
                ],
                'meta_title' => [
                    'en' => 'Database Systems & Development Afghanistan | Fida',
                    'fa' => 'سیستم و توسعه دیتابیس افغانستان | Fida Technologies',
                    'ps' => 'ډیټابیس سیسټم او پراختیا افغانستان | Fida Technologies',
                ],
                'meta_description' => [
                    'en' => 'Database development in Afghanistan for accounting, customers, inventory, sales and management systems, including migration, APIs and reporting.',
                    'fa' => 'ساخت دیتابیس در افغانستان برای حسابداری، مشتری، گدام، موجودی، فروش و سیستم مدیریت همراه با انتقال معلومات، API و گزارش.',
                    'ps' => 'په افغانستان کې د حسابدارۍ، مشتریانو، ګدام، موجودي، خرڅلاو او مدیریت لپاره ډیټابیس جوړول، migration، API او راپورونه.',
                ],
                'primary_query' => [
                    'en' => 'database systems Afghanistan',
                    'fa' => 'سیستم دیتابیس افغانستان',
                    'ps' => 'ډیټابیس سیستم افغانستان',
                ],
                'search_intent' => 'commercial',
                'robots_directive' => 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
                'sitemap_included' => true,
                'sitemap_priority' => 0.9,
                'sitemap_change_frequency' => 'weekly',
                'sitemap_last_modified_at' => $now,
                'metadata' => [
                    'secondary_queries' => [
                        'database company Afghanistan',
                        'database development Afghanistan',
                        'database software Afghanistan',
                        'business database Afghanistan',
                        'accounting database Afghanistan',
                        'database company Kabul',
                        'دیتابیس افغانستان',
                        'شرکت دیتابیس افغانستان',
                        'ساخت دیتابیس در افغانستان',
                        'دیتابیس حسابداری',
                        'دیتابیس گدام',
                        'ډیټابیس افغانستان',
                        'د ډیټابیس جوړولو شرکت افغانستان',
                        'د حسابدارۍ ډیټابیس',
                        'د ګدام ډیټابیس',
                    ],
                    'related_slugs' => ['software-company-afghanistan', 'custom-software-development-afghanistan', 'accounting-software-afghanistan', 'procurement-inventory-management-software-afghanistan', 'erp-systems-afghanistan'],
                    'faqs' => [
                        $this->faq(
                            ['en' => 'Does Fida develop database systems in Afghanistan?', 'fa' => 'آیا فدا در افغانستان سیستم دیتابیس می‌سازد؟', 'ps' => 'ایا فدا په افغانستان کې د ډیټابیس سیسټمونه جوړوي؟'],
                            ['en' => 'Yes. Fida develops database-backed business systems for finance, customers, inventory, sales, HR, projects and other approved workflows.', 'fa' => 'بله. فدا سیستم‌های مبتنی بر دیتابیس برای مالی، مشتریان، موجودی، فروش، منابع بشری، پروژه و سایر روندهای تأییدشده می‌سازد.', 'ps' => 'هو. فدا د مالي، مشتریانو، موجودي، خرڅلاو، بشري سرچینو، پروژو او نورو تایید شوو بهیرونو لپاره د ډیټابیس پر بنسټ سیسټمونه جوړوي.'],
                        ),
                        $this->faq(
                            ['en' => 'Can an Excel database be migrated to a business system?', 'fa' => 'آیا معلومات Excel به سیستم دیتابیس منتقل می‌شود؟', 'ps' => 'ایا د Excel معلومات ډیټابیس سیسټم ته لېږدول کېدای شي؟'],
                            ['en' => 'Often yes, after the source data is reviewed, mapped, cleaned and validated. Migration scope and reconciliation should be agreed before production import.', 'fa' => 'در بسیاری موارد بله، پس از بررسی، mapping، پاک‌سازی و اعتبارسنجی معلومات. محدوده انتقال و تطبیق باید پیش از import نهایی توافق شود.', 'ps' => 'په ډېرو مواردو کې هو، وروسته له دې چې سرچینه وکتل شي، mapping، پاکول او validation ترسره شي. د migration حدود باید د نهایي import مخکې هوکړه شي.'],
                        ),
                    ],
                ],
                'status' => 'published',
                'featured' => true,
                'sort_order' => 19,
                'published_at' => $now,
            ],
            [
                'type' => 'solution',
                'slug' => 'pos-software-afghanistan',
                'title' => [
                    'en' => 'POS & Retail Software in Afghanistan',
                    'fa' => 'نرم‌افزار POS و فروشگاه در افغانستان',
                    'ps' => 'په افغانستان کې POS او د پلورنځي سافټویر',
                ],
                'eyebrow' => [
                    'en' => 'Sales, stock, cash and branches in one workflow',
                    'fa' => 'فروش، موجودی، صندوق و شعبات در یک روند',
                    'ps' => 'خرڅلاو، موجودي، نغدې او څانګې په یوه بهیر کې',
                ],
                'summary' => [
                    'en' => 'POS and retail software for shops, supermarkets, wholesalers and multi-branch businesses that need sales, stock, purchasing, cash and reporting in one system.',
                    'fa' => 'سیستم POS و فروش برای دکان، سوپرمارکت، عمده‌فروش و تجارت چندشعبه با فروش، موجودی، خرید، صندوق و گزارش‌دهی.',
                    'ps' => 'د دوکانونو، سوپرمارکېټونو، عمده پلورونکو او څو څانګو سوداګریو لپاره POS او retail سافټویر له خرڅلاو، موجودي، پېرود، نغدو او راپورونو سره.',
                ],
                'body' => [
                    'en' => '<h2>POS software for Afghan retail operations</h2><p>A practical POS system should do more than print a receipt. It should connect sales with products, stock, purchases, customers, cash, returns, user permissions and management reporting.</p><h2>Core retail capabilities</h2><ul><li>Fast sales and invoice workflow</li><li>Barcode-ready product search and scanning</li><li>Inventory, warehouse and branch stock</li><li>Purchasing and supplier records</li><li>Cash, expenses and daily closing</li><li>Customer balances and approved credit workflows</li><li>User permissions, activity history and reports</li></ul><h2>Supermarket and shop software</h2><p>The system can be scoped for a small shop, supermarket, wholesale operation or multi-branch retailer. Offline-aware or desktop-assisted workflows can be considered where connectivity and device requirements justify them.</p>',
                    'fa' => '<h2>سیستم POS برای فروشگاه‌های افغانستان</h2><p>یک سیستم POS عملی نباید تنها رسید چاپ کند. باید فروش را با محصولات، موجودی، خرید، مشتری، صندوق، برگشت، صلاحیت کاربران و گزارش مدیریتی یکجا سازد.</p><h2>امکانات اصلی فروش</h2><ul><li>فروش و فاکتور سریع</li><li>جستجو و اسکن بارکد</li><li>موجودی، گدام و stock شعبات</li><li>خرید و تأمین‌کننده</li><li>صندوق، مصارف و بستن روزانه</li><li>بیلانس مشتری و فروش قرضی تأییدشده</li><li>صلاحیت کاربران، تاریخچه فعالیت و گزارش</li></ul><h2>نرم‌افزار سوپرمارکت و دکان</h2><p>سیستم می‌تواند برای دکان کوچک، سوپرمارکت، عمده‌فروشی یا تجارت چندشعبه طراحی شود. در صورت نیاز می‌توان روند آفلاین‌محور یا دسکتاپ را نیز بررسی کرد.</p>',
                    'ps' => '<h2>د افغانستان د پرچون لپاره POS سیسټم</h2><p>عملي POS سیسټم باید یوازې رسید چاپ نه کړي. خرڅلاو باید له محصولاتو، موجودي، پېرود، مشتریانو، نغدو، بېرته ستنولو، د کاروونکو صلاحیتونو او مدیریتي راپورونو سره ونښلوي.</p><h2>اصلي امکانات</h2><ul><li>چټک خرڅلاو او انوایس</li><li>بارکوډ لټون او سکین</li><li>موجودي، ګدام او د څانګو stock</li><li>پېرود او عرضه کوونکي</li><li>نغدې، مصارف او ورځنی closing</li><li>د مشتریانو بیلانس او تایید شوی پور</li><li>صلاحیتونه، د فعالیت تاریخ او راپورونه</li></ul><h2>د سوپرمارکېټ او دوکان سافټویر</h2><p>سیسټم د کوچني دوکان، سوپرمارکېټ، عمده پلور یا څو څانګو retail لپاره طرحه کېدای شي. که اتصال او وسایل اړتیا ولري، offline-aware یا desktop-assisted بهیر هم ارزول کېدای شي.</p>',
                ],
                'meta_title' => [
                    'en' => 'POS Software Afghanistan | Retail & Supermarket System',
                    'fa' => 'نرم‌افزار POS افغانستان | سیستم فروش و سوپرمارکت',
                    'ps' => 'POS سافټویر افغانستان | د خرڅلاو او سوپرمارکېټ سیستم',
                ],
                'meta_description' => [
                    'en' => 'POS software in Afghanistan for shops, supermarkets and wholesalers with sales, barcode, inventory, purchasing, cash, customers and reporting.',
                    'fa' => 'سیستم POS افغانستان برای دکان، سوپرمارکت و عمده‌فروشی با فروش، بارکد، گدام، خرید، صندوق، مشتری و گزارش.',
                    'ps' => 'په افغانستان کې د دوکان، سوپرمارکېټ او عمده پلور لپاره POS سافټویر له خرڅلاو، بارکوډ، ګدام، پېرود، نغدو او راپورونو سره.',
                ],
                'primary_query' => [
                    'en' => 'POS software Afghanistan',
                    'fa' => 'سیستم POS افغانستان',
                    'ps' => 'POS سیستم افغانستان',
                ],
                'search_intent' => 'commercial',
                'robots_directive' => 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
                'sitemap_included' => true,
                'sitemap_priority' => 0.8,
                'sitemap_change_frequency' => 'weekly',
                'sitemap_last_modified_at' => $now,
                'metadata' => [
                    'secondary_queries' => [
                        'retail software Afghanistan',
                        'supermarket software Afghanistan',
                        'shop software Afghanistan',
                        'billing software Afghanistan',
                        'نرم افزار سوپرمارکت افغانستان',
                        'سیستم فروش افغانستان',
                        'سیستم دکان',
                        'سوپرمارکېټ سافټویر افغانستان',
                        'د دوکان سافټویر',
                    ],
                    'related_slugs' => ['procurement-inventory-management-software-afghanistan', 'accounting-software-afghanistan', 'erp-systems-afghanistan', 'software-company-afghanistan'],
                    'faqs' => [
                        $this->faq(
                            ['en' => 'Can POS software manage inventory and purchasing?', 'fa' => 'آیا POS می‌تواند موجودی و خرید را مدیریت کند؟', 'ps' => 'ایا POS موجودي او پېرود هم مدیریت کولی شي؟'],
                            ['en' => 'Yes, when included in scope. Sales can reduce stock while purchasing, receipts, transfers and adjustments maintain inventory history.', 'fa' => 'بله، اگر در محدوده پروژه شامل باشد. فروش می‌تواند موجودی را کاهش دهد و خرید، رسید، انتقال و adjustment تاریخچه stock را نگهدارد.', 'ps' => 'هو، که د پروژې په حدودو کې شامل وي. خرڅلاو stock کموي او پېرود، رسید، انتقال او adjustment د موجودي تاریخ ساتي.'],
                        ),
                    ],
                ],
                'status' => 'published',
                'featured' => false,
                'sort_order' => 45,
                'published_at' => $now,
            ],
        ];
    }

    private function strengthenTechnologyPage(): void
    {
        $page = ContentPage::query()->where('slug', 'technology-company-afghanistan')->first();

        if (! $page) {
            return;
        }

        $metadata = (array) $page->metadata;

        if (data_get($metadata, 'search_authority_2026_10_07')) {
            return;
        }

        $body = (array) $page->body;
        $metaDescription = (array) $page->meta_description;
        $primaryQuery = (array) $page->primary_query;

        $body['fa'] = '<h2>شرکت تکنالوژی و نرم‌افزار برای نیازهای واقعی افغانستان</h2><p><strong>Fida Technologies یک شرکت تکنالوژی و نرم‌افزار در افغانستان است</strong> که در کابل فعالیت می‌کند. ما ERP، MIS، سیستم‌های مالی و حسابداری، دیتابیس، نرم‌افزار اختصاصی، ویب‌اپلیکیشن، اپلیکیشن موبایل، API و یکپارچه‌سازی برای سازمان‌ها می‌سازیم.</p><h2>در جستجوی شرکت‌های تکنالوژی، IT یا ICT در افغانستان؟</h2><p>شرکت‌های مخابرات، انترنت، شبکه، هاستینگ، آژانس دیجیتال و نرم‌افزار همه ممکن است زیر عنوان تکنالوژی ظاهر شوند. فدا روی نرم‌افزار سازمانی و سیستم‌های تجارتی تمرکز دارد. اگر نیاز شما ERP، دیتابیس، حسابداری، مدیریت شرکت، ویب یا موبایل باشد، توانایی تطبیق و پشتیبانی نرم‌افزار مهم‌تر از عنوان عمومی شرکت است.</p><h2>خدمات اصلی فدا</h2><ul><li>ERP، MIS و سیستم مدیریت شرکت</li><li>سیستم مالی، حسابداری و چندارزی</li><li>دیتابیس تجارتی، انتقال معلومات و گزارش‌دهی</li><li>نرم‌افزار اختصاصی، Laravel، پورتال و SaaS</li><li>اپلیکیشن Android و iOS</li><li>ویب‌سایت، API، یکپارچه‌سازی و اتوماسیون روند</li></ul><h2>شرکت IT در کابل</h2><p>Fida Technologies در کابل، افغانستان مستقر است و پروژه‌ها را از تحلیل نیازمندی تا طراحی، توسعه، آزمایش، نصب، آموزش و پشتیبانی پیش می‌برد.</p>';
        $body['ps'] = '<h2>د افغانستان د واقعي اړتیاوو لپاره د ټکنالوژۍ او سافټویر شرکت</h2><p><strong>Fida Technologies په افغانستان کې د ټکنالوژۍ او سافټویر شرکت دی</strong> چې په کابل کې فعالیت کوي. موږ ERP، MIS، مالي او حسابدارۍ سیسټمونه، ډیټابیس، ځانګړی سافټویر، وېب اپلېکېشنونه، موبایل اپونه، API او ادغامونه جوړوو.</p><h2>په افغانستان کې د ټکنالوژۍ، IT یا ICT شرکتونو په لټه کې یاست؟</h2><p>مخابرات، انټرنېټ، شبکه، هاستینګ، ډیجیټل ادارې او سافټویر شرکتونه ټول د ټکنالوژۍ تر نوم لاندې ښکاره کېدای شي. فدا پر سازماني سافټویر او سوداګریزو سیسټمونو تمرکز کوي. که اړتیا ERP، ډیټابیس، حسابداري، د شرکت مدیریت، وېب یا موبایل وي، د پلي کولو او ملاتړ وړتیا تر عمومي نوم مهمه ده.</p><h2>د فدا اصلي خدمتونه</h2><ul><li>ERP، MIS او د شرکت مدیریت سیسټمونه</li><li>مالي، حسابدارۍ او څو اسعارو سیسټمونه</li><li>سوداګریز ډیټابیس، د معلوماتو لېږد او راپورونه</li><li>ځانګړی سافټویر، Laravel، پورټل او SaaS</li><li>Android او iOS اپلېکېشنونه</li><li>وېب‌سایټ، API، ادغام او د کاري بهیر اتومات</li></ul><h2>په کابل کې IT شرکت</h2><p>Fida Technologies په کابل، افغانستان کې موقعیت لري او پروژه له اړتیاوو تحلیل څخه تر ډیزاین، جوړولو، ازموینې، نصب، روزنې او ملاتړ پورې پر مخ وړي.</p>';

        $metaDescription['fa'] = 'Fida Technologies شرکت تکنالوژی، IT و نرم‌افزار در کابل برای ERP، MIS، حسابداری، دیتابیس، نرم‌افزار اختصاصی، ویب و اپلیکیشن موبایل.';
        $metaDescription['ps'] = 'Fida Technologies په کابل کې د ټکنالوژۍ، IT او سافټویر شرکت دی چې ERP، MIS، حسابداري، ډیټابیس، ځانګړی سافټویر، وېب او موبایل جوړوي.';
        $primaryQuery['en'] = 'technology company in Afghanistan';

        $metadata['secondary_queries'] = array_values(array_unique(array_merge(
            (array) ($metadata['secondary_queries'] ?? []),
            [
                'technology companies in Afghanistan',
                'IT company Afghanistan',
                'ICT company Afghanistan',
                'software company Afghanistan',
                'technology company Kabul',
                'شرکت IT افغانستان',
                'شرکت ICT افغانستان',
                'شرکت نرم افزار افغانستان',
                'IT شرکت افغانستان',
                'ICT شرکت افغانستان',
                'د معلوماتي ټکنالوژۍ شرکت افغانستان',
            ],
        )));
        $metadata['related_slugs'] = array_values(array_unique(array_merge(
            (array) ($metadata['related_slugs'] ?? []),
            ['software-company-afghanistan', 'database-systems-afghanistan', 'technology-companies-afghanistan'],
        )));
        $metadata['faqs'] = [
            $this->faq(
                ['en' => 'What services does Fida Technologies provide in Afghanistan?', 'fa' => 'Fida Technologies در افغانستان چه خدماتی ارائه می‌کند؟', 'ps' => 'Fida Technologies په افغانستان کې کوم خدمتونه وړاندې کوي؟'],
                ['en' => 'Fida provides ERP, MIS, accounting and financial systems, databases, custom software, web applications, websites, mobile apps, workflow automation and integrations.', 'fa' => 'فدا ERP، MIS، سیستم حسابداری و مالی، دیتابیس، نرم‌افزار اختصاصی، ویب‌اپلیکیشن، ویب‌سایت، اپلیکیشن موبایل، اتوماسیون روند و یکپارچه‌سازی ارائه می‌کند.', 'ps' => 'فدا ERP، MIS، حسابدارۍ او مالي سیسټمونه، ډیټابیس، ځانګړی سافټویر، وېب اپلېکېشنونه، وېب‌سایټونه، موبایل اپونه، د کاري بهیر اتومات او ادغامونه وړاندې کوي.'],
            ),
            $this->faq(
                ['en' => 'Is Fida Technologies an IT and software company in Afghanistan?', 'fa' => 'آیا Fida Technologies یک شرکت IT و نرم‌افزار در افغانستان است؟', 'ps' => 'ایا Fida Technologies په افغانستان کې IT او سافټویر شرکت دی؟'],
                ['en' => 'Yes. Fida Technologies is a Kabul-based software and technology company focused on enterprise and business systems.', 'fa' => 'بله. Fida Technologies یک شرکت نرم‌افزار و تکنالوژی مستقر در کابل با تمرکز بر سیستم‌های سازمانی و تجارتی است.', 'ps' => 'هو. Fida Technologies په کابل کې د سافټویر او ټکنالوژۍ شرکت دی چې پر سازماني او سوداګریزو سیسټمونو تمرکز کوي.'],
            ),
            $this->faq(
                ['en' => 'Which languages can Fida software support?', 'fa' => 'نرم‌افزارهای فدا از کدام زبان‌ها پشتیبانی می‌کنند؟', 'ps' => 'د فدا سافټویر کومې ژبې ملاتړ کولی شي؟'],
                ['en' => 'Projects can support English, Dari and Pashto, including right-to-left interfaces where required.', 'fa' => 'پروژه‌ها می‌توانند انگلیسی، دری و پشتو را همراه با رابط راست‌به‌چپ پشتیبانی کنند.', 'ps' => 'پروژې انګلیسي، دري او پښتو او د اړتیا په صورت کې ښي نه چپ انترفېس ملاتړ کولی شي.'],
            ),
        ];
        $metadata['search_authority_2026_10_07'] = true;

        $page->update([
            'body' => $body,
            'meta_description' => $metaDescription,
            'primary_query' => $primaryQuery,
            'metadata' => $metadata,
            'sitemap_last_modified_at' => now(),
        ]);
    }

    private function strengthenErpPage(): void
    {
        $page = ContentPage::query()->where('slug', 'erp-systems-afghanistan')->first();

        if (! $page) {
            return;
        }

        $metadata = (array) $page->metadata;

        if (data_get($metadata, 'search_authority_2026_10_07')) {
            return;
        }

        $metaDescription = (array) $page->meta_description;
        $metaDescription['en'] = 'ERP systems and ERP implementation in Afghanistan for finance, procurement, inventory, HR, projects and reporting. Fida Technologies is a Kabul ERP software company.';
        $metaDescription['fa'] = 'سیستم ERP و تطبیق ERP در افغانستان برای مالی، تدارکات، گدام، منابع بشری، پروژه و گزارش؛ توسط شرکت نرم‌افزار ERP در کابل.';
        $metaDescription['ps'] = 'په افغانستان کې ERP سیسټم او پلي کول د مالي، تدارکاتو، ګدام، بشري سرچینو، پروژو او راپورونو لپاره؛ د کابل ERP سافټویر شرکت.';

        $metadata['secondary_queries'] = array_values(array_unique(array_merge(
            (array) ($metadata['secondary_queries'] ?? []),
            [
                'ERP company Afghanistan',
                'ERP companies Afghanistan',
                'ERP provider Afghanistan',
                'ERP vendor Afghanistan',
                'ERP implementation company Afghanistan',
                'ERP software Kabul',
                'شرکت ERP افغانستان',
                'شرکت تطبیق ERP افغانستان',
                'نرم افزار ERP افغانستان',
                'ERP شرکت افغانستان',
                'د ERP جوړولو شرکت افغانستان',
                'د ERP پلي کولو شرکت افغانستان',
            ],
        )));
        $metadata['related_slugs'] = array_values(array_unique(array_merge(
            (array) ($metadata['related_slugs'] ?? []),
            ['software-company-afghanistan', 'database-systems-afghanistan'],
        )));
        $metadata['faqs'] = array_merge((array) ($metadata['faqs'] ?? []), [
            $this->faq(
                ['en' => 'Is Fida Technologies an ERP company in Afghanistan?', 'fa' => 'آیا Fida Technologies یک شرکت ERP در افغانستان است؟', 'ps' => 'ایا Fida Technologies په افغانستان کې ERP شرکت دی؟'],
                ['en' => 'Yes. Fida Technologies develops and implements ERP and related enterprise systems from Kabul for organizations with finance, procurement, inventory, HR, project and reporting requirements.', 'fa' => 'بله. Fida Technologies از کابل سیستم‌های ERP و سازمانی را برای نیازهای مالی، تدارکات، گدام، منابع بشری، پروژه و گزارش‌دهی توسعه و تطبیق می‌کند.', 'ps' => 'هو. Fida Technologies له کابل څخه د مالي، تدارکاتو، ګدام، بشري سرچینو، پروژو او راپورونو اړتیاوو لپاره ERP او سازماني سیسټمونه جوړوي او پلي کوي.'],
            ),
        ]);
        $metadata['search_authority_2026_10_07'] = true;

        $page->update([
            'meta_description' => $metaDescription,
            'metadata' => $metadata,
            'sitemap_last_modified_at' => now(),
        ]);
    }

    private function strengthenSupportingPages(): void
    {
        $targets = [
            'custom-software-development-afghanistan' => [
                'software development company Afghanistan',
                'software developer Afghanistan',
                'شرکت توسعه نرم افزار افغانستان',
                'شرکت برنامه نویسی افغانستان',
                'د سافټویر جوړولو شرکت افغانستان',
            ],
            'procurement-inventory-management-software-afghanistan' => [
                'inventory software Afghanistan',
                'warehouse software Afghanistan',
                'stock management Afghanistan',
                'سیستم گدام افغانستان',
                'نرم افزار گدام',
                'د ګدام سیستم افغانستان',
                'د موجودي مدیریت سیستم',
            ],
            'accounting-software-afghanistan' => [
                'accounting system Afghanistan',
                'financial software Afghanistan',
                'bookkeeping software Afghanistan',
                'دیتابیس حسابداری',
                'سیستم حسابات افغانستان',
                'د حسابدارۍ ډیټابیس',
            ],
            'mobile-app-development-afghanistan' => [
                'mobile app company Afghanistan',
                'app development company Afghanistan',
                'Android developer Afghanistan',
                'iOS developer Afghanistan',
                'Flutter development Afghanistan',
            ],
        ];

        foreach ($targets as $slug => $queries) {
            $page = ContentPage::query()->where('slug', $slug)->first();

            if (! $page) {
                continue;
            }

            $metadata = (array) $page->metadata;
            $metadata['secondary_queries'] = array_values(array_unique(array_merge(
                (array) ($metadata['secondary_queries'] ?? []),
                $queries,
            )));
            $metadata['search_authority_support_2026_10_07'] = true;

            $page->update([
                'metadata' => $metadata,
                'sitemap_last_modified_at' => now(),
            ]);
        }
    }

    private function faq(array $question, array $answer): array
    {
        return compact('question', 'answer');
    }
}
