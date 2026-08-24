<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class WebsiteSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            ContentPage::query()->firstOrCreate(['slug' => $page['slug']], $page);
        }

        foreach ($this->caseStudyDrafts() as $caseStudy) {
            ContentPage::query()->firstOrCreate(['slug' => $caseStudy['slug']], $caseStudy);
        }

        $this->call(MarketingContentSeeder::class);
        $this->call(EnterpriseErpAuthoritySeeder::class);
        $this->call(PriorityIndustrySeeder::class);
        $this->call(ConstructionRealEstateIndustrySeeder::class);
        $this->call(ManufacturingHealthcareIndustrySeeder::class);
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
                primaryQuery: ['en' => 'ERP systems in Afghanistan', 'fa' => 'سیستم‌های ERP در افغانستان', 'ps' => 'په افغانستان کې ERP سیسټمونه'],
                searchIntent: 'commercial',
                faqs: [
                    $this->faq('What is an ERP system?', 'An ERP system connects core business functions such as accounting, inventory, sales, purchasing, HR and reporting in one controlled platform.'),
                    $this->faq('Can an ERP system support multiple branches and currencies?', 'Yes. Fida ERP solutions can be designed for branch-level operations, consolidated reporting and multi-currency accounting based on the organization’s workflow.'),
                    $this->faq('Does Fida provide ERP implementation and training in Afghanistan?', 'Yes. Fida supports workflow discovery, configuration, data preparation, deployment, user training and continued improvement for organizations in Afghanistan.'),
                ],
            ),
            $this->page(
                slug: 'custom-software-development-afghanistan',
                title: ['en' => 'Custom Software Development in Afghanistan', 'fa' => 'توسعه نرم‌افزار اختصاصی در افغانستان', 'ps' => 'په افغانستان کې د ځانګړي سافټویر جوړول'],
                eyebrow: ['en' => 'Built around your workflow', 'fa' => 'مطابق روند کاری شما', 'ps' => 'ستاسو د کاري بهیر مطابق'],
                summary: ['en' => 'Secure web and business applications designed for your processes, users and growth plans.', 'fa' => 'وب‌اپلیکیشن‌ها و سیستم‌های امن مطابق روندها، کاربران و پلان رشد شما.', 'ps' => 'خوندي وېب او سوداګریز اپلېکېشنونه ستاسو د پروسو، کاروونکو او ودې مطابق.'],
                body: [
                    'en' => '<h2>Custom software should fit the business</h2><p>Custom software is useful when spreadsheets, disconnected applications or a generic package can no longer support the way an organization works. Fida Technologies studies the workflow first, then designs a maintainable system around the people, decisions, controls and reports that matter.</p><h2>What we can develop</h2><ul><li>ERP and MIS platforms that connect finance and operations</li><li>Workflow applications for approvals, records and reporting</li><li>Customer, supplier, employee and partner portals</li><li>SaaS products with subscriptions and administration tools</li><li>Secure APIs, integrations and mobile application backends</li><li>Modern replacements for difficult legacy applications</li></ul><h2>Designed for practical operations in Afghanistan</h2><p>A project can include English, Dari and Pashto interfaces, right-to-left layouts, multi-currency accounting, branch-level access, roles and permissions, activity history, document workflows and exports. The approved scope determines which capabilities are included.</p><h2>From discovery to deployment</h2><ol><li><strong>Discover:</strong> map users, responsibilities, existing data, problems and required decisions.</li><li><strong>Design:</strong> agree on the product scope, interface direction, architecture and delivery milestones.</li><li><strong>Build:</strong> develop and test the system through reviewable releases.</li><li><strong>Deploy:</strong> prepare the environment, migrate approved data, train users and document handover.</li><li><strong>Improve:</strong> support the released scope and estimate new requirements separately.</li></ol><h2>How to request a useful estimate</h2><p>Describe the current workflow, the people who use it, the records you keep, the reports you need and the main problem you want to solve. We can then recommend whether a focused application, integration, existing Fida product or broader custom platform is the better fit.</p>',
                    'fa' => '<h2>نرم‌افزار اختصاصی باید با تجارت هماهنگ باشد</h2><p>زمانی که فایل‌های اکسل، برنامه‌های جداگانه یا یک نرم‌افزار عمومی دیگر پاسخ‌گوی روش کار سازمان نباشد، نرم‌افزار اختصاصی ارزش پیدا می‌کند. Fida Technologies نخست روند کاری را بررسی و سپس سیستم قابل توسعه‌ای را مطابق کاربران، تصمیم‌ها، کنترول‌ها و گزارش‌های مهم طراحی می‌کند.</p><h2>چه سیستم‌هایی می‌توانیم توسعه دهیم</h2><ul><li>پلتفرم‌های ERP و MIS برای یکپارچه‌سازی مالی و عملیات</li><li>برنامه‌های مدیریت روند، تأییدی، اسناد و گزارش‌دهی</li><li>پورتال مشتری، تأمین‌کننده، کارمند و شریک</li><li>محصولات SaaS با اشتراک و ابزار مدیریت</li><li>API امن، یکپارچه‌سازی و بک‌اند اپلیکیشن موبایل</li><li>جایگزین مدرن برای سیستم‌های قدیمی و دشوار</li></ul><h2>طراحی‌شده برای عملیات واقعی در افغانستان</h2><p>پروژه می‌تواند رابط انگلیسی، دری و پشتو، چیدمان راست‌به‌چپ، حسابداری چندارزی، دسترسی شعبه‌ای، نقش و صلاحیت، تاریخچه فعالیت، گردش اسناد و خروجی معلومات را شامل شود. محدوده تأییدشده مشخص می‌کند کدام قابلیت‌ها شامل است.</p><h2>از شناخت تا راه‌اندازی</h2><ol><li><strong>شناخت:</strong> کاربران، مسئولیت‌ها، معلومات موجود، مشکلات و تصمیم‌های لازم مشخص می‌شود.</li><li><strong>طراحی:</strong> محدوده محصول، جهت رابط، معماری و مراحل تحویل توافق می‌شود.</li><li><strong>توسعه:</strong> سیستم در نسخه‌های قابل بررسی ساخته و آزمایش می‌شود.</li><li><strong>راه‌اندازی:</strong> محیط آماده، معلومات تأییدشده منتقل، کاربران آموزش و تحویل مستند می‌شود.</li><li><strong>بهبود:</strong> محدوده نشرشده پشتیبانی و نیازهای جدید جداگانه برآورد می‌شود.</li></ol><h2>برای دریافت برآورد مفید چه معلوماتی بدهید</h2><p>روند فعلی، کاربران، اسناد، گزارش‌های لازم و مشکل اصلی را توضیح دهید. سپس می‌توانیم مشخص کنیم یک برنامه متمرکز، یکپارچه‌سازی، محصول موجود فیدا یا پلتفرم اختصاصی گسترده کدام مناسب‌تر است.</p>',
                    'ps' => '<h2>ځانګړی سافټویر باید له سوداګرۍ سره برابر وي</h2><p>کله چې Excel فایلونه، جلا پروګرامونه یا عمومي سافټویر نور د ادارې د کار طریقه نه شي پوره کولی، ځانګړی سافټویر ارزښت پیدا کوي. Fida Technologies لومړی کاري بهیر څېړي او وروسته د مهمو کاروونکو، پرېکړو، کنټرولونو او راپورونو مطابق د پراختیا وړ سیسټم ډیزاین کوي.</p><h2>موږ کوم سیسټمونه جوړولی شو</h2><ul><li>د مالي او عملیاتو د یوځای کولو لپاره ERP او MIS پلېټفارمونه</li><li>د تاییدونو، اسنادو او راپورونو لپاره کاري بهیر اپلېکېشنونه</li><li>د مشتریانو، عرضه کوونکو، کارکوونکو او شریکانو پورټلونه</li><li>د ګډون او اډمین وسیلو لرونکي SaaS محصولات</li><li>خوندي API، ادغامونه او د موبایل اپلېکېشن بیک‌اېنډ</li><li>د زړو او ستونزمنو سیسټمونو عصري بدیلونه</li></ul><h2>په افغانستان کې د عملي عملیاتو لپاره ډیزاین</h2><p>پروژه کېدای شي انګلیسي، دري او پښتو انترفېسونه، ښي نه چپ ډیزاین، څو اسعارو حسابداري، د څانګو لاسرسی، رولونه او صلاحیتونه، د فعالیت تاریخ، د اسنادو بهیر او export شامل کړي. تایید شوي حدود ټاکي چې کومې وړتیاوې پکې شاملې دي.</p><h2>له پېژندنې تر پلي کولو</h2><ol><li><strong>پېژندنه:</strong> کاروونکي، مسؤلیتونه، شته معلومات، ستونزې او اړینې پرېکړې ټاکل کېږي.</li><li><strong>ډیزاین:</strong> د محصول حدود، انترفېس، معماري او د سپارلو پړاوونه هوکړه کېږي.</li><li><strong>جوړول:</strong> سیسټم د کتنې وړ نسخو کې جوړېږي او ازمویل کېږي.</li><li><strong>پلي کول:</strong> چاپېریال چمتو، تایید شوي معلومات لېږدول، کاروونکي روزل او مستند سپارل کېږي.</li><li><strong>ښه‌والی:</strong> خپاره شوي حدود ملاتړ کېږي او نوې اړتیاوې جلا اټکل کېږي.</li></ol><h2>د ګټور اټکل لپاره څه معلومات ورکړئ</h2><p>اوسنی کاري بهیر، کاروونکي، اسناد، اړین راپورونه او اصلي ستونزه تشریح کړئ. بیا موږ وړاندیز کولی شو چې یو ځانګړی اپلېکېشن، ادغام، د فیدا موجود محصول یا پراخ ځانګړی پلېټفارم کوم یو مناسب دی.</p>',
                ],
                metaTitle: ['en' => 'Software Development Company in Afghanistan | Fida', 'fa' => 'شرکت توسعه نرم‌افزار در افغانستان | فیدا', 'ps' => 'په افغانستان کې د سافټویر شرکت | فیدا'],
                metaDescription: ['en' => 'Custom software development for businesses in Afghanistan, including ERP, SaaS, portals, APIs and mobile backends.', 'fa' => 'توسعه نرم‌افزار اختصاصی، ERP، SaaS، پورتال، API و بک‌اند موبایل در افغانستان.', 'ps' => 'په افغانستان کې ځانګړی سافټویر، ERP، SaaS، پورټلونه، API او موبایل بیک‌اېنډ.'],
                primaryQuery: ['en' => 'custom software development in Afghanistan', 'fa' => 'توسعه نرم‌افزار اختصاصی در افغانستان', 'ps' => 'په افغانستان کې د ځانګړي سافټویر جوړول'],
                searchIntent: 'commercial',
                faqs: [
                    $this->faq('What kinds of custom software does Fida develop?', 'Fida develops business web applications, ERP and MIS platforms, portals, SaaS products, secure APIs and mobile administration systems.'),
                    $this->faq('How does a custom software project begin?', 'The project begins with workflow discovery. We identify users, permissions, decisions, reports and integrations before proposing the product scope and technical plan.'),
                    $this->faq('Can existing business data be migrated into a new system?', 'Data migration can be included after the source data is reviewed. The practical approach depends on its format, quality, volume and required validation.'),
                ],
            ),
            $this->page(
                slug: 'accounting-software-afghanistan',
                title: ['en' => 'Accounting Software in Afghanistan', 'fa' => 'نرم‌افزار حسابداری در افغانستان', 'ps' => 'په افغانستان کې د حسابدارۍ سافټویر'],
                eyebrow: ['en' => 'Clear financial control', 'fa' => 'کنترول روشن مالی', 'ps' => 'روښانه مالي کنټرول'],
                summary: ['en' => 'Multi-currency accounting, ledgers, journals and professional financial statements for growing businesses.', 'fa' => 'حسابداری چندارزی، دفاتر، ژورنال و صورت‌های مالی حرفه‌ای برای تجارت‌های در حال رشد.', 'ps' => 'د ودې په حال سوداګریو لپاره څو اسعارو حسابداري، لیجرونه، ژورنالونه او مالي راپورونه.'],
                body: ['en' => '<h2>Know where the business stands</h2><p>Track every transaction with linked entries, account statements, approvals and reliable balance sheet, profit and loss, trial balance and cash-flow reports.</p>', 'fa' => '<h2>موقعیت واقعی مالی تجارت را بدانید</h2><p>هر معامله را با ثبت‌های مرتبط، صورت‌حساب، تأییدی و گزارش‌های بیلانس، سود و زیان، تراز آزمایشی و جریان نقدی پیگیری کنید.</p>', 'ps' => '<h2>د سوداګرۍ واقعي مالي حالت وپېژنئ</h2><p>هره معامله له تړلو ثبتونو، حساب‌لیکونو، تاییدونو، بیلانس، ګټې او زیان، ازمایښتي بیلانس او نغدي جریان سره تعقیب کړئ.</p>'],
                metaTitle: ['en' => 'Accounting Software Afghanistan | Fida Technologies', 'fa' => 'نرم‌افزار حسابداری افغانستان | Fida Technologies', 'ps' => 'د حسابدارۍ سافټویر افغانستان | Fida Technologies'],
                metaDescription: ['en' => 'Professional multi-currency accounting software for Afghan companies with ledgers, statements, approvals and financial reports.', 'fa' => 'نرم‌افزار حسابداری چندارزی برای شرکت‌های افغانستان با دفاتر، صورت‌حساب، تأییدی و گزارش‌های مالی.', 'ps' => 'د افغان شرکتونو لپاره څو اسعارو حسابداري، لیجرونه، حساب‌لیکونه، تاییدونه او مالي راپورونه.'],
                faqs: [
                    $this->faq('Does the accounting software support multiple currencies?', 'Yes. The system can maintain multi-currency transactions and ledgers while producing controlled financial reports for the configured business structure.'),
                    $this->faq('Which financial reports can the system provide?', 'Depending on the configured modules, reports can include account statements, trial balance, profit and loss, balance sheet and cash-flow views.'),
                    $this->faq('Can accounting be connected with sales and inventory?', 'Yes. Connected modules can link operational transactions to accounting entries, approvals and reports so teams work from one consistent record.'),
                ],
            ),
            $this->page(
                slug: 'mobile-app-development-afghanistan',
                title: ['en' => 'Mobile App Development in Afghanistan', 'fa' => 'توسعه اپلیکیشن موبایل در افغانستان', 'ps' => 'په افغانستان کې د موبایل اپلېکېشن جوړول'],
                eyebrow: ['en' => 'Android, iOS and reliable backends', 'fa' => 'اندروید، iOS و بک‌اند قابل اعتماد', 'ps' => 'Android، iOS او باوري بیک‌اېنډ'],
                summary: ['en' => 'Fast multilingual mobile applications connected to secure APIs and practical administration systems.', 'fa' => 'اپلیکیشن‌های سریع و چندزبانه متصل به API امن و سیستم مدیریتی عملی.', 'ps' => 'چټک څوژبي موبایل اپلېکېشنونه له خوندي API او عملي مدیریتي سیسټم سره.'],
                body: ['en' => '<h2>One product across mobile and web</h2><p>We develop responsive mobile experiences, secure Laravel APIs, offline-aware workflows, notifications and administration platforms.</p>', 'fa' => '<h2>یک محصول در موبایل و وب</h2><p>تجربه سریع موبایل، API امن لاراول، روندهای مناسب اینترنت ضعیف، اعلان‌ها و سیستم مدیریت را توسعه می‌دهیم.</p>', 'ps' => '<h2>یو محصول په موبایل او وېب کې</h2><p>چټک موبایل تجربه، خوندي Laravel API، د کمزوري انټرنېټ لپاره مناسب بهیر، خبرتیاوې او مدیریتي سیسټم جوړوو.</p>'],
                metaTitle: ['en' => 'Mobile App Development Afghanistan | Fida Technologies', 'fa' => 'توسعه اپلیکیشن موبایل افغانستان | فیدا', 'ps' => 'د موبایل اپلېکېشن جوړول افغانستان | فیدا'],
                metaDescription: ['en' => 'Android and iOS application development in Afghanistan with secure Laravel APIs and multilingual admin systems.', 'fa' => 'توسعه اپلیکیشن اندروید و iOS در افغانستان با API امن لاراول و سیستم مدیریتی چندزبانه.', 'ps' => 'په افغانستان کې Android او iOS اپلېکېشنونه له خوندي Laravel API او څوژبي اډمین سره.'],
                faqs: [
                    $this->faq('Does Fida develop both Android and iOS applications?', 'Yes. The product approach can support Android and iOS together, backed by secure APIs and a practical administration system.'),
                    $this->faq('Can a mobile application work with limited connectivity?', 'Offline-aware workflows can be designed for suitable use cases. The exact behavior depends on which data must remain available and how conflicts should be synchronized.'),
                    $this->faq('Can the app be available in English, Dari and Pashto?', 'Yes. Fida designs multilingual interfaces and right-to-left support for products that need English, Dari and Pashto experiences.'),
                ],
            ),
            $this->page(
                slug: 'technology-company-afghanistan',
                title: ['en' => 'Technology Company in Afghanistan', 'fa' => 'شرکت تکنالوژی در افغانستان', 'ps' => 'په افغانستان کې د ټکنالوژۍ شرکت'],
                eyebrow: ['en' => 'Business technology with local context', 'fa' => 'تکنالوژی تجارتی با شناخت محلی', 'ps' => 'سوداګریزه ټکنالوژي له سیمه‌ییز درک سره'],
                summary: [
                    'en' => 'Fida Technologies is an Afghanistan-based technology company building ERP systems, financial platforms, custom software and mobile applications for serious operations.',
                    'fa' => 'Fida Technologies یک شرکت تکنالوژی مستقر در افغانستان است که سیستم‌های ERP، پلتفرم‌های مالی، نرم‌افزار اختصاصی و اپلیکیشن موبایل می‌سازد.',
                    'ps' => 'Fida Technologies په افغانستان کې د ټکنالوژۍ شرکت دی چې ERP سیسټمونه، مالي پلېټفارمونه، ځانګړی سافټویر او موبایل اپلېکېشنونه جوړوي.',
                ],
                body: [
                    'en' => '<h2>Technology built around real Afghan business workflows</h2><p>Fida Technologies combines local operating knowledge with modern software engineering. We design systems for organizations that need clearer control, dependable data and software that can grow with their teams.</p><h2>What we build</h2><ul><li>ERP and MIS systems for connected operations</li><li>Accounting and multi-currency financial software</li><li>Custom web applications, portals and SaaS products</li><li>Android and iOS applications with secure APIs</li><li>Workflow automation, dashboards and integrations</li></ul><h2>Local collaboration, maintainable engineering</h2><p>Projects can support English, Dari and Pashto interfaces. Our process covers discovery, product design, development, deployment, training and continued improvement.</p>',
                    'fa' => '<h2>تکنالوژی مطابق روند واقعی تجارت‌های افغانستان</h2><p>Fida Technologies شناخت عملیات محلی را با انجنیری مدرن نرم‌افزار یکجا می‌کند. برای سازمان‌هایی سیستم می‌سازیم که به کنترول روشن، معلومات قابل اعتماد و نرم‌افزار قابل توسعه نیاز دارند.</p><h2>آنچه می‌سازیم</h2><ul><li>سیستم‌های ERP و MIS برای عملیات یکپارچه</li><li>حسابداری و نرم‌افزار مالی چندارزی</li><li>وب‌اپلیکیشن، پورتال و محصولات SaaS</li><li>اپلیکیشن اندروید و iOS با API امن</li><li>اتوماسیون روندها، داشبورد و یکپارچه‌سازی</li></ul>',
                    'ps' => '<h2>د افغان سوداګریو د واقعي بهیر مطابق ټکنالوژي</h2><p>Fida Technologies سیمه‌ییز عملیاتي درک له عصري سافټویر انجینرۍ سره یوځای کوي. موږ د هغو ادارو لپاره سیسټمونه جوړوو چې روښانه کنټرول، باوري معلومات او د ودې وړ سافټویر غواړي.</p><h2>موږ څه جوړوو</h2><ul><li>د یوځای عملیاتو لپاره ERP او MIS سیسټمونه</li><li>حسابداري او څو اسعارو مالي سافټویر</li><li>وېب اپلېکېشنونه، پورټلونه او SaaS محصولات</li><li>Android او iOS اپلېکېشنونه له خوندي API سره</li><li>کاري بهیر اتومات، ډشبورډونه او ادغامونه</li></ul>',
                ],
                metaTitle: ['en' => 'Technology Company in Afghanistan | Fida Technologies', 'fa' => 'شرکت تکنالوژی در افغانستان | Fida Technologies', 'ps' => 'په افغانستان کې د ټکنالوژۍ شرکت | Fida Technologies'],
                metaDescription: ['en' => 'Afghanistan technology company building ERP systems, accounting software, custom platforms and mobile applications for organizations.', 'fa' => 'شرکت تکنالوژی افغانستان برای سیستم‌های ERP، نرم‌افزار حسابداری، پلتفرم اختصاصی و اپلیکیشن موبایل.', 'ps' => 'په افغانستان کې د ERP، حسابدارۍ سافټویر، ځانګړو پلېټفارمونو او موبایل اپلېکېشنونو ټکنالوژۍ شرکت.'],
                primaryQuery: ['en' => 'technology company in Afghanistan', 'fa' => 'شرکت تکنالوژی در افغانستان', 'ps' => 'په افغانستان کې د ټکنالوژۍ شرکت'],
                searchIntent: 'local',
                faqs: [
                    $this->faq('What services does Fida Technologies provide in Afghanistan?', 'Fida provides ERP and MIS systems, accounting software, custom web platforms, mobile applications, workflow automation and software integration services.'),
                    $this->faq('Where is Fida Technologies based?', 'Fida Technologies is based in Kabul, Afghanistan and develops business technology for organizations that need locally informed implementation and support.'),
                    $this->faq('Which languages can Fida software support?', 'Fida products can be designed for English, Dari and Pashto, including right-to-left interfaces where required.'),
                ],
            ),
            $this->page(
                slug: 'about',
                title: ['en' => 'About Fida Technologies', 'fa' => 'درباره Fida Technologies', 'ps' => 'د Fida Technologies په اړه'],
                eyebrow: ['en' => 'Local understanding. Serious engineering.', 'fa' => 'شناخت محلی، انجنیری حرفه‌ای', 'ps' => 'سیمه‌ییز درک، مسلکي انجینري'],
                summary: ['en' => 'A Kabul-based software company building maintainable ERP, financial, web and mobile systems around real business workflows.', 'fa' => 'یک شرکت نرم‌افزاری مستقر در کابل که سیستم‌های قابل توسعه ERP، مالی، وب و موبایل را مطابق روند واقعی تجارت می‌سازد.', 'ps' => 'په کابل کې د سافټویر شرکت چې د واقعي سوداګریزو بهیرونو مطابق د ودې وړ ERP، مالي، وېب او موبایل سیسټمونه جوړوي.'],
                body: [
                    'en' => '<h2>We begin with the operation, not the feature list</h2><p>Fida Technologies works with organizations that need clearer control, connected records and software designed around how their teams actually work. Discovery comes before architecture so the product solves the right operational problem.</p><h2>What guides our work</h2><ul><li>Business rules should be explicit and testable</li><li>Permissions, approvals and activity history should protect accountability</li><li>Reports should support decisions, not only display data</li><li>English, Dari and Pashto experiences should be usable from the initial design</li><li>Software should remain maintainable as the organization grows</li></ul><h2>From first discussion to continued improvement</h2><p>Our process covers workflow discovery, solution design, development, testing, deployment, training and improvement. The exact stages and responsibilities are documented in each approved project scope.</p>',
                    'fa' => '<h2>کار را از عملیات آغاز می‌کنیم، نه از فهرست امکانات</h2><p>Fida Technologies با سازمان‌هایی کار می‌کند که به کنترول روشن، معلومات یکپارچه و نرم‌افزار مطابق روش واقعی کار تیم خود نیاز دارند. پیش از معماری، روند را بررسی می‌کنیم تا محصول مشکل درست را حل کند.</p><h2>اصول کاری ما</h2><ul><li>قوانین تجارتی باید روشن و قابل آزمایش باشد</li><li>صلاحیت‌ها، تأییدی‌ها و تاریخچه فعالیت باید پاسخگویی را حفظ کند</li><li>گزارش‌ها باید از تصمیم‌گیری پشتیبانی کند</li><li>تجربه انگلیسی، دری و پشتو باید از آغاز قابل استفاده باشد</li><li>نرم‌افزار باید همراه سازمان قابل توسعه بماند</li></ul><h2>از گفتگو تا بهبود دوامدار</h2><p>روند ما شناخت کار، طراحی راهکار، توسعه، آزمایش، نصب، آموزش و بهبود را پوشش می‌دهد. مراحل و مسئولیت‌های دقیق در محدوده تأییدشده هر پروژه ثبت می‌شود.</p>',
                    'ps' => '<h2>کار له عملیاتو پیلوو، نه د امکاناتو له لسته</h2><p>Fida Technologies له هغو ادارو سره کار کوي چې روښانه کنټرول، یوځای معلومات او د ټیم د واقعي کار مطابق سافټویر غواړي. تر معمارۍ مخکې بهیر څېړو څو محصول سمه عملیاتي ستونزه حل کړي.</p><h2>زموږ کاري اصول</h2><ul><li>سوداګریز اصول باید روښانه او د ازموینې وړ وي</li><li>صلاحیتونه، تاییدونه او د فعالیت تاریخ باید حساب ورکونه خوندي کړي</li><li>راپورونه باید د پرېکړو ملاتړ وکړي</li><li>انګلیسي، دري او پښتو تجربه باید له لومړي ډیزاین څخه د کار وړ وي</li><li>سافټویر باید د ادارې له ودې سره د پراختیا وړ پاتې شي</li></ul><h2>له لومړۍ خبرې تر دوامداره ښه‌والي</h2><p>زموږ بهیر د کار پېژندنه، ډیزاین، جوړول، ازموینه، نصب، روزنه او ښه‌والی رانغاړي. دقیق پړاوونه او مسؤلیتونه د هرې پروژې په تایید شوو حدودو کې لیکل کېږي.</p>',
                ],
                metaTitle: ['en' => 'About Fida Technologies | Software Company Afghanistan', 'fa' => 'درباره Fida Technologies | شرکت نرم‌افزاری افغانستان', 'ps' => 'د Fida Technologies په اړه | د افغانستان سافټویر شرکت'],
                metaDescription: ['en' => 'Learn how Fida Technologies approaches ERP, financial, web and mobile software projects from discovery through deployment and improvement.', 'fa' => 'روش کاری Fida Technologies برای پروژه‌های ERP، مالی، وب و موبایل از شناخت تا نصب و بهبود.', 'ps' => 'د ERP، مالي، وېب او موبایل پروژو لپاره د Fida Technologies کاري لاره له پېژندنې تر نصب او ښه‌والي.'],
                faqs: [
                    $this->faq('Where is Fida Technologies based?', 'Fida Technologies is based in Kabul, Afghanistan.'),
                    $this->faq('Which languages does Fida Technologies work in?', 'The company works in English, Dari and Pashto and can design multilingual, right-to-left software experiences where required.'),
                    $this->faq('How does a software project begin?', 'A project begins with workflow discovery to identify users, decisions, permissions, reports, integrations and the practical outcome the organization needs.'),
                ],
                type: 'page',
                sortOrder: 1,
            ),
            $this->page(
                slug: 'services',
                title: ['en' => 'Software & Technology Services', 'fa' => 'خدمات نرم‌افزار و تکنالوژی', 'ps' => 'د سافټویر او ټکنالوژۍ خدمتونه'],
                eyebrow: ['en' => 'From focused workflow to connected platform', 'fa' => 'از روند مشخص تا پلتفرم یکپارچه', 'ps' => 'له ځانګړي بهیر تر یوځای پلېټفارم'],
                summary: ['en' => 'ERP, accounting, custom software and mobile development services designed around operational requirements, users and growth plans.', 'fa' => 'خدمات ERP، حسابداری، نرم‌افزار اختصاصی و موبایل مطابق نیازهای عملیاتی، کاربران و پلان رشد.', 'ps' => 'د عملیاتي اړتیاوو، کاروونکو او ودې پلان مطابق ERP، حسابداري، ځانګړی سافټویر او موبایل خدمتونه.'],
                body: [
                    'en' => '<h2>Choose the result before choosing the technology</h2><p>A successful engagement begins by defining the workflow that must improve, the people responsible for it and the decisions the system must support. The technical stack follows those requirements.</p><h2>Implementation services</h2><ul><li>Workflow analysis and product scoping</li><li>Interface, data and permission architecture</li><li>Development, testing and controlled releases</li><li>Data preparation and migration after source review</li><li>Deployment, user training and documented handover</li><li>Support and separately approved improvement work</li></ul>',
                    'fa' => '<h2>پیش از انتخاب تکنالوژی، نتیجه را مشخص کنید</h2><p>یک همکاری موفق با تعیین روندی آغاز می‌شود که باید بهتر شود، افرادی که مسئول آن است و تصمیم‌هایی که سیستم باید پشتیبانی کند. تکنالوژی بر اساس همین نیازها انتخاب می‌شود.</p><h2>خدمات تطبیق</h2><ul><li>تحلیل روند و تعیین محدوده محصول</li><li>معماری رابط، معلومات و صلاحیت‌ها</li><li>توسعه، آزمایش و نشر کنترول‌شده</li><li>آماده‌سازی و انتقال معلومات پس از بررسی منبع</li><li>نصب، آموزش و تحویل مستند</li><li>پشتیبانی و بهبودهای جداگانه تأییدشده</li></ul>',
                    'ps' => '<h2>تر ټکنالوژۍ مخکې پایله وټاکئ</h2><p>بریالۍ همکاري د هغه کاري بهیر په ټاکلو پیلېږي چې باید ښه شي، مسؤل خلک او هغه پرېکړې چې سیسټم یې باید ملاتړ وکړي. تخنیکي جوړښت د همدې اړتیاوو مطابق ټاکل کېږي.</p><h2>د پلي کولو خدمتونه</h2><ul><li>د کاري بهیر تحلیل او د محصول حدود</li><li>د انترفېس، معلوماتو او صلاحیتونو معماري</li><li>جوړول، ازموینه او کنټرول شوې خپرونې</li><li>د سرچینې له کتنې وروسته د معلوماتو چمتو کول او لېږد</li><li>نصب، روزنه او مستند سپارل</li><li>ملاتړ او جلا تایید شوي ښه‌والي</li></ul>',
                ],
                metaTitle: ['en' => 'Software Development Services Afghanistan | Fida', 'fa' => 'خدمات توسعه نرم‌افزار افغانستان | Fida', 'ps' => 'په افغانستان کې د سافټویر خدمتونه | Fida'],
                metaDescription: ['en' => 'Explore ERP, accounting, custom software and mobile application services from Fida Technologies in Afghanistan.', 'fa' => 'خدمات ERP، حسابداری، نرم‌افزار اختصاصی و اپلیکیشن موبایل Fida Technologies در افغانستان.', 'ps' => 'په افغانستان کې د Fida Technologies د ERP، حسابدارۍ، ځانګړي سافټویر او موبایل خدمتونه.'],
                faqs: [
                    $this->faq('Which service should a business choose first?', 'Begin with the operational problem rather than a product label. Fida can assess the workflow and determine whether a focused application, an integration or a broader ERP implementation is appropriate.'),
                    $this->faq('Can Fida improve an existing system?', 'Existing software can be reviewed for maintainability, security, data quality and integration options before any improvement scope is proposed.'),
                    $this->faq('Are training and deployment included?', 'Training and deployment can be included, but the exact environments, user groups, responsibilities and support period must be stated in the approved quotation.'),
                ],
                type: 'page',
                sortOrder: 2,
            ),
            $this->page(
                slug: 'projects',
                title: ['en' => 'Products & Projects', 'fa' => 'محصولات و پروژه‌ها', 'ps' => 'محصولات او پروژې'],
                eyebrow: ['en' => 'Systems shaped by real operating domains', 'fa' => 'سیستم‌های مطابق حوزه‌های واقعی کاری', 'ps' => 'د واقعي کاري برخو مطابق سیسټمونه'],
                summary: ['en' => 'Explore Fida product platforms for real estate, sarafi, pharmaceutical operations and mobile account management.', 'fa' => 'پلتفرم‌های محصول فیدا برای املاک، صرافی، عملیات دارویی و مدیریت حساب موبایل را ببینید.', 'ps' => 'د املاکو، صرافۍ، درملو عملیاتو او موبایل حساب مدیریت لپاره د فیدا محصولي پلېټفارمونه وګورئ.'],
                body: [
                    'en' => '<h2>Product profiles, separated from client evidence</h2><p>The systems on this page have dedicated profiles describing their confirmed purpose, architecture direction and operational capabilities. Client names, screenshots and measurable results belong in separate case studies and are published only after verification and approval.</p><h2>How to evaluate a platform</h2><ul><li>Compare the workflow with your own operation</li><li>Confirm which modules are currently available</li><li>Identify required integrations, data migration and localization</li><li>Request a written scope, implementation plan and commercial offer</li></ul>',
                    'fa' => '<h2>پروفایل محصول، جدا از شواهد مشتری</h2><p>سیستم‌های این صفحه پروفایل مستقل دارد که هدف تأییدشده، جهت معماری و توانایی‌های عملیاتی را توضیح می‌دهد. نام مشتری، تصاویر و نتایج قابل اندازه‌گیری تنها پس از تأیید و اجازه در مطالعه موردی جداگانه نشر می‌شود.</p><h2>چگونه یک پلتفرم را ارزیابی کنید</h2><ul><li>روند آن را با عملیات خود مقایسه کنید</li><li>ماژول‌های موجود را تأیید کنید</li><li>یکپارچه‌سازی، انتقال معلومات و زبان‌ها را مشخص کنید</li><li>محدوده کتبی، پلان تطبیق و پیشنهاد تجارتی بخواهید</li></ul>',
                    'ps' => '<h2>د محصول پېژندپاڼه له مشتری شواهدو جلا ده</h2><p>د دې پاڼې سیسټمونه ځانګړې پېژندپاڼې لري چې تایید شوی هدف، معماري او عملیاتي وړتیاوې بیانوي. د مشتری نومونه، انځورونه او اندازه کېدونکې پایلې یوازې له تایید او اجازې وروسته په جلا قضیوي مطالعو کې خپرېږي.</p><h2>پلېټفارم څنګه وارزوئ</h2><ul><li>کاري بهیر له خپلو عملیاتو سره پرتله کړئ</li><li>اوسني ماډیولونه تایید کړئ</li><li>ادغامونه، د معلوماتو لېږد او ژبې وټاکئ</li><li>لیکل شوي حدود، د پلي کولو پلان او سوداګریز وړاندیز وغواړئ</li></ul>',
                ],
                metaTitle: ['en' => 'Software Products & ERP Projects | Fida Technologies', 'fa' => 'محصولات نرم‌افزار و پروژه‌های ERP | Fida Technologies', 'ps' => 'د سافټویر محصولات او ERP پروژې | Fida Technologies'],
                metaDescription: ['en' => 'Explore Realist ERP, Prime Sarafi, Darmal ERP and OGRAYI product profiles from Fida Technologies.', 'fa' => 'پروفایل محصولات Realist ERP، Prime Sarafi، Darmal ERP و OGRAYI از Fida Technologies.', 'ps' => 'د Fida Technologies د Realist ERP، Prime Sarafi، Darmal ERP او OGRAYI محصول پېژندپاڼې.'],
                faqs: [
                    $this->faq('Are all listed products commercially available?', 'Availability differs by product. Each profile states the current direction or development status, and the final available scope must be confirmed before commitment.'),
                    $this->faq('Can a Fida product be customized?', 'Configuration and approved custom development may be possible depending on the product architecture and requested workflow. The exact scope requires technical review.'),
                    $this->faq('Where are client case studies?', 'Case studies are maintained as private drafts until client permission, implementation facts, approved screenshots and measurable evidence are available.'),
                ],
                type: 'page',
                sortOrder: 3,
            ),
            $this->page(
                slug: 'pricing',
                title: ['en' => 'Project Pricing', 'fa' => 'قیمت‌گذاری پروژه', 'ps' => 'د پروژې بیه'],
                eyebrow: ['en' => 'Transparent scope before price', 'fa' => 'محدوده روشن پیش از قیمت', 'ps' => 'تر بیې مخکې روښانه حدود'],
                summary: ['en' => 'Receive a written quotation based on the users, workflows, integrations, data, deployment and support your project actually requires.', 'fa' => 'پیشنهاد کتبی را بر اساس کاربران، روندها، یکپارچه‌سازی، معلومات، نصب و پشتیبانی مورد نیاز پروژه دریافت کنید.', 'ps' => 'د کاروونکو، بهیرونو، ادغامونو، معلوماتو، نصب او ملاتړ مطابق لیکلی نرخ ترلاسه کړئ.'],
                body: [
                    'en' => '<h2>Why one fixed price would be misleading</h2><p>A public website, a focused workflow application and a multi-department ERP have different responsibilities and implementation risks. Even projects with the same name can differ in users, approvals, reports, integrations and migration work.</p><h2>What a quotation should make clear</h2><ul><li>Included modules, roles, reports and languages</li><li>Delivery stages and acceptance responsibilities</li><li>Data migration and third-party integration assumptions</li><li>Hosting, domain, deployment and backup responsibilities</li><li>Training, warranty, support and future modification terms</li></ul><p>Fida Technologies provides a commercial offer after enough discovery to define these items. A quotation is not a commitment until both parties approve the written scope and terms.</p>',
                    'fa' => '<h2>چرا یک قیمت ثابت می‌تواند گمراه‌کننده باشد</h2><p>وب‌سایت عمومی، اپلیکیشن یک روند مشخص و ERP چندبخشی مسئولیت‌ها و خطرهای تطبیق متفاوت دارد. حتی پروژه‌های هم‌نام می‌تواند در کاربران، تأییدی‌ها، گزارش‌ها، یکپارچه‌سازی و انتقال معلومات فرق کند.</p><h2>پیشنهاد قیمت چه چیزهایی را باید روشن سازد</h2><ul><li>ماژول‌ها، نقش‌ها، گزارش‌ها و زبان‌های شامل</li><li>مراحل تحویل و مسئولیت پذیرش</li><li>فرضیات انتقال معلومات و یکپارچه‌سازی بیرونی</li><li>مسئولیت میزبانی، دامنه، نصب و نسخه پشتیبان</li><li>آموزش، تضمین، پشتیبانی و شرایط تغییرات آینده</li></ul><p>Fida Technologies پس از شناخت کافی این موارد، پیشنهاد تجارتی ارائه می‌کند. قیمت تا تأیید کتبی محدوده و شرایط توسط دو طرف، تعهد نهایی نیست.</p>',
                    'ps' => '<h2>ولې یوه ثابته بیه سمه انځور نه ورکوي</h2><p>عامه وېب‌سایټ، د یوه بهیر اپلېکېشن او څو څانګو ERP جلا مسؤلیتونه او د پلي کولو خطرونه لري. حتی هم‌نومې پروژې د کاروونکو، تاییدونو، راپورونو، ادغامونو او معلوماتو لېږد کې توپیر لري.</p><h2>نرخ باید څه روښانه کړي</h2><ul><li>شامل ماډیولونه، رولونه، راپورونه او ژبې</li><li>د سپارلو پړاوونه او د منلو مسؤلیتونه</li><li>د معلوماتو لېږد او بهرنیو ادغامونو فرضیات</li><li>د کوربه‌توب، ډومېن، نصب او بیک‌اپ مسؤلیت</li><li>روزنه، تضمین، ملاتړ او راتلونکو بدلونونو شرایط</li></ul><p>Fida Technologies له کافي پېژندنې وروسته سوداګریز وړاندیز ورکوي. تر هغه چې دواړه خواوې لیکلي حدود او شرایط تایید نه کړي، نرخ وروستۍ ژمنه نه ده.</p>',
                ],
                metaTitle: ['en' => 'Software & ERP Project Pricing | Fida Technologies', 'fa' => 'قیمت پروژه نرم‌افزار و ERP | Fida Technologies', 'ps' => 'د سافټویر او ERP پروژې بیه | Fida Technologies'],
                metaDescription: ['en' => 'Understand how Fida Technologies prepares written quotations for websites, business software, ERP systems and digital products.', 'fa' => 'روش تهیه پیشنهاد کتبی Fida Technologies برای وب‌سایت، نرم‌افزار تجارتی، ERP و محصول دیجیتال.', 'ps' => 'Fida Technologies د وېب‌سایټ، سوداګریز سافټویر، ERP او ډیجیټل محصول لپاره لیکلی نرخ څنګه برابروي.'],
                faqs: [
                    $this->faq('Does Fida publish one fixed price for every project?', 'No. A reliable quotation depends on the approved scope, users, workflows, integrations, migration, deployment and support requirements.'),
                    $this->faq('How is a software quotation prepared?', 'Fida first reviews the required workflow and responsibilities, then documents the included scope, delivery stages, commercial terms and exclusions.'),
                    $this->faq('Are hosting and future modifications included?', 'The quotation must explicitly state hosting and support terms. New modifications outside the approved scope are estimated and approved separately.'),
                ],
                type: 'page',
                sortOrder: 4,
            ),
            $this->page(
                slug: 'contact',
                title: ['en' => 'Contact Fida Technologies', 'fa' => 'تماس با Fida Technologies', 'ps' => 'له Fida Technologies سره اړیکه'],
                eyebrow: ['en' => 'Start with the workflow', 'fa' => 'گفتگو را از روند کاری آغاز کنید', 'ps' => 'خبرې له کاري بهیر څخه پیل کړئ'],
                summary: ['en' => 'Describe the business problem, current process and desired result so the Fida team can recommend a practical next step.', 'fa' => 'مشکل تجارتی، روند فعلی و نتیجه مورد نظر را توضیح دهید تا تیم فیدا قدم عملی بعدی را پیشنهاد کند.', 'ps' => 'سوداګریزه ستونزه، اوسنی بهیر او غوښتل شوې پایله بیان کړئ څو د فیدا ټیم عملي بل ګام وړاندیز کړي.'],
                body: [
                    'en' => '<h2>Useful information for the first review</h2><p>Share the organization type, current workflow, main users, important reports, existing software or spreadsheets, required languages and preferred timeline. Do not send passwords or confidential production data through the public form.</p>',
                    'fa' => '<h2>معلومات مفید برای بررسی نخست</h2><p>نوع سازمان، روند فعلی، کاربران اصلی، گزارش‌های مهم، نرم‌افزار یا فایل‌های موجود، زبان‌های مورد نیاز و زمان ترجیحی را شریک سازید. رمز عبور یا معلومات محرمانه اصلی را از فورم عمومی ارسال نکنید.</p>',
                    'ps' => '<h2>د لومړۍ کتنې لپاره ګټور معلومات</h2><p>د ادارې ډول، اوسنی بهیر، اصلي کاروونکي، مهم راپورونه، موجود سافټویر یا فایلونه، اړینې ژبې او غوره وخت شریک کړئ. پاسورډونه یا محرم اصلي معلومات د عامه فورم له لارې مه لېږئ.</p>',
                ],
                metaTitle: ['en' => 'Contact Fida Technologies | Software Consultation', 'fa' => 'تماس با Fida Technologies | مشوره نرم‌افزار', 'ps' => 'له Fida Technologies سره اړیکه | د سافټویر مشوره'],
                metaDescription: ['en' => 'Contact Fida Technologies in Kabul to discuss an ERP, accounting, custom software, mobile application or professional website project.', 'fa' => 'برای گفتگو درباره ERP، حسابداری، نرم‌افزار اختصاصی، اپ موبایل یا وب‌سایت حرفه‌ای با Fida Technologies تماس بگیرید.', 'ps' => 'د ERP، حسابدارۍ، ځانګړي سافټویر، موبایل اپ یا مسلکي وېب‌سایټ لپاره له Fida Technologies سره اړیکه ونیسئ.'],
                faqs: [
                    $this->faq('What information should be included in the first message?', 'Describe the organization, current workflow, users, main problem, required reports or integrations and the result you want. Do not send passwords or confidential production data.'),
                    $this->faq('Can the first consultation be in Dari or Pashto?', 'Yes. Fida Technologies works in English, Dari and Pashto.'),
                    $this->faq('Does sending the form create a project commitment?', 'No. The form starts a discussion. A project begins only after the parties approve the written scope, responsibilities and commercial terms.'),
                ],
                type: 'page',
                sortOrder: 5,
            ),
            $this->product(
                slug: 'realist-real-estate-erp',
                title: ['en' => 'Realist ERP for Real Estate & Construction', 'fa' => 'Realist ERP برای املاک و ساختمان', 'ps' => 'د املاکو او ساختمان لپاره Realist ERP'],
                eyebrow: ['en' => 'Property operations, connected', 'fa' => 'عملیات یکپارچه املاک', 'ps' => 'یوځای د املاکو عملیات'],
                summary: [
                    'en' => 'Connect property inventory, sales, contracts, customer payments, construction workflows and accounting in one controlled real estate ERP.',
                    'fa' => 'موجودی ملکیت، فروش، قراردادها، پرداخت مشتری، روند ساختمان و حسابداری را در یک ERP املاک یکجا سازید.',
                    'ps' => 'د ملکیتونو لست، پلور، قراردادونه، د پېرودونکو تادیات، ساختماني بهیر او حسابداري په یوه ERP کې یوځای کړئ.',
                ],
                body: [
                    'en' => '<h2>One operating system from property inventory to finance</h2><p>Realist ERP is designed for property developers and construction businesses that need every unit, customer agreement, payment and approval connected to a reliable financial record.</p><h2>Property sales and customer operations</h2><ul><li>Projects, buildings, floors, units and availability status</li><li>Reservations, contracts, negotiated prices and milestone schedules</li><li>Customer payments, discounts, refunds and controlled sales returns</li><li>Customer statements in transaction and reporting currencies</li><li>Approvals, activity history and management dashboards</li></ul><h2>Construction and financial control</h2><p>The platform can connect construction phases, subcontractor assignments, material requests, purchasing, inventory receipts and site issues with international-standard accounting and decision-ready reports.</p><h2>Configured around the project</h2><p>Implementation begins with the company structure, sales policy, approval chain, currencies and reporting requirements. Modules are configured to the actual development workflow instead of forcing a generic template.</p>',
                    'fa' => '<h2>یک سیستم از موجودی ملکیت تا امور مالی</h2><p>Realist ERP برای شرکت‌های ساختمانی و توسعه‌دهندگان املاک طراحی شده است تا هر واحد، قرارداد مشتری، پرداخت و تأییدی با ثبت دقیق مالی مرتبط باشد.</p><h2>فروش ملکیت و عملیات مشتری</h2><ul><li>پروژه، تعمیر، منزل، واحد و وضعیت موجودی</li><li>رزرو، قرارداد، قیمت توافقی و اقساط مرحله‌ای</li><li>پرداخت، تخفیف، بازپرداخت و برگشت کنترول‌شده فروش</li><li>صورت‌حساب مشتری و تأییدی‌های مدیریتی</li></ul><h2>کنترول ساختمان و مالی</h2><p>سیستم می‌تواند مراحل ساختمان، قراردادی‌ها، درخواست مواد، خرید، ورود گدام و مصرف ساحه را با حسابداری معیاری و گزارش‌های مدیریتی مرتبط سازد.</p>',
                    'ps' => '<h2>له ملکیتونو تر مالي چارو یو سیسټم</h2><p>Realist ERP د املاکو پراختیاکوونکو او ساختماني شرکتونو لپاره جوړ شوی، څو هر واحد، قرارداد، تادیه او تایید له کره مالي ثبت سره وتړل شي.</p><h2>د ملکیت پلور او پیرودونکي</h2><ul><li>پروژې، ودانۍ، پوړونه، واحدونه او موجود حالت</li><li>ریزرف، قراردادونه، توافق شوې بیې او قسطونه</li><li>تادیات، تخفیفونه، بېرته ورکړه او د پلور کنټرول شوې راستنېدنه</li><li>د پیرودونکي حساب‌لیک او مدیریتي تاییدونه</li></ul><h2>ساختماني او مالي کنټرول</h2><p>سیسټم ساختماني پړاوونه، قراردادیان، د موادو غوښتنې، پېرود، ګدام او ساحې مصرف له معیاري حسابدارۍ او راپورونو سره نښلوي.</p>',
                ],
                metaTitle: ['en' => 'Real Estate ERP Software | Realist ERP Afghanistan', 'fa' => 'نرم‌افزار ERP املاک | Realist ERP افغانستان', 'ps' => 'د املاکو ERP سافټویر | Realist ERP افغانستان'],
                metaDescription: ['en' => 'Realist ERP connects property inventory, sales, contracts, installment payments, construction workflows and accounting for real estate businesses.', 'fa' => 'Realist ERP برای موجودی املاک، فروش، قرارداد، اقساط، روند ساختمان و حسابداری شرکت‌های املاک.', 'ps' => 'Realist ERP د ملکیتونو، پلور، قراردادونو، قسطونو، ساختماني بهیر او حسابدارۍ لپاره.'],
                profile: [
                    'code' => 'REALIST', 'accent' => '#6f6bff',
                    'category' => ['en' => 'Real estate & construction ERP', 'fa' => 'ERP املاک و ساختمان', 'ps' => 'د املاکو او ساختمان ERP'],
                    'platform' => ['en' => 'Responsive web platform', 'fa' => 'پلتفرم واکنش‌گرای وب', 'ps' => 'غبرګون‌کوونکی وېب پلېټفارم'],
                    'deployment' => ['en' => 'Cloud or private server', 'fa' => 'کلود یا سرور خصوصی', 'ps' => 'کلاوډ یا شخصي سرور'],
                    'status' => ['en' => 'Project-based implementation', 'fa' => 'تطبیق مطابق پروژه', 'ps' => 'د پروژې مطابق پلي کول'],
                    'features' => [
                        ['en' => 'Property inventory', 'fa' => 'موجودی ملکیت', 'ps' => 'د ملکیتونو لست'],
                        ['en' => 'Contracts & installments', 'fa' => 'قرارداد و اقساط', 'ps' => 'قراردادونه او قسطونه'],
                        ['en' => 'Customer statements', 'fa' => 'صورت‌حساب مشتری', 'ps' => 'د پیرودونکي حساب‌لیک'],
                        ['en' => 'Construction workflow', 'fa' => 'روند ساختمان', 'ps' => 'ساختماني بهیر'],
                        ['en' => 'Accounting', 'fa' => 'حسابداری', 'ps' => 'حسابداري'],
                        ['en' => 'Approvals & reports', 'fa' => 'تأییدی و گزارش', 'ps' => 'تاییدونه او راپورونه'],
                    ],
                ],
                faqs: [
                    $this->faq('What does Realist ERP manage?', 'Realist ERP connects property inventory, sales, contracts, installment schedules, customer payments, construction operations and accounting in one controlled platform.'),
                    $this->faq('Can Realist ERP support more than one building or project?', 'The platform can be configured for multi-project and multi-building operations, or simplified for a company managing one development.'),
                    $this->faq('Does Realist ERP include accounting?', 'Yes. The implementation can include connected journals, customer accounts, expenses, assets, liabilities and financial statements based on the approved accounting structure.'),
                ],
            ),
            $this->product(
                slug: 'prime-sarafi-software',
                title: ['en' => 'Prime Sarafi & Remittance Management Software', 'fa' => 'نرم‌افزار مدیریت صرافی و حواله Prime', 'ps' => 'د Prime صرافۍ او حوالو مدیریت سافټویر'],
                eyebrow: ['en' => 'Controlled multi-currency operations', 'fa' => 'عملیات کنترول‌شده چندارزی', 'ps' => 'کنټرول شوي څو اسعارو عملیات'],
                summary: ['en' => 'Manage currency exchange, remittances, customer accounts, cash positions, approvals and multi-currency accounting through one professional platform.', 'fa' => 'تبادله اسعار، حواله، حساب مشتری، موجودی نقد، تأییدی و حسابداری چندارزی را در یک پلتفرم مدیریت کنید.', 'ps' => 'د اسعارو تبادله، حوالې، د پیرودونکو حسابونه، نغدي حالت، تاییدونه او څو اسعارو حسابداري په یوه پلېټفارم کې مدیریت کړئ.'],
                body: [
                    'en' => '<h2>Built for the operating reality of a sarafi</h2><p>Prime Sarafi is designed for exchange and remittance businesses that need accurate customer balances, traceable transactions, controlled approvals and clear currency positions.</p><h2>Exchange, remittance and customer accounts</h2><ul><li>Currency exchange across configured currency pairs</li><li>Outgoing and incoming remittance workflows</li><li>Customer, saraf, cash and partner accounts</li><li>Credit, debit and per-currency running balances</li><li>Receipts, transaction references and WhatsApp-ready communication</li></ul><h2>Financial control and auditability</h2><p>Linked journal entries, roles, permissions, approval states and activity records make each operation easier to review. Reports can cover cash, bank, customer, creditor, debtor and profit-and-loss positions by currency.</p><h2>Configured for each business model</h2><p>Currency pairs, rate rules, commission handling, branches, approval roles and reporting requirements are defined during implementation.</p>',
                    'fa' => '<h2>ساخته‌شده برای عملیات واقعی صرافی</h2><p>Prime Sarafi برای صرافی‌ها و شرکت‌های حواله طراحی شده است که به بیلانس دقیق مشتری، معاملات قابل پیگیری، تأییدی کنترول‌شده و وضعیت روشن اسعار نیاز دارند.</p><h2>تبادله، حواله و حساب مشتری</h2><ul><li>تبادله میان جفت‌های اسعار تعیین‌شده</li><li>روند حواله صادره و وارده</li><li>حساب مشتری، صراف، نقدی و شریک</li><li>کردیت، دبیت و بیلانس جاری هر ارز</li><li>رسید، مرجع معامله و ارتباط واتساپ</li></ul><h2>کنترول مالی و قابلیت بررسی</h2><p>ثبت‌های مرتبط ژورنال، نقش‌ها، صلاحیت‌ها، تأییدی‌ها و تاریخچه فعالیت، بررسی هر عملیات را روشن می‌سازد.</p>',
                    'ps' => '<h2>د صرافۍ د واقعي عملیاتو لپاره جوړ شوی</h2><p>Prime Sarafi د صرافیو او حوالو شرکتونو لپاره دی چې کره د پیرودونکو بیلانس، د تعقیب وړ معاملې، کنټرول شوي تاییدونه او د اسعارو روښانه حالت غواړي.</p><h2>تبادله، حوالې او د پیرودونکو حسابونه</h2><ul><li>د ټاکل شوو اسعارو ترمنځ تبادله</li><li>وتونکې او راتلونکې حوالې</li><li>د پیرودونکي، صراف، نغدي او شریک حسابونه</li><li>کریډیټ، ډیبیټ او د هر اسعار روان بیلانس</li><li>رسیدونه، د معاملې مرجع او واټس‌اپ اړیکه</li></ul><h2>مالي کنټرول او څارنه</h2><p>تړلي ژورنال ثبتونه، رولونه، صلاحیتونه، تاییدونه او د فعالیت تاریخ د هر عملیاتو کتنه روښانه کوي.</p>',
                ],
                metaTitle: ['en' => 'Sarafi & Remittance Software Afghanistan | Prime', 'fa' => 'نرم‌افزار صرافی و حواله افغانستان | Prime', 'ps' => 'د صرافۍ او حوالو سافټویر افغانستان | Prime'],
                metaDescription: ['en' => 'Prime Sarafi software for currency exchange, remittances, customer balances, approvals and multi-currency accounting in Afghanistan.', 'fa' => 'نرم‌افزار Prime برای تبادله اسعار، حواله، بیلانس مشتری، تأییدی و حسابداری چندارزی در افغانستان.', 'ps' => 'Prime د اسعارو تبادلې، حوالو، پیرودونکو بیلانس، تاییدونو او څو اسعارو حسابدارۍ لپاره.'],
                profile: [
                    'code' => 'PRIME', 'accent' => '#16c7a3',
                    'category' => ['en' => 'Sarafi & remittance platform', 'fa' => 'پلتفرم صرافی و حواله', 'ps' => 'د صرافۍ او حوالو پلېټفارم'],
                    'platform' => ['en' => 'Secure web platform', 'fa' => 'پلتفرم امن وب', 'ps' => 'خوندي وېب پلېټفارم'],
                    'deployment' => ['en' => 'Cloud or private server', 'fa' => 'کلود یا سرور خصوصی', 'ps' => 'کلاوډ یا شخصي سرور'],
                    'status' => ['en' => 'Sarafi-specific implementation', 'fa' => 'تطبیق مطابق صرافی', 'ps' => 'د صرافۍ مطابق پلي کول'],
                    'features' => [
                        ['en' => 'Currency exchange', 'fa' => 'تبادله اسعار', 'ps' => 'د اسعارو تبادله'],
                        ['en' => 'Remittances', 'fa' => 'حواله', 'ps' => 'حوالې'],
                        ['en' => 'Customer accounts', 'fa' => 'حساب مشتری', 'ps' => 'د پیرودونکو حسابونه'],
                        ['en' => 'Multi-currency ledger', 'fa' => 'دفتر چندارزی', 'ps' => 'څو اسعارو لیجر'],
                        ['en' => 'Approvals', 'fa' => 'تأییدی‌ها', 'ps' => 'تاییدونه'],
                        ['en' => 'Financial reports', 'fa' => 'گزارش‌های مالی', 'ps' => 'مالي راپورونه'],
                    ],
                ],
                faqs: [
                    $this->faq('Which operations can Prime Sarafi manage?', 'Prime can manage configured currency exchange, incoming and outgoing remittances, customer accounts, cash and bank positions, approvals, receipts and financial reporting.'),
                    $this->faq('Does Prime keep balances separately for each currency?', 'Yes. Transactions and running balances can be maintained by currency while management reports use configured conversion rules where required.'),
                    $this->faq('Can roles and approvals be configured?', 'Yes. Access, approval steps and visible operations can be configured for owners, managers, cashiers and other authorized roles.'),
                ],
            ),
            $this->product(
                slug: 'darmal-pharmacy-erp',
                title: ['en' => 'Darmal Pharmacy & Pharmaceutical ERP', 'fa' => 'Darmal ERP برای دواخانه و شرکت دارویی', 'ps' => 'د درملتون او درملو شرکت لپاره Darmal ERP'],
                eyebrow: ['en' => 'Expiry-aware medicine operations', 'fa' => 'عملیات دوا با کنترول تاریخ انقضا', 'ps' => 'د ختمېدو نېټې له کنټرول سره د درملو عملیات'],
                summary: ['en' => 'An actively developed ERP for pharmacy retail, medicine wholesale and pharmaceutical operations from purchasing to expiry-aware inventory and finance.', 'fa' => 'ERP در حال توسعه برای پرچون دواخانه، فروش عمده دوا و عملیات شرکت دارویی از خرید تا گدام و امور مالی.', 'ps' => 'د درملتون پرچون، درملو عمده پلور او درملو شرکت عملیاتو لپاره د پراختیا په حال ERP.'],
                body: [
                    'en' => '<h2>Medicine inventory needs more than a generic stock system</h2><p>Darmal ERP is under active product development for pharmacies and pharmaceutical businesses that need batch-aware purchasing, controlled stock movement, expiry visibility and connected accounting.</p><h2>Planned operational foundation</h2><ul><li>Medicine catalogue, units, categories and supplier records</li><li>Purchasing, receiving and supplier balances</li><li>Batch, expiry and stock-level visibility</li><li>Wholesale and retail sales workflows</li><li>Returns, damaged stock and controlled adjustments</li><li>Customer, doctor and pharmacy relationship records where required</li></ul><h2>Finance connected to inventory</h2><p>The product architecture connects purchases, sales, payments, receivables, payables and expenses with accounting records and management reports.</p><h2>Development status</h2><p>Darmal remains in active development. Final module availability and implementation scope must be confirmed during consultation before any commercial commitment.</p>',
                    'fa' => '<h2>موجودی دوا به یک سیستم عادی گدام محدود نمی‌شود</h2><p>Darmal ERP برای دواخانه‌ها و شرکت‌های دارویی در حال توسعه است تا خرید بر اساس بچ، حرکت کنترول‌شده موجودی، دید تاریخ انقضا و حسابداری مرتبط را مدیریت کند.</p><h2>بنیاد عملیاتی در حال توسعه</h2><ul><li>فهرست دوا، واحد، کتگوری و عرضه‌کننده</li><li>خرید، دریافت و بیلانس عرضه‌کننده</li><li>بچ، تاریخ انقضا و سطح موجودی</li><li>فروش عمده و پرچون</li><li>برگشت، موجودی آسیب‌دیده و تعدیلات</li></ul><h2>وضعیت توسعه</h2><p>Darmal در حال توسعه فعال است. موجودیت نهایی ماژول‌ها و محدوده تطبیق پیش از قرارداد تأیید می‌شود.</p>',
                    'ps' => '<h2>د درملو زېرمتون له عادي سټاک سیسټم څخه ډېر څه غواړي</h2><p>Darmal ERP د درملتونونو او درملو شرکتونو لپاره د پراختیا په حال کې دی، څو د بچ پېرود، کنټرول شوی سټاک، د ختمېدو نېټه او تړلې حسابداري اداره کړي.</p><h2>د پراختیا په حال عملیاتي بنسټ</h2><ul><li>د درملو لست، واحدونه، کټګورۍ او عرضه کوونکي</li><li>پېرود، ترلاسه کول او د عرضه کوونکي بیلانس</li><li>بچ، د ختمېدو نېټه او سټاک</li><li>عمده او پرچون پلور</li><li>راستنول، خراب سټاک او تعدیلات</li></ul><h2>د پراختیا حالت</h2><p>Darmal لا هم په فعاله پراختیا کې دی. وروستي ماډیولونه او د پلي کولو حدود له قرارداد مخکې تاییدېږي.</p>',
                ],
                metaTitle: ['en' => 'Pharmacy ERP Software Afghanistan | Darmal', 'fa' => 'نرم‌افزار ERP دواخانه افغانستان | Darmal', 'ps' => 'د درملتون ERP سافټویر افغانستان | Darmal'],
                metaDescription: ['en' => 'Darmal is an actively developed pharmacy and pharmaceutical ERP for purchasing, batch and expiry inventory, sales and connected finance.', 'fa' => 'Darmal ERP در حال توسعه برای خرید، موجودی بچ و انقضا، فروش و امور مالی دواخانه و شرکت دارویی.', 'ps' => 'Darmal د پېرود، بچ او ختمېدو سټاک، پلور او مالي چارو لپاره د پراختیا په حال ERP دی.'],
                profile: [
                    'code' => 'DARMAL', 'accent' => '#2c8cff',
                    'category' => ['en' => 'Pharmacy & pharmaceutical ERP', 'fa' => 'ERP دواخانه و شرکت دارویی', 'ps' => 'د درملتون او درملو شرکت ERP'],
                    'platform' => ['en' => 'Web platform architecture', 'fa' => 'معماری پلتفرم وب', 'ps' => 'د وېب پلېټفارم جوړښت'],
                    'deployment' => ['en' => 'Deployment model in development', 'fa' => 'مدل نصب در حال توسعه', 'ps' => 'د نصب موډل د پراختیا په حال کې'],
                    'status' => ['en' => 'Active product development', 'fa' => 'در حال توسعه فعال', 'ps' => 'فعاله پراختیا'],
                    'features' => [
                        ['en' => 'Medicine catalogue', 'fa' => 'فهرست دوا', 'ps' => 'د درملو لست'],
                        ['en' => 'Batch & expiry', 'fa' => 'بچ و انقضا', 'ps' => 'بچ او ختمېدو نېټه'],
                        ['en' => 'Purchasing', 'fa' => 'خرید', 'ps' => 'پېرود'],
                        ['en' => 'Wholesale & retail', 'fa' => 'عمده و پرچون', 'ps' => 'عمده او پرچون'],
                        ['en' => 'Inventory control', 'fa' => 'کنترول گدام', 'ps' => 'د سټاک کنټرول'],
                        ['en' => 'Connected finance', 'fa' => 'امور مالی مرتبط', 'ps' => 'تړلې مالي چارې'],
                    ],
                ],
                faqs: [
                    $this->faq('Is Darmal ERP already commercially available?', 'Darmal is in active product development. The final available modules, implementation date and commercial scope must be confirmed directly with Fida Technologies.'),
                    $this->faq('Is Darmal intended for both pharmacies and pharmaceutical companies?', 'The architecture is being designed for retail pharmacies, medicine wholesalers and pharmaceutical operations, with workflows configured for the selected business model.'),
                    $this->faq('Will Darmal track batches and expiry dates?', 'Batch and expiry-aware inventory is part of the planned operational foundation, subject to confirmation in the agreed implementation scope.'),
                ],
            ),
            $this->product(
                slug: 'ograyi-account-manager',
                title: ['en' => 'OGRAYI Mobile Credit & Debit Account Manager', 'fa' => 'OGRAYI برای مدیریت حساب قرض و طلب', 'ps' => 'OGRAYI د پور او طلب حسابونو مدیریت'],
                eyebrow: ['en' => 'Everyday accounts, made clearer', 'fa' => 'حساب‌های روزمره، روشن‌تر', 'ps' => 'ورځني حسابونه، لا روښانه'],
                summary: ['en' => 'A mobile-first product for recording customer and supplier credit, debit and everyday account activity with a connected administration system.', 'fa' => 'محصول موبایل‌محور برای ثبت قرض، طلب و فعالیت روزمره حساب مشتری و عرضه‌کننده با سیستم مدیریتی مرتبط.', 'ps' => 'موبایل‌محور محصول د پیرودونکي او عرضه کوونکي پور، طلب او ورځنیو حسابونو لپاره له تړلي مدیریتي سیسټم سره.'],
                body: [
                    'en' => '<h2>A simpler record for relationship-based accounts</h2><p>OGRAYI is a mobile product under development for small businesses and individuals who record credit, debit and everyday balances with customers or suppliers.</p><h2>Focused account workflows</h2><ul><li>Customer and supplier account records</li><li>Credit and debit transactions</li><li>Running balances and transaction history</li><li>Receipts and clear transaction references</li><li>Owner and authorized employee workflows</li><li>Connected administration and account control</li></ul><h2>Designed for quick daily use</h2><p>The product direction prioritizes a fast mobile interface, clear balances, multilingual use and reliable synchronization with the administration system.</p><h2>Development status</h2><p>OGRAYI remains in product development. Distribution, pricing and final feature availability must be confirmed directly before use.</p>',
                    'fa' => '<h2>ثبت ساده‌تر برای حساب‌های مبتنی بر رابطه</h2><p>OGRAYI یک محصول موبایل در حال توسعه برای تجارت‌های کوچک و افرادی است که قرض، طلب و بیلانس روزمره مشتری یا عرضه‌کننده را ثبت می‌کنند.</p><h2>روندهای متمرکز حساب</h2><ul><li>حساب مشتری و عرضه‌کننده</li><li>معاملات کردیت و دبیت</li><li>بیلانس جاری و تاریخچه معاملات</li><li>رسید و مرجع روشن معامله</li><li>روند مالک و کارمند مجاز</li><li>سیستم مدیریت مرتبط</li></ul><h2>وضعیت توسعه</h2><p>OGRAYI در حال توسعه محصول است. روش توزیع، قیمت و امکانات نهایی پیش از استفاده تأیید می‌شود.</p>',
                    'ps' => '<h2>د اړیکو پر بنسټ حسابونو لپاره ساده ثبت</h2><p>OGRAYI د وړو سوداګریو او هغو خلکو لپاره د پراختیا په حال موبایل محصول دی چې له پیرودونکو یا عرضه کوونکو سره پور، طلب او ورځني بیلانسونه ثبتوي.</p><h2>متمرکز حسابي بهیرونه</h2><ul><li>د پیرودونکي او عرضه کوونکي حسابونه</li><li>کریډیټ او ډیبیټ معاملې</li><li>روان بیلانس او د معاملو تاریخ</li><li>رسیدونه او روښانه مرجع</li><li>د مالک او مجاز کارکوونکي بهیر</li><li>تړلی مدیریتي سیسټم</li></ul><h2>د پراختیا حالت</h2><p>OGRAYI د محصول په پراختیا کې دی. وېش، بیه او وروستي امکانات له کارولو مخکې تاییدېږي.</p>',
                ],
                metaTitle: ['en' => 'Credit & Debit Account Manager App | OGRAYI', 'fa' => 'اپ مدیریت حساب قرض و طلب | OGRAYI', 'ps' => 'د پور او طلب حسابونو اپ | OGRAYI'],
                metaDescription: ['en' => 'OGRAYI is a mobile-first credit and debit account manager for customer, supplier and everyday relationship-based balances.', 'fa' => 'OGRAYI محصول موبایل برای مدیریت قرض، طلب، حساب مشتری، عرضه‌کننده و بیلانس‌های روزمره.', 'ps' => 'OGRAYI موبایل‌محور محصول د پور، طلب، پیرودونکو، عرضه کوونکو او ورځنیو بیلانسونو لپاره.'],
                profile: [
                    'code' => 'OGRAYI', 'accent' => '#ff8a5c',
                    'category' => ['en' => 'Mobile account manager', 'fa' => 'مدیریت حساب موبایل', 'ps' => 'د موبایل حساب مدیر'],
                    'platform' => ['en' => 'Mobile app + web administration', 'fa' => 'اپ موبایل + مدیریت وب', 'ps' => 'موبایل اپ + وېب مدیریت'],
                    'deployment' => ['en' => 'Private business workspace', 'fa' => 'فضای خصوصی تجارتی', 'ps' => 'شخصي سوداګریز کاري ځای'],
                    'status' => ['en' => 'Mobile product development', 'fa' => 'در حال توسعه محصول موبایل', 'ps' => 'د موبایل محصول پراختیا'],
                    'features' => [
                        ['en' => 'Customer accounts', 'fa' => 'حساب مشتری', 'ps' => 'د پیرودونکي حسابونه'],
                        ['en' => 'Supplier accounts', 'fa' => 'حساب عرضه‌کننده', 'ps' => 'د عرضه کوونکي حسابونه'],
                        ['en' => 'Credit & debit', 'fa' => 'قرض و طلب', 'ps' => 'پور او طلب'],
                        ['en' => 'Running balance', 'fa' => 'بیلانس جاری', 'ps' => 'روان بیلانس'],
                        ['en' => 'Receipts', 'fa' => 'رسید', 'ps' => 'رسیدونه'],
                        ['en' => 'Team workflow', 'fa' => 'روند تیم', 'ps' => 'د ټیم بهیر'],
                    ],
                ],
                faqs: [
                    $this->faq('What is OGRAYI intended to manage?', 'OGRAYI is intended to record customer and supplier credit, debit, running balances and everyday account activity through a mobile-first workflow.'),
                    $this->faq('Is OGRAYI available in app stores?', 'Public app-store availability is not currently stated on this website. OGRAYI remains in product development, and distribution must be confirmed directly with Fida Technologies.'),
                    $this->faq('Can a business owner work with employees in OGRAYI?', 'The product direction includes owner and authorized employee workflows connected to an administration system; final behavior depends on the released scope.'),
                ],
            ),
            ...$this->archivePages(),
            $this->page(
                slug: 'privacy-policy',
                title: ['en' => 'Privacy Notice', 'fa' => 'اطلاعیه حریم خصوصی', 'ps' => 'د محرمیت خبرتیا'],
                eyebrow: ['en' => 'How website information is handled', 'fa' => 'نحوه مدیریت معلومات وب‌سایت', 'ps' => 'د وېب‌سایټ معلوماتو د مدیریت څرنګوالی'],
                summary: ['en' => 'A clear description of the information this website receives, why it is used and the choices available to visitors.', 'fa' => 'توضیح روشن معلوماتی که این وب‌سایت دریافت می‌کند، دلیل استفاده و انتخاب‌های بازدیدکننده.', 'ps' => 'د هغو معلوماتو روښانه بیان چې وېب‌سایټ یې ترلاسه کوي، د کارولو دلیل او د لیدونکو انتخابونه.'],
                body: [
                    'en' => '<h2>Information you choose to provide</h2><p>When you submit the project form, Fida Technologies receives the contact and project information you enter, together with the page and campaign source fields included in the form. We use it to review the request, communicate with you and manage the opportunity.</p><h2>Essential website data</h2><p>The website may use necessary session and security data to operate forms, prevent abuse and protect authenticated administration access. Server logs may also contain standard technical request information used for security and troubleshooting.</p><h2>Optional analytics</h2><p>Analytics is loaded only when it is configured on the production website and the visitor accepts analytics. The preference can be changed by clearing the website storage in the browser.</p><h2>Sharing and retention</h2><p>We do not publish contact-form submissions. Information may be accessible to authorized Fida team members and technical service providers required to operate the website. It is retained only as needed for the business request, security and applicable record-keeping.</p><h2>Your request</h2><p>To ask about information submitted through this website, email info@fida.af. Identity verification may be required before disclosing or changing records.</p>',
                    'fa' => '<h2>معلوماتی که شما ارائه می‌کنید</h2><p>هنگام ارسال فورم پروژه، Fida Technologies معلومات تماس و پروژه‌ای را که وارد می‌کنید همراه با صفحه و منبع کمپاین دریافت می‌کند. این معلومات برای بررسی درخواست، تماس با شما و مدیریت فرصت استفاده می‌شود.</p><h2>معلومات ضروری وب‌سایت</h2><p>وب‌سایت می‌تواند از معلومات ضروری نشست و امنیت برای فعالیت فورم، جلوگیری از سوءاستفاده و حفاظت بخش مدیریت استفاده کند.</p><h2>تحلیل اختیاری</h2><p>تحلیل بازدید تنها زمانی بارگذاری می‌شود که در وب‌سایت اصلی تنظیم شده و بازدیدکننده آن را قبول کند.</p><h2>درخواست شما</h2><p>برای پرسش درباره معلومات ارسال‌شده به info@fida.af ایمیل کنید. پیش از ارائه یا تغییر معلومات، تأیید هویت ممکن است لازم باشد.</p>',
                    'ps' => '<h2>هغه معلومات چې تاسو یې ورکوئ</h2><p>کله چې د پروژې فورم لېږئ، Fida Technologies ستاسو د اړیکې او پروژې معلومات له پاڼې او کمپاین سرچینې سره ترلاسه کوي. دا معلومات د غوښتنې د کتنې، اړیکې او فرصت مدیریت لپاره کارول کېږي.</p><h2>اړین وېب‌سایټ معلومات</h2><p>وېب‌سایټ د فورمو، ناوړه کارونې مخنیوي او اډمین خوندي ساتلو لپاره اړین سیشن او امنیتي معلومات کارولی شي.</p><h2>اختیاري تحلیل</h2><p>تحلیل یوازې هغه وخت پورته کېږي چې په اصلي وېب‌سایټ کې تنظیم وي او لیدونکی یې ومني.</p><h2>ستاسو غوښتنه</h2><p>د لېږل شوو معلوماتو په اړه info@fida.af ته برېښنالیک واستوئ. د معلوماتو له ورکولو یا بدلولو مخکې د هویت تایید غوښتل کېدای شي.</p>',
                ],
                metaTitle: ['en' => 'Privacy Notice | Fida Technologies', 'fa' => 'اطلاعیه حریم خصوصی | Fida Technologies', 'ps' => 'د محرمیت خبرتیا | Fida Technologies'],
                metaDescription: ['en' => 'How Fida Technologies handles project-form information, essential website data and optional analytics preferences.', 'fa' => 'نحوه مدیریت معلومات فورم پروژه، معلومات ضروری وب‌سایت و تحلیل اختیاری توسط Fida Technologies.', 'ps' => 'Fida Technologies د پروژې فورم، اړین وېب‌سایټ معلومات او اختیاري تحلیل څنګه اداره کوي.'],
                type: 'page',
            ),
        ];
    }

    private function archivePages(): array
    {
        return [
            $this->archivePage(
                'solutions',
                ['en' => 'Business Software Solutions', 'fa' => 'راهکارهای نرم‌افزار تجارتی', 'ps' => 'د سوداګریز سافټویر حللارې'],
                ['en' => 'Technology matched to the outcome', 'fa' => 'تکنالوژی مطابق نتیجه', 'ps' => 'له پایلې سره برابره ټکنالوژي'],
                ['en' => 'Explore ERP, accounting, custom software and mobile solutions designed around operational control and growth.', 'fa' => 'راهکارهای ERP، حسابداری، نرم‌افزار اختصاصی و موبایل را مطابق کنترول عملیات و رشد بررسی کنید.', 'ps' => 'د عملیاتي کنټرول او ودې لپاره ERP، حسابداري، ځانګړی سافټویر او موبایل حللارې وپلټئ.'],
                ['en' => '<h2>Start with the business outcome</h2><p>Each solution profile explains the workflow it addresses, the practical implementation questions and the capabilities that can be confirmed before a project begins.</p>', 'fa' => '<h2>از نتیجه تجارتی آغاز کنید</h2><p>هر پروفایل راهکار، روند کاری، پرسش‌های عملی تطبیق و توانایی‌هایی را توضیح می‌دهد که پیش از شروع پروژه قابل تأیید است.</p>', 'ps' => '<h2>له سوداګریزې پایلې پیل وکړئ</h2><p>د هرې حللارې پېژندپاڼه کاري بهیر، عملي پوښتنې او هغه وړتیاوې بیانوي چې تر پروژې مخکې تاییدېدای شي.</p>'],
                3,
            ),
            $this->archivePage(
                'products',
                ['en' => 'Fida Software Products', 'fa' => 'محصولات نرم‌افزاری فیدا', 'ps' => 'د فیدا سافټویر محصولات'],
                ['en' => 'Purpose-built platforms', 'fa' => 'پلتفرم‌های هدفمند', 'ps' => 'د ځانګړي هدف پلېټفارمونه'],
                ['en' => 'Review Fida product profiles for real estate, finance, pharmaceutical operations and mobile account management.', 'fa' => 'پروفایل محصولات فیدا برای املاک، مالی، عملیات دارویی و مدیریت حساب موبایل را بررسی کنید.', 'ps' => 'د املاکو، مالي، درملو عملیاتو او موبایل حساب مدیریت لپاره د فیدا محصولات وګورئ.'],
                ['en' => '<h2>Confirmed product information</h2><p>Product pages describe the intended workflow, platform direction and currently confirmed capabilities. Availability, implementation scope and commercial terms are confirmed directly for each engagement.</p>', 'fa' => '<h2>معلومات تأییدشده محصول</h2><p>صفحات محصول روند مورد نظر، جهت پلتفرم و توانایی‌های تأییدشده فعلی را توضیح می‌دهد. موجودیت، محدوده تطبیق و شرایط تجارتی برای هر همکاری جداگانه تأیید می‌شود.</p>', 'ps' => '<h2>تایید شوي محصولي معلومات</h2><p>د محصول پاڼې هدف کاري بهیر، د پلېټفارم لوری او اوس تایید شوې وړتیاوې بیانوي. شتون، د پلي کولو حدود او سوداګریز شرایط د هرې همکارۍ لپاره جلا تاییدېږي.</p>'],
                4,
            ),
            $this->archivePage(
                'industries',
                ['en' => 'Software for Afghan Industries', 'fa' => 'نرم‌افزار برای صنایع افغانستان', 'ps' => 'د افغانستان د سکتورونو لپاره سافټویر'],
                ['en' => 'Workflow knowledge by sector', 'fa' => 'شناخت روند به تفکیک صنعت', 'ps' => 'د سکتور له مخې د کاري بهیر پوهه'],
                ['en' => 'Industry pages connect sector-specific workflows with practical software architecture and implementation guidance.', 'fa' => 'صفحات صنعت، روندهای خاص هر بخش را با معماری عملی نرم‌افزار و راهنمای تطبیق یکجا می‌کند.', 'ps' => 'د سکتور پاڼې ځانګړي کاري بهیرونه له عملي سافټویر معمارۍ او د پلي کولو لارښوونې سره نښلوي.'],
                ['en' => '<h2>Industry knowledge must be specific</h2><p>As verified industry guides are published, they will document the roles, controls, reports and integration questions that materially affect software design in each sector.</p>', 'fa' => '<h2>شناخت صنعت باید مشخص باشد</h2><p>با نشر راهنماهای تأییدشده، نقش‌ها، کنترول‌ها، گزارش‌ها و پرسش‌های یکپارچه‌سازی مؤثر بر طراحی نرم‌افزار هر صنعت مستند می‌شود.</p>', 'ps' => '<h2>د سکتور پوهه باید مشخصه وي</h2><p>کله چې تایید شوې لارښوونې خپرې شي، د هر سکتور هغه رولونه، کنټرولونه، راپورونه او د ادغام پوښتنې به ثبت کړي چې د سافټویر پر ډیزاین اغېز لري.</p>'],
                5,
            ),
            $this->archivePage(
                'case-studies',
                ['en' => 'Verified Software Case Studies', 'fa' => 'مطالعات موردی تأییدشده نرم‌افزار', 'ps' => 'تایید شوې د سافټویر قضیوي مطالعې'],
                ['en' => 'Evidence before promotion', 'fa' => 'شواهد پیش از تبلیغ', 'ps' => 'تر تبلیغ مخکې شواهد'],
                ['en' => 'Approved implementation stories will appear here only after client permission, factual review and evidence checks.', 'fa' => 'داستان‌های تطبیق تنها پس از اجازه مشتری، بررسی حقایق و شواهد در اینجا نشر می‌شود.', 'ps' => 'د پلي کولو کیسې به یوازې د مشتری له اجازې، د حقایقو او شواهدو له کتنې وروسته دلته خپرېږي.'],
                ['en' => '<h2>Trust requires verification</h2><p>Case studies remain private drafts until the client identity, project scope, screenshots and measurable outcomes are approved for public use.</p>', 'fa' => '<h2>اعتماد به تأیید نیاز دارد</h2><p>مطالعات موردی تا زمان تأیید هویت مشتری، محدوده پروژه، تصاویر و نتایج قابل اندازه‌گیری برای استفاده عمومی، خصوصی باقی می‌ماند.</p>', 'ps' => '<h2>باور تایید ته اړتیا لري</h2><p>قضیوي مطالعې تر هغه شخصي مسودې پاتې کېږي چې د مشتری هویت، د پروژې حدود، انځورونه او اندازه کېدونکې پایلې د عامه کارونې لپاره تایید شي.</p>'],
                6,
            ),
            $this->archivePage(
                'articles',
                ['en' => 'Software & Business Insights', 'fa' => 'دیدگاه‌های نرم‌افزار و تجارت', 'ps' => 'د سافټویر او سوداګرۍ لیدلوري'],
                ['en' => 'Practical knowledge for better systems', 'fa' => 'دانش عملی برای سیستم‌های بهتر', 'ps' => 'د غوره سیسټمونو لپاره عملي پوهه'],
                ['en' => 'Read practical guidance about ERP, software selection, implementation, security and digital operations in Afghanistan.', 'fa' => 'راهنمای عملی ERP، انتخاب نرم‌افزار، تطبیق، امنیت و عملیات دیجیتال در افغانستان را بخوانید.', 'ps' => 'په افغانستان کې د ERP، سافټویر ټاکنې، پلي کولو، امنیت او ډیجیټل عملیاتو عملي لارښوونې ولولئ.'],
                ['en' => '<h2>Useful answers, not filler</h2><p>Articles are published when they provide a clear, factual answer to a real business or technology question. New posts can be managed from the Articles section of the website console.</p>', 'fa' => '<h2>پاسخ مفید، نه محتوای اضافی</h2><p>مقالات زمانی نشر می‌شود که به یک پرسش واقعی تجارتی یا تخنیکی پاسخ روشن و دقیق بدهد. نوشته‌های جدید از بخش مقالات کنسول مدیریت می‌شود.</p>', 'ps' => '<h2>ګټور ځوابونه، نه اضافي منځپانګه</h2><p>مقالې هغه وخت خپرېږي چې یوې واقعي سوداګریزې یا تخنیکي پوښتنې ته روښانه او دقیق ځواب ورکړي. نوې لیکنې د اډمین د مقالو له برخې اداره کېږي.</p>'],
                7,
            ),
        ];
    }

    private function archivePage(string $slug, array $title, array $eyebrow, array $summary, array $body, int $sortOrder): array
    {
        return $this->page(
            slug: $slug,
            title: $title,
            eyebrow: $eyebrow,
            summary: $summary,
            body: $body,
            metaTitle: array_map(fn (string $value): string => $value.' | Fida Technologies', $title),
            metaDescription: $summary,
            type: 'page',
            sortOrder: $sortOrder,
        );
    }

    private function page(string $slug, array $title, array $eyebrow, array $summary, array $body, array $metaTitle, array $metaDescription, array $faqs = [], string $type = 'solution', array $metadata = [], int $sortOrder = 0, ?array $primaryQuery = null, ?string $searchIntent = null): array
    {
        return [
            'slug' => $slug,
            'type' => $type,
            'title' => $title,
            'eyebrow' => $eyebrow,
            'summary' => $summary,
            'body' => $body,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'primary_query' => $primaryQuery,
            'search_intent' => $searchIntent,
            'metadata' => array_replace_recursive($metadata, ['faqs' => $faqs]),
            'status' => 'published',
            'featured' => true,
            'sort_order' => $sortOrder,
            'published_at' => now(),
        ];
    }

    private function product(string $slug, array $title, array $eyebrow, array $summary, array $body, array $metaTitle, array $metaDescription, array $profile, array $faqs): array
    {
        return $this->page(
            slug: $slug,
            title: $title,
            eyebrow: $eyebrow,
            summary: $summary,
            body: $body,
            metaTitle: $metaTitle,
            metaDescription: $metaDescription,
            faqs: $faqs,
            type: 'product',
            metadata: ['product' => $profile],
            sortOrder: 10,
        );
    }

    private function caseStudyDrafts(): array
    {
        return collect([
            ['realist-erp-case-study', 'Realist ERP case study'],
            ['prime-sarafi-case-study', 'Prime Sarafi case study'],
            ['darmal-erp-case-study', 'Darmal ERP case study'],
            ['ograyi-case-study', 'OGRAYI case study'],
        ])->map(fn (array $draft): array => [
            'slug' => $draft[0],
            'type' => 'case-study',
            'title' => ['en' => $draft[1].' — publication draft'],
            'eyebrow' => ['en' => 'Evidence required before publication'],
            'summary' => ['en' => 'Internal draft. Add verified client permission, implementation facts, approved screenshots and measurable outcomes before publishing.'],
            'body' => ['en' => '<h2>Publication checklist</h2><ul><li>Confirm the client or business name and written permission</li><li>Describe the workflow before implementation without exaggeration</li><li>List the exact modules and implementation period</li><li>Add approved, redacted product screenshots</li><li>Add only measurable outcomes supported by records</li><li>Obtain final client approval for public use</li></ul>'],
            'meta_title' => ['en' => $draft[1].' | Fida Technologies'],
            'meta_description' => ['en' => 'Unpublished internal case-study draft awaiting verified implementation evidence.'],
            'status' => 'draft',
            'featured' => false,
            'sort_order' => 100,
        ])->all();
    }

    private function faq(string $question, string $answer): array
    {
        return [
            'question' => ['en' => $question],
            'answer' => ['en' => $answer],
        ];
    }
}
