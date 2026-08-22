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

        foreach ($this->caseStudyDrafts() as $caseStudy) {
            ContentPage::query()->firstOrCreate(['slug' => $caseStudy['slug']], $caseStudy);
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
                body: ['en' => '<h2>Software should fit the business</h2><p>We analyze your operation, simplify the workflow and develop a maintainable system with clear permissions, auditability and reporting.</p>', 'fa' => '<h2>نرم‌افزار باید با تجارت هماهنگ باشد</h2><p>عملیات شما را تحلیل، روند را ساده و یک سیستم قابل توسعه با صلاحیت‌ها، ثبت فعالیت و گزارش‌دهی روشن می‌سازیم.</p>', 'ps' => '<h2>سافټویر باید له سوداګرۍ سره برابر وي</h2><p>ستاسو عملیات څېړو، کاري بهیر ساده کوو او د روښانه صلاحیتونو، ثبت او راپورونو لرونکی سیسټم جوړوو.</p>'],
                metaTitle: ['en' => 'Software Development Company in Afghanistan | Fida', 'fa' => 'شرکت توسعه نرم‌افزار در افغانستان | فیدا', 'ps' => 'په افغانستان کې د سافټویر شرکت | فیدا'],
                metaDescription: ['en' => 'Custom software development for businesses in Afghanistan, including ERP, SaaS, portals, APIs and mobile backends.', 'fa' => 'توسعه نرم‌افزار اختصاصی، ERP، SaaS، پورتال، API و بک‌اند موبایل در افغانستان.', 'ps' => 'په افغانستان کې ځانګړی سافټویر، ERP، SaaS، پورټلونه، API او موبایل بیک‌اېنډ.'],
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
                faqs: [
                    $this->faq('What services does Fida Technologies provide in Afghanistan?', 'Fida provides ERP and MIS systems, accounting software, custom web platforms, mobile applications, workflow automation and software integration services.'),
                    $this->faq('Where is Fida Technologies based?', 'Fida Technologies is based in Kabul, Afghanistan and develops business technology for organizations that need locally informed implementation and support.'),
                    $this->faq('Which languages can Fida software support?', 'Fida products can be designed for English, Dari and Pashto, including right-to-left interfaces where required.'),
                ],
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

    private function page(string $slug, array $title, array $eyebrow, array $summary, array $body, array $metaTitle, array $metaDescription, array $faqs = [], string $type = 'solution', array $metadata = [], int $sortOrder = 0): array
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
