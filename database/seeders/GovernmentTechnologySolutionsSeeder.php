<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class GovernmentTechnologySolutionsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            ContentPage::query()->firstOrCreate(['slug' => $page['slug']], $page);
        }
    }

    private function pages(): array
    {
        $items = [
            [
                'slug' => 'web-digital-platforms-afghanistan',
                'title' => ['en' => 'Web Development & Digital Platforms in Afghanistan', 'fa' => 'توسعه وب و پلتفرم‌های دیجیتال در افغانستان', 'ps' => 'په افغانستان کې ویب پراختیا او ډیجیټل پلېټفارمونه'],
                'eyebrow' => ['en' => 'Public portals, corporate platforms and secure web applications', 'fa' => 'پورتال‌های عمومی، پلتفرم‌های شرکتی و وب‌اپلیکیشن‌های امن', 'ps' => 'عامه پورټلونه، شرکتي پلېټفارمونه او خوندي ویب اپلېکېشنونه'],
                'summary' => ['en' => 'Design and build secure, multilingual websites, public portals, institutional platforms and transaction-ready web applications for government, NGOs and enterprises.', 'fa' => 'طراحی و توسعه وب‌سایت‌های امن و چندزبانه، پورتال‌های عمومی، پلتفرم‌های سازمانی و وب‌اپلیکیشن‌ها برای دولت، نهادها و شرکت‌ها.', 'ps' => 'د دولت، نادولتي ادارو او شرکتونو لپاره خوندي څوژبي وېب‌سایټونه، عامه پورټلونه او سازماني ویب اپلېکېشنونه جوړوو.'],
                'query' => ['en' => 'web development company Afghanistan', 'fa' => 'شرکت طراحی وب افغانستان', 'ps' => 'په افغانستان کې د ویب جوړولو شرکت'],
                'capabilities' => ['Corporate and institutional websites', 'Government and NGO portals', 'SaaS and customer platforms', 'CMS and multilingual publishing', 'API-connected web applications', 'Accessibility, performance and technical SEO'],
            ],
            [
                'slug' => 'ai-automation-solutions-afghanistan',
                'title' => ['en' => 'AI & Intelligent Automation Solutions in Afghanistan', 'fa' => 'راهکارهای هوش مصنوعی و اتوماسیون هوشمند در افغانستان', 'ps' => 'په افغانستان کې د AI او هوښیار اتومات حللارې'],
                'eyebrow' => ['en' => 'Practical AI for documents, workflows, search and decisions', 'fa' => 'هوش مصنوعی عملی برای اسناد، روندها، جستجو و تصمیم‌گیری', 'ps' => 'د اسنادو، کاري بهیرونو، لټون او پرېکړو لپاره عملي AI'],
                'summary' => ['en' => 'Apply AI to document processing, knowledge search, workflow assistance, reporting and controlled automation without replacing institutional accountability.', 'fa' => 'استفاده از هوش مصنوعی برای پردازش اسناد، جستجوی دانش، کمک به روند کاری، گزارش‌دهی و اتوماسیون کنترول‌شده.', 'ps' => 'AI د اسنادو پروسس، پوهې لټون، کاري مرستې، راپورونو او کنټرول شوي اتومات لپاره کاروو.'],
                'query' => ['en' => 'AI solutions Afghanistan', 'fa' => 'راهکار هوش مصنوعی افغانستان', 'ps' => 'په افغانستان کې د AI حللارې'],
                'capabilities' => ['AI assistants and knowledge search', 'Document extraction and classification', 'Workflow copilots', 'Analytics and reporting assistance', 'Multilingual AI interfaces', 'Human approval and audit controls'],
            ],
            [
                'slug' => 'iot-smart-systems-afghanistan',
                'title' => ['en' => 'IoT & Smart Systems in Afghanistan', 'fa' => 'IoT و سیستم‌های هوشمند در افغانستان', 'ps' => 'په افغانستان کې IoT او هوښیار سیسټمونه'],
                'eyebrow' => ['en' => 'Connected sensors, assets and operational monitoring', 'fa' => 'سنسورها، دارایی‌ها و نظارت عملیاتی متصل', 'ps' => 'وصل سنسرونه، شتمنۍ او عملیاتي څارنه'],
                'summary' => ['en' => 'Connect sensors, devices, assets and field operations to dashboards, alerts and enterprise systems for smarter monitoring and control.', 'fa' => 'سنسورها، دستگاه‌ها، دارایی‌ها و عملیات ساحوی را به داشبوردها، هشدارها و سیستم‌های سازمانی وصل کنید.', 'ps' => 'سنسرونه، وسایل، شتمنۍ او ساحوي عملیات له ډشبورډونو، خبرتیاوو او سازماني سیسټمونو سره نښلوو.'],
                'query' => ['en' => 'IoT solutions Afghanistan', 'fa' => 'سیستم IoT افغانستان', 'ps' => 'په افغانستان کې IoT سیستم'],
                'capabilities' => ['Sensors and telemetry', 'Asset and equipment monitoring', 'Remote alerts and dashboards', 'GPS and field tracking', 'Device-to-ERP integration', 'Smart facility and utility monitoring'],
            ],
            [
                'slug' => 'data-center-it-infrastructure-afghanistan',
                'title' => ['en' => 'Data Center & IT Infrastructure in Afghanistan', 'fa' => 'دیتاسنتر و زیربنای IT در افغانستان', 'ps' => 'په افغانستان کې ډیټا سنټر او IT زیربنا'],
                'eyebrow' => ['en' => 'Server rooms, data centers, power, storage and resilient infrastructure', 'fa' => 'اتاق سرور، دیتاسنتر، برق، ذخیره‌سازی و زیربنای پایدار', 'ps' => 'سرور خونې، ډیټا سنټرونه، برېښنا، ذخیره او باوري زیربنا'],
                'summary' => ['en' => 'Plan, supply, deploy and document data-center and server-room infrastructure for government, NGOs, banks and enterprise environments.', 'fa' => 'طراحی، تأمین، نصب و مستندسازی زیربنای دیتاسنتر و اتاق سرور برای دولت، نهادها، بانک‌ها و سازمان‌ها.', 'ps' => 'د دولت، نادولتي ادارو، بانکونو او شرکتونو لپاره د ډیټا سنټر او سرور خونې زیربنا طرحه، تجهیز او نصب کوو.'],
                'query' => ['en' => 'data center solutions Afghanistan', 'fa' => 'دیتاسنتر افغانستان', 'ps' => 'په افغانستان کې ډیټا سنټر'],
                'capabilities' => ['Data center and server-room design', 'Racks, UPS and power architecture', 'Servers and enterprise storage', 'Backup and disaster recovery', 'Environmental monitoring', 'Installation, labeling and as-built documentation'],
            ],
            [
                'slug' => 'network-engineering-operations-afghanistan',
                'title' => ['en' => 'Network Engineering & Operations in Afghanistan', 'fa' => 'مهندسی و عملیات شبکه در افغانستان', 'ps' => 'په افغانستان کې د شبکې انجینري او عملیات'],
                'eyebrow' => ['en' => 'LAN, WAN, wireless, routing, switching and network operations', 'fa' => 'LAN، WAN، وایرلس، روتینگ، سویچینگ و عملیات شبکه', 'ps' => 'LAN، WAN، وایرلس، روټینګ، سویچینګ او د شبکې عملیات'],
                'summary' => ['en' => 'Design, deploy, secure and operate reliable networks for offices, campuses, branches, data centers and field locations.', 'fa' => 'طراحی، نصب، امن‌سازی و مدیریت شبکه‌های قابل اعتماد برای دفاتر، شعبات، دیتاسنترها و ساحات.', 'ps' => 'د دفترونو، څانګو، ډیټا سنټرونو او ساحوي ځایونو لپاره باوري شبکې ډیزاین، نصب او اداره کوو.'],
                'query' => ['en' => 'network solutions Afghanistan', 'fa' => 'خدمات شبکه افغانستان', 'ps' => 'په افغانستان کې د شبکې خدمات'],
                'capabilities' => ['LAN and WAN architecture', 'Routing and switching', 'Enterprise Wi-Fi', 'Structured cabling and fiber', 'Network monitoring and administration', 'Branch and site connectivity'],
            ],
            [
                'slug' => 'cloud-servers-virtualization-afghanistan',
                'title' => ['en' => 'Cloud, Servers & Virtualization in Afghanistan', 'fa' => 'کلود، سرورها و مجازی‌سازی در افغانستان', 'ps' => 'په افغانستان کې کلاوډ، سرورونه او مجازي کول'],
                'eyebrow' => ['en' => 'Private, public and hybrid infrastructure', 'fa' => 'زیربنای خصوصی، عمومی و هایبرید', 'ps' => 'خصوصي، عامه او هایبرډ زیربنا'],
                'summary' => ['en' => 'Deploy physical servers, virtualized environments, cloud workloads, backup and hybrid infrastructure with clear ownership and operational controls.', 'fa' => 'سرورهای فزیکی، محیط‌های مجازی، بارهای کاری کلود، بکاپ و زیربنای هایبرید را با کنترول روشن تطبیق کنید.', 'ps' => 'فزیکي سرورونه، مجازي چاپېریالونه، کلاوډ، بیک اپ او هایبرډ زیربنا په کنټرول شوې بڼه پلي کوو.'],
                'query' => ['en' => 'server virtualization Afghanistan', 'fa' => 'مجازی سازی سرور افغانستان', 'ps' => 'په افغانستان کې د سرور مجازي کول'],
                'capabilities' => ['Physical server deployment', 'VMware, Hyper-V and Linux virtualization', 'Cloud and hybrid architecture', 'Backup and recovery', 'Identity and access integration', 'Monitoring and capacity planning'],
            ],
            [
                'slug' => 'cybersecurity-infrastructure-security-afghanistan',
                'title' => ['en' => 'Cybersecurity & Infrastructure Security in Afghanistan', 'fa' => 'امنیت سایبری و امنیت زیربنا در افغانستان', 'ps' => 'په افغانستان کې سایبري او د زیربنا امنیت'],
                'eyebrow' => ['en' => 'Security architecture, hardening, segmentation and monitoring', 'fa' => 'معماری امنیت، سخت‌سازی، جداسازی و نظارت', 'ps' => 'امنیتي معماري، هارډنینګ، وېش او څارنه'],
                'summary' => ['en' => 'Strengthen infrastructure through firewalling, segmentation, server hardening, endpoint protection, access controls, backup and security monitoring.', 'fa' => 'زیربنا را با فایروال، جداسازی شبکه، سخت‌سازی سرور، امنیت نقاط نهایی، کنترول دسترسی و نظارت تقویت کنید.', 'ps' => 'زیربنا د فایروال، شبکې وېش، سرور هارډنینګ، پای وسایلو امنیت، لاسرسي کنټرول او څارنې له لارې پیاوړې کوو.'],
                'query' => ['en' => 'cybersecurity company Afghanistan', 'fa' => 'شرکت امنیت سایبری افغانستان', 'ps' => 'په افغانستان کې سایبري امنیت شرکت'],
                'capabilities' => ['Firewall and network segmentation', 'Server and endpoint hardening', 'Identity and access controls', 'Backup and recovery controls', 'Security monitoring', 'Security review and remediation plans'],
            ],
            [
                'slug' => 'enterprise-hardware-technology-supply-afghanistan',
                'title' => ['en' => 'Enterprise Hardware & Technology Supply in Afghanistan', 'fa' => 'تأمین تجهیزات و تکنالوژی سازمانی در افغانستان', 'ps' => 'په افغانستان کې د سازماني هارډویر او ټکنالوژۍ عرضه'],
                'eyebrow' => ['en' => 'Procurement-ready technology supply with deployment support', 'fa' => 'تأمین تکنالوژی مطابق تدارکات همراه با نصب و پشتیبانی', 'ps' => 'د تدارکاتو لپاره چمتو ټکنالوژي عرضه له نصب او ملاتړ سره'],
                'summary' => ['en' => 'Supply enterprise servers, networking equipment, computers, storage, UPS systems and related technology with specification matching, installation and documentation.', 'fa' => 'تأمین سرورها، تجهیزات شبکه، کمپیوترها، ذخیره‌سازی، UPS و تجهیزات مرتبط همراه با تطبیق مشخصات، نصب و اسناد.', 'ps' => 'سرورونه، د شبکې وسایل، کمپیوټرونه، ذخیره، UPS او نور سازماني تجهیزات د مشخصاتو، نصب او اسنادو سره عرضه کوو.'],
                'query' => ['en' => 'IT equipment supplier Afghanistan', 'fa' => 'تأمین کننده تجهیزات IT افغانستان', 'ps' => 'په افغانستان کې د IT تجهیزاتو عرضه کوونکی'],
                'capabilities' => ['Servers and storage', 'Switches, routers and firewalls', 'Business computers and workstations', 'UPS and power equipment', 'Racks, cabling and accessories', 'Specification compliance and delivery documentation'],
            ],
            [
                'slug' => 'systems-integration-deployment-afghanistan',
                'title' => ['en' => 'Systems Integration & Deployment in Afghanistan', 'fa' => 'یکپارچه‌سازی و استقرار سیستم‌ها در افغانستان', 'ps' => 'په افغانستان کې د سیسټمونو ادغام او پلي کول'],
                'eyebrow' => ['en' => 'Connect software, infrastructure, data and operational processes', 'fa' => 'اتصال نرم‌افزار، زیربنا، معلومات و روندهای عملیاتی', 'ps' => 'سافټویر، زیربنا، معلومات او عملیاتي بهیرونه سره نښلول'],
                'summary' => ['en' => 'Integrate software platforms, APIs, identity systems, networks, servers and data flows into one controlled operating environment.', 'fa' => 'پلتفرم‌های نرم‌افزاری، APIها، هویت، شبکه، سرورها و جریان معلومات را در یک محیط کنترول‌شده یکپارچه کنید.', 'ps' => 'سافټویر پلېټفارمونه، API، هویت، شبکې، سرورونه او معلوماتي جریانونه په یوه کنټرول شوي چاپېریال کې مدغم کوو.'],
                'query' => ['en' => 'systems integration Afghanistan', 'fa' => 'یکپارچه سازی سیستم افغانستان', 'ps' => 'په افغانستان کې د سیسټمونو ادغام'],
                'capabilities' => ['API and application integration', 'Identity and directory integration', 'Data migration and synchronization', 'Hardware-software integration', 'Testing and commissioning', 'Handover and technical documentation'],
            ],
            [
                'slug' => 'managed-it-services-afghanistan',
                'title' => ['en' => 'IT Consulting, Support & Managed Services in Afghanistan', 'fa' => 'مشاوره، پشتیبانی و خدمات مدیریت‌شده IT در افغانستان', 'ps' => 'په افغانستان کې د IT مشوره، ملاتړ او مدیریت شوي خدمات'],
                'eyebrow' => ['en' => 'Ongoing infrastructure, network and systems support', 'fa' => 'پشتیبانی دوامدار زیربنا، شبکه و سیستم‌ها', 'ps' => 'د زیربنا، شبکې او سیسټمونو دوامدار ملاتړ'],
                'summary' => ['en' => 'Maintain critical technology through support agreements, administration, monitoring, preventive maintenance, documentation and technical advisory.', 'fa' => 'تکنالوژی حیاتی را با قراردادهای پشتیبانی، مدیریت، نظارت، نگهداری پیشگیرانه، مستندسازی و مشوره تخنیکی حفظ کنید.', 'ps' => 'مهمه ټکنالوژي د ملاتړ تړونونو، ادارې، څارنې، وقایوي ساتنې، اسنادو او تخنیکي مشورې له لارې ساتو.'],
                'query' => ['en' => 'managed IT services Afghanistan', 'fa' => 'خدمات مدیریت شده IT افغانستان', 'ps' => 'په افغانستان کې مدیریت شوي IT خدمات'],
                'capabilities' => ['Network and server administration', 'Monitoring and incident response', 'Preventive maintenance', 'Patch and configuration management', 'IT assessments and roadmaps', 'Training, SOPs and documentation'],
            ],
            [
                'slug' => 'government-ngo-technology-procurement-afghanistan',
                'title' => ['en' => 'Government & NGO Technology Procurement in Afghanistan', 'fa' => 'تدارکات تکنالوژی برای دولت و نهادها در افغانستان', 'ps' => 'په افغانستان کې د دولت او نادولتي ادارو د ټکنالوژۍ تدارکات'],
                'eyebrow' => ['en' => 'RFQ, RFP and tender-ready technology delivery', 'fa' => 'تحویل تکنالوژی آماده RFQ، RFP و داوطلبی', 'ps' => 'د RFQ، RFP او داوطلبۍ لپاره چمتو ټکنالوژي سپارنه'],
                'summary' => ['en' => 'A single technology partner for software, web and mobile platforms, data centers, networks, servers, cybersecurity, hardware supply, integration, installation, training and support.', 'fa' => 'یک شریک تکنالوژی برای نرم‌افزار، وب و موبایل، دیتاسنتر، شبکه، سرور، امنیت، تجهیزات، یکپارچه‌سازی، نصب، آموزش و پشتیبانی.', 'ps' => 'د سافټویر، ویب او موبایل، ډیټا سنټر، شبکې، سرور، امنیت، تجهیزاتو، ادغام، نصب، روزنې او ملاتړ لپاره یو ټکنالوژي شریک.'],
                'query' => ['en' => 'government NGO IT solutions Afghanistan', 'fa' => 'خدمات IT برای دولت و NGO افغانستان', 'ps' => 'په افغانستان کې د دولت او NGO لپاره IT خدمات'],
                'capabilities' => ['RFQ, RFP and tender response', 'Technical compliance matrices', 'BoQ and specification review', 'Software and infrastructure delivery', 'Installation and commissioning', 'Training, warranty and support documentation'],
                'procurement' => true,
            ],
        ];

        return array_map(fn (array $item): array => $this->page($item), $items);
    }

    private function page(array $item): array
    {
        $procurement = (bool) ($item['procurement'] ?? false);
        $capabilityList = implode('', array_map(fn (string $capability): string => '<li>'.e($capability).'</li>', $item['capabilities']));

        $bodyEn = $procurement
            ? '<h2>One accountable technology partner for institutional procurement</h2><p>Government agencies, NGOs, INGOs, donors, banks and large organizations often need more than a product quote. They need a supplier that can read the requirement, confirm compliance, propose an architecture, supply equipment, configure systems, document delivery and support the implementation.</p><h2>What Fida can include in an RFQ or RFP response</h2><ul>'.$capabilityList.'</ul><h2>Software and infrastructure can be delivered together</h2><p>Fida can combine ERP, MIS, web and mobile systems with networks, servers, data-center components, security, hardware, integration and support under a coordinated delivery plan. Scope, brands, quantities, licensing, warranty and acceptance criteria remain explicit in the quotation.</p><h2>Procurement-ready documentation</h2><p>For formal opportunities we can structure a technical response around the requested specifications, implementation methodology, work plan, deliverables, assumptions, training, warranty, support and commercial schedule. We do not claim certifications, authorizations or brand partnerships that are not actually held.</p><h2>Submit the requirement once</h2><p>Use the RFQ submission page to send the project title, organization, deadline, scope and tender documents. A reference number is generated and the request is delivered to our procurement inbox.</p>'
            : '<h2>Enterprise delivery built around the real environment</h2><p>'.$item['summary']['en'].'</p><h2>Core capabilities</h2><ul>'.$capabilityList.'</ul><h2>Designed for government, NGOs and enterprise operations</h2><p>Every engagement begins with requirements, ownership, security, deployment constraints, documentation and acceptance criteria. Fida can deliver the technology as a focused project or integrate it with existing software, infrastructure and operational systems.</p><h2>Professional implementation and handover</h2><p>Projects can include assessment, design, bill of quantities, configuration, installation, testing, migration, commissioning, training, technical documentation and post-deployment support. Final scope depends on the approved requirement and procurement method.</p>';

        $bodyFa = '<h2>تطبیق حرفه‌ای مطابق محیط واقعی سازمان</h2><p>'.$item['summary']['fa'].'</p><h2>توانایی‌های اصلی</h2><p>محدوده کار می‌تواند شامل تحلیل نیازمندی، طراحی راهکار، تهیه تجهیزات، نصب، تنظیمات، تست، انتقال معلومات، آموزش، اسناد تخنیکی و پشتیبانی باشد.</p><h2>مناسب برای دولت، NGO و سازمان‌های بزرگ</h2><p>در هر پروژه، مشخصات تخنیکی، امنیت، مسئولیت‌ها، تحویل‌دادنی‌ها، معیار پذیرش، تضمین و پشتیبانی به شکل واضح تعریف می‌شود.</p>';
        $bodyPs = '<h2>د سازمان د واقعي چاپېریال مطابق مسلکي پلي کول</h2><p>'.$item['summary']['ps'].'</p><h2>اصلي وړتیاوې</h2><p>کاري حدود کېدای شي اړتیا شننه، حللارې ډیزاین، تجهیزات، نصب، تنظیمات، ازموینه، معلوماتو لېږد، روزنه، تخنیکي اسناد او ملاتړ شامل کړي.</p><h2>د دولت، NGO او لویو ادارو لپاره مناسب</h2><p>په هره پروژه کې تخنیکي مشخصات، امنیت، مسؤلیتونه، سپارنې، د منلو معیارونه، تضمین او ملاتړ روښانه ټاکل کېږي.</p>';

        $faqs = [
            $this->faq(
                ['en' => 'Can Fida respond to formal RFQs, RFPs and tenders?', 'fa' => 'آیا Fida می‌تواند به RFQ، RFP و داوطلبی رسمی پاسخ دهد؟', 'ps' => 'ایا Fida رسمي RFQ، RFP او داوطلبۍ ته ځواب ورکولی شي؟'],
                ['en' => 'Yes. Fida can review the requirement and prepare a scope-based technical and commercial response where the requested work matches our capabilities. Any required eligibility, certification or manufacturer authorization must be assessed against the specific procurement.', 'fa' => 'بله. در صورت مطابقت نیازمندی با توانایی‌های ما، Fida می‌تواند پاسخ تخنیکی و تجارتی مطابق محدوده تهیه کند. شرایط اهلیت، تصدیق‌نامه یا مجوز سازنده باید برای هر تدارکات جداگانه بررسی شود.', 'ps' => 'هو. که اړتیا زموږ له وړتیاوو سره برابره وي، Fida کولی شي تخنیکي او سوداګریز ځواب چمتو کړي. د اهلیت، تصدیق یا جوړونکي اجازې شرطونه د هرې داوطلبۍ لپاره جلا ارزول کېږي.'],
            ),
            $this->faq(
                ['en' => 'Can software, hardware and infrastructure be quoted in one project?', 'fa' => 'آیا نرم‌افزار، تجهیزات و زیربنا در یک پروژه قیمت‌گذاری می‌شود؟', 'ps' => 'ایا سافټویر، تجهیزات او زیربنا په یوه پروژه کې نرخ کېدای شي؟'],
                ['en' => 'Yes, when the requirement is integrated. The quotation can separate software, licenses, equipment, installation, configuration, training, warranty and support so procurement teams can evaluate each component clearly.', 'fa' => 'بله، در صورت یکپارچه بودن نیازمندی. پیشنهاد می‌تواند نرم‌افزار، لایسنس، تجهیزات، نصب، تنظیمات، آموزش، تضمین و پشتیبانی را جدا و واضح نشان دهد.', 'ps' => 'هو، که اړتیا مدغمه وي. نرخپاڼه سافټویر، لایسنس، تجهیزات، نصب، تنظیمات، روزنه، تضمین او ملاتړ په جلا او روښانه ډول ښودلی شي.'],
            ),
            $this->faq(
                ['en' => 'Do you provide installation, configuration, training and documentation?', 'fa' => 'آیا نصب، تنظیمات، آموزش و اسناد تخنیکی ارائه می‌کنید؟', 'ps' => 'ایا نصب، تنظیمات، روزنه او تخنیکي اسناد وړاندې کوئ؟'],
                ['en' => 'They can all be included when required. The final statement of work should specify sites, equipment, configuration tasks, testing, acceptance, training audience, handover documents and support period.', 'fa' => 'در صورت نیاز همه این موارد می‌تواند شامل باشد. محدوده نهایی باید محل‌ها، تجهیزات، تنظیمات، تست، پذیرش، آموزش، اسناد تحویل و مدت پشتیبانی را مشخص کند.', 'ps' => 'د اړتیا په صورت کې ټول شاملېدای شي. وروستی کاري حدود باید ځایونه، تجهیزات، تنظیمات، ازموینه، منل، روزنه، سپارلو اسناد او د ملاتړ موده مشخصه کړي.'],
            ),
            $this->faq(
                ['en' => 'How do we request a quotation?', 'fa' => 'چگونه درخواست قیمت ارسال کنیم؟', 'ps' => 'څنګه د نرخ غوښتنه واستوو؟'],
                ['en' => 'Use the Request for Quotation page and attach the RFQ, RFP, TOR, BoQ or technical specification if available. The system generates a reference number and sends the submission to info@fida.af.', 'fa' => 'از صفحه درخواست قیمت استفاده کنید و در صورت موجود بودن RFQ، RFP، TOR، BoQ یا مشخصات تخنیکی را ضمیمه نمایید. سیستم شماره مرجع ایجاد کرده و درخواست را به info@fida.af ارسال می‌کند.', 'ps' => 'د نرخ غوښتنې پاڼه وکاروئ او که موجود وي RFQ، RFP، TOR، BoQ یا تخنیکي مشخصات ورسره ضمیمه کړئ. سیسټم مرجع شمېره جوړوي او غوښتنه info@fida.af ته لېږي.'],
            ),
        ];

        return [
            'slug' => $item['slug'],
            'type' => 'solution',
            'title' => $item['title'],
            'eyebrow' => $item['eyebrow'],
            'summary' => $item['summary'],
            'body' => ['en' => $bodyEn, 'fa' => $bodyFa, 'ps' => $bodyPs],
            'meta_title' => [
                'en' => mb_substr($item['title']['en'].' | Fida Technologies', 0, 68),
                'fa' => mb_substr($item['title']['fa'].' | Fida Technologies', 0, 68),
                'ps' => mb_substr($item['title']['ps'].' | Fida Technologies', 0, 68),
            ],
            'meta_description' => $item['summary'],
            'primary_query' => $item['query'],
            'search_intent' => $procurement ? 'transactional' : 'commercial',
            'robots_directive' => config('website.discovery.default_robots'),
            'sitemap_included' => true,
            'sitemap_priority' => $procurement ? 0.9 : 0.8,
            'sitemap_change_frequency' => 'monthly',
            'metadata' => [
                'solution' => [
                    'outcomes' => ['en' => $procurement ? 'Procurement-ready delivery with one accountable technical partner.' : 'A maintainable solution aligned with the approved operational requirement.', 'fa' => 'تحویل قابل ارزیابی مطابق نیازمندی تأییدشده.', 'ps' => 'د تایید شوې اړتیا مطابق د ارزونې وړ سپارنه.'],
                    'control' => ['en' => 'Defined scope, configuration, acceptance, documentation and support responsibilities.', 'fa' => 'محدوده، تنظیمات، پذیرش، اسناد و مسئولیت‌های پشتیبانی مشخص.', 'ps' => 'روښانه حدود، تنظیمات، د منلو معیارونه، اسناد او د ملاتړ مسؤلیتونه.'],
                    'decisions' => ['en' => 'Architecture, quantities, brands, licensing and deployment choices remain traceable to the approved requirement.', 'fa' => 'معماری، مقدار، برند، لایسنس و انتخاب‌های تطبیق به نیازمندی تأییدشده مرتبط می‌ماند.', 'ps' => 'معماري، مقدار، برانډ، لایسنس او د پلي کولو انتخابونه له تایید شوې اړتیا سره تړلي پاتې کېږي.'],
                    'capabilities' => $item['capabilities'],
                ],
                'faqs' => $faqs,
                'related_slugs' => $procurement
                    ? ['request-for-quotation', 'data-center-it-infrastructure-afghanistan', 'systems-integration-deployment-afghanistan']
                    : ['government-ngo-technology-procurement-afghanistan', 'request-for-quotation', 'systems-integration-deployment-afghanistan'],
                'cta' => [
                    'heading' => ['en' => $procurement ? 'Send the RFQ, RFP or tender requirement.' : 'Need this capability in a formal project?', 'fa' => 'نیازمندی تخنیکی یا تدارکاتی خود را ارسال کنید.', 'ps' => 'خپله تخنیکي یا تدارکاتي اړتیا راولېږئ.'],
                    'description' => ['en' => 'For government, NGO and institutional procurement, submit the requirement and supporting documents for a structured review.', 'fa' => 'برای تدارکات دولتی، NGO و سازمانی، نیازمندی و اسناد را برای بررسی منظم ارسال کنید.', 'ps' => 'د دولت، NGO او سازماني تدارکاتو لپاره اړتیا او اسناد د منظمې ارزونې لپاره راولېږئ.'],
                    'primary_label' => ['en' => 'Submit an RFQ', 'fa' => 'ارسال RFQ', 'ps' => 'RFQ واستوئ'],
                    'primary_intent' => 'tender',
                ],
            ],
            'status' => 'published',
            'featured' => true,
            'sort_order' => $procurement ? 5 : 20,
            'published_at' => now(),
        ];
    }

    private function faq(array $question, array $answer): array
    {
        return compact('question', 'answer');
    }
}
