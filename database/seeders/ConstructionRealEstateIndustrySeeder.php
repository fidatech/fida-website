<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class ConstructionRealEstateIndustrySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->industries() as $industry) {
            ContentPage::query()->firstOrCreate(['slug' => $industry['slug']], $industry);
        }
    }

    private function industries(): array
    {
        return [
            $this->page(
                slug: 'construction-erp-software-afghanistan',
                title: [
                    'en' => 'Construction ERP Software in Afghanistan',
                    'fa' => 'نرم‌افزار ERP ساختمانی در افغانستان',
                    'ps' => 'په افغانستان کې د ساختماني ERP سافټویر',
                ],
                eyebrow: [
                    'en' => 'Project, site and financial control',
                    'fa' => 'کنترول پروژه، ساحه و امور مالی',
                    'ps' => 'د پروژې، ساحې او مالي چارو کنټرول',
                ],
                summary: [
                    'en' => 'Connect construction projects, procurement, materials, subcontractors, equipment, documents and project cost with controlled finance and management reporting.',
                    'fa' => 'پروژه‌های ساختمانی، تدارکات، مواد، قراردادیان فرعی، تجهیزات، اسناد و هزینه پروژه را با مالی و گزارش‌دهی کنترول‌شده وصل کنید.',
                    'ps' => 'ساختماني پروژې، تدارکات، مواد، فرعي قراردادیان، تجهیزات، اسناد او د پروژې لګښتونه له کنټرول شوو مالي چارو او راپورونو سره ونښلوئ.',
                ],
                body: [
                    'en' => <<<'HTML'
<h2>Construction ERP connects the site to the financial record</h2>
<p>Construction organizations often manage the same project through separate schedules, material sheets, purchase files, subcontractor records, site reports and accounting entries. A construction ERP should connect these records without removing the responsibilities of engineering, procurement, warehouse, project management and finance teams.</p>
<p>Fida Technologies can assess and configure an existing product path or develop a project-based system around the approved operating model. The right scope depends on whether the organization is a contractor, developer, project owner, consultant or a group managing several projects.</p>
<h2>Project structure, budgets and cost codes</h2>
<p>A controlled foundation can organize portfolios, projects, sites, contracts, phases, work packages, BOQ items, cost codes and approved budget versions. Actual transactions should be traceable to the correct project and cost classification so management can compare budget, commitments, actual cost and forecast without rebuilding reports manually.</p>
<ul><li>Project and site master data with responsible teams</li><li>Approved budgets, revisions and change history</li><li>Cost codes for materials, labor, equipment, subcontractors and overhead</li><li>Committed, received, invoiced and paid values</li><li>Project-level cash requirements and management reports</li></ul>
<h2>Procurement from material request to payment</h2>
<p>The procurement workflow may begin with a site material request and continue through technical review, quotation collection, comparison, approval, purchase order, delivery, inspection, receipt, invoice verification and payment authorization. Required steps and approval limits must be confirmed by the organization.</p>
<p>Every purchase should retain its project, supplier, items, quantities, terms and approval evidence. When an external accounting, procurement or donor system remains authoritative, approved APIs or controlled exchange files can be designed instead of duplicating ownership.</p>
<h2>Warehouses, site stores and material consumption</h2>
<ul><li>Central warehouse and project-site stores</li><li>Receipts, transfers, issues, returns and adjustments</li><li>Batch, unit and item classifications where required</li><li>Material issue against project, activity or cost code</li><li>Consumption, remaining balance and reconciliation reports</li></ul>
<p>Software can reveal differences between requested, purchased, received and issued quantities. Physical verification, inspection and approval remain operational responsibilities.</p>
<h2>Subcontractors, progress and change control</h2>
<p>A subcontractor workflow can record the approved agreement, scope, rates, work measurements, progress certificates, deductions, retention, advances, variations, claims and payment status. The system should not calculate contractual entitlement from an assumed rule; commercial, engineering, finance and legal owners must approve the governing method.</p>
<p>Change orders should keep the original request, technical assessment, cost and schedule impact, approval, revised value and links to affected documents. This provides a clearer project record when the approved scope changes.</p>
<h2>Equipment, field records and document control</h2>
<p>When included, equipment records may cover assignment, operating hours, fuel, maintenance, downtime and cost allocation. Field workflows may capture daily progress, labor, site instructions, inspections, quality observations, safety records and photographs. Document control can organize drawings, revisions, RFIs, submittals, correspondence and handover files with permissions and review history.</p>
<h2>Finance, approvals and auditability</h2>
<p>Construction operations should connect to an approved chart of accounts, supplier and subcontractor balances, project expenses, advances, payables, cash and bank records, assets and financial statements. Multi-currency handling can be designed around the accounting policy confirmed by finance.</p>
<ul><li>Role-based access by company, project, site and responsibility</li><li>Separation of preparation, review, approval and posting</li><li>Activity history for changes and sensitive transactions</li><li>Controlled document exports and attachments</li><li>Project dashboards with drill-down to source records</li></ul>
<h2>Implementation, migration and acceptance</h2>
<ol><li><strong>Discovery:</strong> map project, site, procurement, warehouse, subcontractor and finance workflows.</li><li><strong>Requirements:</strong> confirm data owners, approval limits, reports, integrations and deployment constraints.</li><li><strong>Configuration and delivery:</strong> build reviewable modules in agreed stages.</li><li><strong>Migration:</strong> clean and reconcile approved projects, suppliers, items, opening balances and documents.</li><li><strong>QA and UAT:</strong> test normal transactions, exceptions, permissions, reports and project reconciliation.</li><li><strong>Training and deployment:</strong> prepare each role, administrator, environment and support channel.</li></ol>
<p>Cloud or private-server deployment can be evaluated against connectivity, security, ownership, backup and access requirements. Scope-based support and SLA responsibilities are documented in the proposal.</p>
<h2>Discuss a construction ERP requirement</h2>
<p>Share the organization structure, active project types, current forms, approval chain, accounting environment, required reports and known integrations. Fida can then recommend a focused implementation, a phased ERP or a custom construction platform based on verified requirements.</p>
HTML,
                    'fa' => <<<'HTML'
<h2>ERP ساختمانی ساحه را به ثبت مالی وصل می‌کند</h2>
<p>شرکت‌های ساختمانی اغلب یک پروژه را با تقسیم اوقات جداگانه، شیت مواد، فایل خرید، اسناد قراردادی فرعی، گزارش ساحه و ثبت حسابداری مدیریت می‌کنند. ERP ساختمانی باید این اسناد را بدون حذف مسئولیت انجنیری، تدارکات، گدام، مدیریت پروژه و مالی باهم وصل کند.</p>
<p>Fida Technologies می‌تواند یک مسیر محصول موجود را ارزیابی و تنظیم کند یا سیستم پروژه‌محور مطابق مدل عملیاتی تأییدشده توسعه دهد. محدوده مناسب به نوع فعالیت شرکت به‌عنوان قراردادی، توسعه‌دهنده، مالک پروژه، مشاور یا گروه چندپروژه‌ای وابسته است.</p>
<h2>ساختار پروژه، بودجه و کودهای هزینه</h2>
<p>بنیاد کنترول‌شده می‌تواند پورتفولیو، پروژه، ساحه، قرارداد، مرحله، بسته کاری، اقلام BOQ، کود هزینه و نسخه‌های تأییدشده بودجه را تنظیم کند. هر معامله باید به پروژه و طبقه‌بندی هزینه درست وصل باشد تا بودجه، تعهد، هزینه واقعی و پیش‌بینی بدون ساخت دوباره گزارش مقایسه شود.</p>
<ul><li>معلومات اصلی پروژه و ساحه با تیم مسئول</li><li>بودجه تأییدشده، بازنگری و تاریخچه تغییر</li><li>کود هزینه برای مواد، نیروی کار، تجهیزات، قراردادی فرعی و مصارف عمومی</li><li>ارزش تعهدشده، دریافت‌شده، بل‌شده و پرداخت‌شده</li><li>نیاز نقدی پروژه و گزارش مدیریتی</li></ul>
<h2>تدارکات از درخواست مواد تا پرداخت</h2>
<p>روند تدارکات می‌تواند از درخواست مواد ساحه آغاز و با بررسی تخنیکی، جمع‌آوری نرخ، مقایسه، تأیید، سفارش خرید، تحویل، بررسی، رسید، تصدیق بل و اجازه پرداخت ادامه یابد. مراحل لازم و حدود صلاحیت باید توسط سازمان تأیید شود.</p>
<p>هر خرید باید پروژه، عرضه‌کننده، اقلام، مقدار، شرایط و شواهد تأییدی خود را حفظ کند. اگر سیستم حسابداری، تدارکاتی یا تمویل‌کننده مرجع باقی بماند، API تأییدشده یا فایل تبادله کنترول‌شده می‌تواند جای ثبت تکراری را بگیرد.</p>
<h2>گدام مرکزی، گدام ساحه و مصرف مواد</h2>
<ul><li>گدام مرکزی و ذخیره ساحه پروژه</li><li>رسید، انتقال، مصرف، برگشت و تعدیل</li><li>طبقه‌بندی بچ، واحد و جنس در صورت نیاز</li><li>مصرف مواد مطابق پروژه، فعالیت یا کود هزینه</li><li>گزارش مصرف، باقیمانده و مطابقت</li></ul>
<p>سیستم می‌تواند تفاوت میان مقدار درخواست‌شده، خریداری‌شده، دریافت‌شده و مصرف‌شده را روشن سازد. بررسی فزیکی، تفتیش و تأیید مسئولیت عملیاتی باقی می‌ماند.</p>
<h2>قراردادیان فرعی، پیشرفت و کنترول تغییر</h2>
<p>روند قراردادی فرعی می‌تواند قرارداد تأییدشده، محدوده، نرخ، اندازه‌گیری کار، تصدیق پیشرفت، کسر، تضمین، پیش‌پرداخت، تغییرات، ادعا و وضعیت پرداخت را ثبت کند. سیستم نباید حق قراردادی را بر اساس قاعده فرضی محاسبه کند؛ روش حاکم باید توسط مسئولان تجارتی، انجنیری، مالی و حقوقی تأیید شود.</p>
<p>امر تغییر باید درخواست اصلی، ارزیابی تخنیکی، اثر هزینه و زمان، تأیید، ارزش جدید و اسناد مرتبط را نگهدارد تا هنگام تغییر محدوده، سابقه پروژه روشن باشد.</p>
<h2>تجهیزات، ثبت ساحه و کنترول اسناد</h2>
<p>در صورت شامل بودن، ثبت تجهیزات می‌تواند تعیین ساحه، ساعت کار، تیل، ترمیم، توقف و تخصیص هزینه را پوشش دهد. روند ساحه می‌تواند پیشرفت روزانه، نیروی کار، هدایت ساحه، تفتیش، کیفیت، مصونیت و تصاویر را ثبت کند. کنترول اسناد می‌تواند نقشه، نسخه، RFI، submittal، مکاتبات و فایل تحویل را با صلاحیت و تاریخچه بررسی تنظیم کند.</p>
<h2>مالی، تأییدی و قابلیت بررسی</h2>
<p>عملیات ساختمانی باید به ساختار تأییدشده حساب‌ها، بیلانس عرضه‌کننده و قراردادی، مصارف پروژه، پیش‌پرداخت، حساب پرداختنی، نقد و بانک، دارایی و صورت‌های مالی وصل شود. مدیریت چندارزی مطابق پالیسی تأییدشده مالی طراحی می‌گردد.</p>
<ul><li>دسترسی مبتنی بر نقش مطابق شرکت، پروژه، ساحه و مسئولیت</li><li>تفکیک آماده‌سازی، بررسی، تأیید و ثبت نهایی</li><li>تاریخچه فعالیت برای تغییر و معامله حساس</li><li>خروجی و ضمیمه اسناد به‌صورت کنترول‌شده</li><li>داشبورد پروژه با دسترسی به ثبت منبع</li></ul>
<h2>تطبیق، انتقال معلومات و پذیرش</h2>
<ol><li><strong>شناخت:</strong> روند پروژه، ساحه، تدارکات، گدام، قراردادی فرعی و مالی ثبت می‌شود.</li><li><strong>نیازمندی:</strong> مالک معلومات، حدود تأیید، گزارش، یکپارچه‌سازی و محدودیت نصب تأیید می‌گردد.</li><li><strong>تنظیم و تحویل:</strong> ماژول‌ها در مراحل قابل بررسی ساخته می‌شود.</li><li><strong>انتقال:</strong> پروژه، عرضه‌کننده، جنس، بیلانس آغاز و اسناد تأییدشده پاک و مطابقت می‌شود.</li><li><strong>QA و UAT:</strong> معامله عادی، استثنا، صلاحیت، گزارش و مطابقت پروژه آزمایش می‌شود.</li><li><strong>آموزش و راه‌اندازی:</strong> هر نقش، ادمین، محیط و مسیر پشتیبانی آماده می‌گردد.</li></ol>
<p>نصب کلود یا سرور خصوصی مطابق اتصال، امنیت، مالکیت، بکاپ و دسترسی ارزیابی می‌شود. مسئولیت پشتیبانی و SLA در پیشنهاد پروژه مشخص می‌گردد.</p>
<h2>درباره نیاز ERP ساختمانی گفتگو کنید</h2>
<p>ساختار سازمان، نوع پروژه‌های فعال، فورم‌های فعلی، زنجیره تأیید، محیط حسابداری، گزارش‌های لازم و ادغام‌های شناخته‌شده را شریک سازید. سپس فدا می‌تواند تطبیق متمرکز، ERP مرحله‌ای یا پلتفرم ساختمانی اختصاصی را بر اساس نیاز واقعی پیشنهاد کند.</p>
HTML,
                    'ps' => <<<'HTML'
<h2>ساختماني ERP ساحه له مالي ثبت سره نښلوي</h2>
<p>ساختماني ادارې ډېر وخت یوه پروژه په جلا مهالوېشونو، د موادو جدولونو، پېرود فایلونو، فرعي قراردادي اسنادو، ساحوي راپورونو او حسابدارۍ ثبتونو اداره کوي. ساختماني ERP باید دا ثبتونه سره ونښلوي، خو د انجنیري، تدارکاتو، ګدام، پروژې مدیریت او مالي ټیم مسؤلیتونه باید روښانه وساتي.</p>
<p>Fida Technologies کولی شي د موجود محصول لاره وارزوي او تنظیم یې کړي، یا د تایید شوي عملیاتي ماډل مطابق د پروژې ځانګړی سیسټم جوړ کړي. مناسب حدود په دې پورې اړه لري چې اداره قراردادي، پراختیاکوونکې، د پروژې مالکه، مشاوره یا د څو پروژو ډله ده.</p>
<h2>د پروژې جوړښت، بودیجه او د لګښت کودونه</h2>
<p>کنټرول شوی بنسټ پورتفولیو، پروژې، ساحې، قراردادونه، پړاوونه، کاري بستې، د BOQ توکي، د لګښت کودونه او د بودیجې تایید شوې نسخې تنظیمولی شي. هره معامله باید له سمې پروژې او لګښت سره وتړل شي څو بودیجه، ژمن شوی لګښت، واقعي لګښت او اټکل پرتله شي.</p>
<ul><li>د پروژې او ساحې اصلي معلومات له مسؤل ټیم سره</li><li>تایید شوې بودیجه، بیاکتنه او د بدلون تاریخ</li><li>د موادو، کار، تجهیزاتو، فرعي قراردادیانو او عمومي مصارفو کودونه</li><li>ژمن شوی، ترلاسه شوی، بل شوی او تادیه شوی ارزښت</li><li>د پروژې نغدي اړتیا او مدیریتي راپورونه</li></ul>
<h2>له موادو غوښتنې تر تادیې تدارکات</h2>
<p>د تدارکاتو بهیر د ساحې له غوښتنې پیلېدای شي او تخنیکي کتنه، نرخونه، مقایسه، تایید، پېرود امر، تحویل، معاینه، رسید، د بل تصدیق او د تادیې اجازه پکې شاملېدای شي. اړین پړاوونه او د صلاحیت حدود باید اداره تایید کړي.</p>
<p>هر پېرود باید پروژه، عرضه کوونکی، توکي، مقدار، شرایط او د تایید شواهد وساتي. که بهرنی حسابداري، تدارکاتي یا تمویل کوونکي سیسټم مرجع وي، تایید شوي API یا کنټرول شوې تبادله کارول کېدای شي.</p>
<h2>مرکزي ګدام، ساحوي زېرمه او د موادو مصرف</h2>
<ul><li>مرکزي ګدام او د پروژې ساحوي زېرمه</li><li>رسید، انتقال، مصرف، بېرته ستنول او تعدیل</li><li>د اړتیا پر مهال د بچ، واحد او توکي طبقه‌بندي</li><li>پروژې، فعالیت یا لګښت کود ته د موادو ورکول</li><li>د مصرف، پاتې مقدار او مطابقت راپورونه</li></ul>
<p>سیسټم د غوښتل شوو، پېرودل شوو، ترلاسه شوو او مصرف شوو مقدارونو توپیر ښودلی شي. فزیکي کتنه، معاینه او تایید عملیاتي مسؤلیتونه دي.</p>
<h2>فرعي قراردادیان، پرمختګ او د بدلون کنټرول</h2>
<p>د فرعي قراردادي بهیر تایید شوی قرارداد، حدود، نرخونه، د کار اندازه، د پرمختګ تصدیق، کسرونه، تضمین، پیشکي، بدلونونه، ادعا او د تادیې حالت ثبتولی شي. سیسټم باید له فرضي قاعدې قراردادي حق ونه محاسبه کړي؛ سوداګریز، انجنیري، مالي او حقوقي مسؤلان یې باید طریقه تایید کړي.</p>
<p>د بدلون امر باید اصلي غوښتنه، تخنیکي ارزونه، د لګښت او وخت اغېز، تایید، نوی ارزښت او اړوند اسناد وساتي.</p>
<h2>تجهیزات، ساحوي ثبت او د اسنادو کنټرول</h2>
<p>که په حدودو کې وي، د تجهیزاتو ثبت د ساحې ټاکنه، کاري ساعتونه، تېل، ترمیم، درېدنه او د لګښت وېش پوښلی شي. ساحوي بهیر ورځنی پرمختګ، کارګر، ساحوي هدایت، معاینه، کیفیت، خوندیتوب او عکسونه ثبتولی شي. د اسنادو کنټرول نقشې، نسخې، RFI، submittal، مکتوبونه او د سپارلو فایلونه له صلاحیت او تاریخ سره تنظیموي.</p>
<h2>مالي چارې، تایید او audit</h2>
<p>ساختماني عملیات باید له تایید شوي chart of accounts، د عرضه کوونکو او قراردادیانو بیلانس، د پروژې مصارف، پیشکي، ورکړې، نغدي، بانک، شتمنۍ او مالي راپورونو سره وصل شي. څو اسعارو مدیریت د مالي ټیم د تایید شوې پالیسۍ مطابق طرحه کېږي.</p>
<ul><li>د شرکت، پروژې، ساحې او مسؤلیت مطابق رول-محور لاسرسی</li><li>د چمتو کولو، کتنې، تایید او وروستي ثبت جلاوالی</li><li>د بدلون او حساسو معاملو د فعالیت تاریخ</li><li>د اسنادو کنټرول شوی export او ضمیمې</li><li>د سرچینې ثبت ته د تګ وړ پروژوي ډشبورډ</li></ul>
<h2>پلي کول، د معلوماتو لېږد او منل</h2>
<ol><li><strong>پېژندنه:</strong> د پروژې، ساحې، تدارکاتو، ګدام، قراردادیانو او مالي چارو بهیرونه ثبتېږي.</li><li><strong>اړتیاوې:</strong> د معلوماتو مالک، د تایید حدود، راپورونه، ادغامونه او د نصب محدودیتونه تاییدېږي.</li><li><strong>تنظیم او سپارل:</strong> ماډیولونه په کتلو وړ پړاوونو کې جوړېږي.</li><li><strong>لېږد:</strong> تایید شوې پروژې، عرضه کوونکي، توکي، پرانیستې بیلانسونه او اسناد پاک او مطابق کېږي.</li><li><strong>QA او UAT:</strong> عادي معامله، استثنا، صلاحیت، راپور او د پروژې مطابقت ازمویل کېږي.</li><li><strong>روزنه او نصب:</strong> هر رول، اډمین، چاپېریال او د ملاتړ لاره چمتو کېږي.</li></ol>
<p>کلاوډ یا شخصي سرور د انټرنېټ، امنیت، مالکیت، بیک‌اپ او لاسرسي مطابق ارزول کېږي. ملاتړ او SLA په پروژه‌يي وړاندیز کې لیکل کېږي.</p>
<h2>د ساختماني ERP اړتیا شریکه کړئ</h2>
<p>د ادارې جوړښت، د فعالو پروژو ډول، اوسني فورمونه، د تایید لړۍ، حسابداري چاپېریال، اړین راپورونه او معلوم ادغامونه شریک کړئ. فدا به د تایید شوو اړتیاوو پر اساس متمرکز تطبیق، مرحله‌يي ERP یا ځانګړی ساختماني پلېټفارم وړاندیز کړي.</p>
HTML,
                ],
                metaTitle: [
                    'en' => 'Construction ERP Software Afghanistan | Fida Technologies',
                    'fa' => 'نرم‌افزار ERP ساختمانی افغانستان | Fida Technologies',
                    'ps' => 'ساختماني ERP سافټویر افغانستان | Fida Technologies',
                ],
                metaDescription: [
                    'en' => 'Construction ERP in Afghanistan for project cost, procurement, materials, subcontractors, equipment, documents, finance and controlled reporting.',
                    'fa' => 'ERP ساختمانی در افغانستان برای هزینه پروژه، تدارکات، مواد، قراردادی فرعی، تجهیزات، اسناد، مالی و گزارش‌دهی کنترول‌شده.',
                    'ps' => 'په افغانستان کې ساختماني ERP د پروژې لګښت، تدارکاتو، موادو، قراردادیانو، تجهیزاتو، اسنادو، مالي چارو او راپورونو لپاره.',
                ],
                primaryQuery: [
                    'en' => 'construction ERP Afghanistan',
                    'fa' => 'نرم‌افزار ERP ساختمانی در افغانستان',
                    'ps' => 'په افغانستان کې ساختماني ERP',
                ],
                secondaryTopics: [
                    'en' => ['construction software Afghanistan', 'project cost management', 'construction procurement software', 'contractor management system'],
                    'fa' => ['نرم‌افزار ساختمانی افغانستان', 'مدیریت هزینه پروژه', 'سیستم تدارکات ساختمانی'],
                    'ps' => ['ساختماني سافټویر افغانستان', 'د پروژې لګښت مدیریت', 'ساختماني تدارکاتي سیسټم'],
                ],
                profile: [
                    'operations' => ['en' => 'Projects, sites, procurement, materials, subcontractors, equipment and documents.', 'fa' => 'پروژه، ساحه، تدارکات، مواد، قراردادیان فرعی، تجهیزات و اسناد.', 'ps' => 'پروژې، ساحې، تدارکات، مواد، فرعي قراردادیان، تجهیزات او اسناد.'],
                    'control' => ['en' => 'Budgets, cost codes, approvals, commitments, actual cost and auditable changes.', 'fa' => 'بودجه، کود هزینه، تأییدی، تعهد، هزینه واقعی و تغییرات قابل بررسی.', 'ps' => 'بودیجه، د لګښت کود، تاییدونه، ژمنې، واقعي لګښت او د بدلون تاریخ.'],
                    'decisions' => ['en' => 'Project cash needs, procurement status, material position, cost variance and delivery risk.', 'fa' => 'نیاز نقدی پروژه، وضعیت تدارکات، موجودی مواد، تفاوت هزینه و خطر تحویل.', 'ps' => 'د پروژې نغدي اړتیا، د تدارکاتو حالت، مواد، د لګښت توپیر او د سپارلو خطر.'],
                    'capabilities' => [
                        ['en' => 'Project costing', 'fa' => 'هزینه پروژه', 'ps' => 'د پروژې لګښت'],
                        ['en' => 'Procurement', 'fa' => 'تدارکات', 'ps' => 'تدارکات'],
                        ['en' => 'Site inventory', 'fa' => 'موجودی ساحه', 'ps' => 'ساحوي موجودي'],
                        ['en' => 'Subcontractors', 'fa' => 'قراردادیان فرعی', 'ps' => 'فرعي قراردادیان'],
                        ['en' => 'Equipment', 'fa' => 'تجهیزات', 'ps' => 'تجهیزات'],
                        ['en' => 'Document control', 'fa' => 'کنترول اسناد', 'ps' => 'د اسنادو کنټرول'],
                        ['en' => 'Accounting', 'fa' => 'حسابداری', 'ps' => 'حسابداري'],
                        ['en' => 'Audit trails', 'fa' => 'تاریخچه بررسی', 'ps' => 'د فعالیت تاریخ'],
                    ],
                ],
                faqs: [
                    $this->faq(['en' => 'How is construction ERP different from project scheduling software?', 'fa' => 'ERP ساختمانی چه تفاوتی با نرم‌افزار تقسیم اوقات پروژه دارد؟', 'ps' => 'ساختماني ERP له پروژوي مهالوېش سافټویر سره څه توپیر لري؟'], ['en' => 'Scheduling focuses on activities and time. Construction ERP connects approved project structures to procurement, materials, subcontractors, equipment, cost, finance, documents and management controls. The two can be integrated when required.', 'fa' => 'تقسیم اوقات بر فعالیت و زمان تمرکز دارد. ERP ساختمانی ساختار پروژه را به تدارکات، مواد، قراردادی فرعی، تجهیزات، هزینه، مالی، اسناد و کنترول مدیریتی وصل می‌کند و در صورت نیاز با ابزار زمان‌بندی ادغام می‌شود.', 'ps' => 'مهالوېش پر فعالیت او وخت تمرکز کوي. ساختماني ERP پروژه له تدارکاتو، موادو، قراردادیانو، تجهیزاتو، لګښت، مالي چارو، اسنادو او کنټرول سره نښلوي او د اړتیا پر مهال له مهالوېش وسیلې سره ادغامېږي.']),
                    $this->faq(['en' => 'Can the system manage BOQ budgets and project cost?', 'fa' => 'آیا سیستم می‌تواند بودجه BOQ و هزینه پروژه را مدیریت کند؟', 'ps' => 'ایا سیسټم د BOQ بودیجه او د پروژې لګښت اداره کولی شي؟'], ['en' => 'It can be configured around approved BOQ items, cost codes, budget versions, commitments and actual transactions. The required costing and reporting rules must be confirmed during discovery.', 'fa' => 'سیستم می‌تواند مطابق اقلام BOQ، کود هزینه، نسخه بودجه، تعهد و معامله واقعی تنظیم شود. قواعد هزینه و گزارش باید در مرحله شناخت تأیید گردد.', 'ps' => 'سیسټم د تایید شوو BOQ توکو، لګښت کودونو، بودیجې نسخو، ژمنو او واقعي معاملو مطابق تنظیمېدای شي. د لګښت او راپور قواعد باید د پېژندنې پر مهال تایید شي.']),
                    $this->faq(['en' => 'Can one ERP support multiple projects and site stores?', 'fa' => 'آیا یک ERP چند پروژه و گدام ساحه را پشتیبانی می‌کند؟', 'ps' => 'ایا یو ERP څو پروژې او ساحوي ګدامونه اداره کولی شي؟'], ['en' => 'Yes, when the approved architecture includes company, project, site and warehouse dimensions with appropriate user permissions and consolidated reporting.', 'fa' => 'بلی، اگر معماری تأییدشده ابعاد شرکت، پروژه، ساحه و گدام را با صلاحیت کاربران و گزارش تلفیقی شامل سازد.', 'ps' => 'هو، که تایید شوې معماري د شرکت، پروژې، ساحې او ګدام کچې له سم صلاحیت او یوځای راپورونو سره ولري.']),
                    $this->faq(['en' => 'Can subcontractor certificates, retention and variations be tracked?', 'fa' => 'آیا تصدیق قراردادی، تضمین و تغییرات قابل پیگیری است؟', 'ps' => 'ایا د قراردادي تصدیقونه، تضمین او بدلونونه تعقیبېدای شي؟'], ['en' => 'They can be included when the contract structure, measurement method, approval responsibilities, deductions and payment rules are documented and approved by the responsible teams.', 'fa' => 'این موارد زمانی شامل می‌شود که ساختار قرارداد، روش اندازه‌گیری، مسئولیت تأیید، کسر و قواعد پرداخت توسط تیم مسئول مستند و تأیید گردد.', 'ps' => 'دا هغه وخت شاملېږي چې د قرارداد جوړښت، د کار اندازه، د تایید مسؤلیت، کسر او د تادیې قواعد د مسؤلو ټیمونو له خوا مستند او تایید شي.']),
                    $this->faq(['en' => 'Can existing construction records be migrated?', 'fa' => 'آیا اسناد موجود ساختمانی انتقال می‌شود؟', 'ps' => 'ایا موجود ساختماني اسناد لېږدول کېدای شي؟'], ['en' => 'Migration can include approved master data, open projects, suppliers, items, opening balances and selected documents after source quality, ownership, mapping and reconciliation requirements are reviewed.', 'fa' => 'پس از بررسی کیفیت منبع، مالکیت، نقشه و مطابقت، انتقال می‌تواند معلومات اصلی، پروژه باز، عرضه‌کننده، جنس، بیلانس آغاز و اسناد انتخابی را شامل کند.', 'ps' => 'د سرچینې کیفیت، مالکیت، نقشه او مطابقت له کتنې وروسته تایید شوي اصلي معلومات، پرانیستې پروژې، عرضه کوونکي، توکي، بیلانسونه او ټاکلي اسناد لېږدول کېدای شي.']),
                    $this->faq(['en' => 'How is construction ERP priced?', 'fa' => 'قیمت ERP ساختمانی چگونه تعیین می‌شود؟', 'ps' => 'د ساختماني ERP بیه څنګه ټاکل کېږي؟'], ['en' => 'Fida provides a scope-based quotation after reviewing modules, users, projects, integrations, migration, deployment, training and support requirements. No one numeric price fits every construction organization.', 'fa' => 'فدا پس از بررسی ماژول، کاربر، پروژه، ادغام، انتقال، نصب، آموزش و پشتیبانی، پیشنهاد مبتنی بر محدوده ارائه می‌کند. یک قیمت ثابت برای همه شرکت‌ها مناسب نیست.', 'ps' => 'فدا د ماډیولونو، کاروونکو، پروژو، ادغامونو، لېږد، نصب، روزنې او ملاتړ له کتنې وروسته د حدودو پر اساس نرخ ورکوي. یوه ثابته بیه ټولو ته مناسبه نه ده.']),
                ],
                relatedSlugs: ['erp-systems-afghanistan', 'erp-implementation-services-afghanistan', 'business-process-analysis-afghanistan', 'real-estate-construction-software-afghanistan', 'realist-real-estate-erp', 'accounting-software-afghanistan'],
                sortOrder: 3,
            ),
            $this->realEstatePage(),
        ];
    }

    private function realEstatePage(): array
    {
        return $this->page(
            slug: 'real-estate-erp-software-afghanistan',
            title: ['en' => 'Real Estate ERP Software in Afghanistan', 'fa' => 'نرم‌افزار ERP املاک در افغانستان', 'ps' => 'په افغانستان کې د املاکو ERP سافټویر'],
            eyebrow: ['en' => 'Property inventory, sales and collections', 'fa' => 'موجودی ملکیت، فروش و وصول', 'ps' => 'د ملکیت موجودي، پلور او راټولونه'],
            summary: ['en' => 'Manage property projects, buildings, units, reservations, contracts, payment schedules, collections and customer records in a controlled real estate platform.', 'fa' => 'پروژه املاک، تعمیر، واحد، ریزرف، قرارداد، جدول پرداخت، وصول و اسناد مشتری را در یک پلتفرم کنترول‌شده مدیریت کنید.', 'ps' => 'د املاکو پروژې، ودانۍ، واحدونه، ریزرف، قراردادونه، د تادیاتو مهالوېش، راټولونه او د مشتری اسناد په کنټرول شوي پلېټفارم کې اداره کړئ.'],
            body: [
                'en' => <<<'HTML'
<h2>Real estate ERP follows the property and customer lifecycle</h2><p>A property developer or real estate company needs more than a generic contact list. The system must understand the relationship between a project, building, floor, unit, availability status, customer, approved offer, contract, payment schedule, receipt and handover record.</p><p>Fida Technologies offers Realist ERP as a product path and can configure or extend the implementation around verified workflows. Final modules depend on whether the organization develops and sells property, manages rentals, operates mixed-use assets or combines construction and real estate operations.</p>
<h2>Property hierarchy and controlled availability</h2><ul><li>Projects, phases, buildings, floors, units, parking and other defined inventory</li><li>Unit type, area, attributes, price basis and document references</li><li>Available, held, reserved, contracted, handed over or cancelled states</li><li>Release rules and permissions for sales teams, branches or agents</li><li>History of status, price and responsible user changes</li></ul><p>Availability rules should prevent conflicting commitments while retaining an auditable history of authorized changes.</p>
<h2>From enquiry and reservation to approved contract</h2><p>A sales workflow can connect enquiries, follow-ups, selected units, quotations, reservations, deposits, discount requests, approval, contracts and supporting documents. Broker or agent involvement and commission rules can be included only after the organization approves the commercial policy.</p><p>Contract templates, required documents, signatures and legal conditions remain under the authority of the organization and its legal advisers. The system applies approved data and workflow rules; it does not create legal policy.</p>
<h2>Payment schedules, collections and customer statements</h2><p>Approved cash, installment or milestone schedules can generate customer obligations linked to the correct contract and unit. Receipts, adjustments, refunds, controlled cancellations and transfers should retain authorization and supporting evidence.</p><ul><li>Upcoming, due, paid, partly paid and overdue installments</li><li>Customer statements in approved transaction and reporting currencies</li><li>Collection queues, reminders and responsible follow-up</li><li>Receipt allocation and reconciliation with finance</li><li>Project, building, unit and customer collection reports</li></ul><p>Late fees, revenue recognition, tax and exchange-rate treatment must follow policies confirmed by authorized finance and legal teams.</p>
<h2>Finance and management visibility</h2><p>Where included, real estate operations can connect customer accounts, cash and bank receipts, advances, refunds, commissions, expenses, payables, project cost and financial statements. Managers can review availability, reservation expiry, sales pipeline, collections, overdue balances and approved performance indicators from controlled dashboards.</p>
<h2>Handover and property management are distinct workflows</h2><p>Development sales may continue through inspection, outstanding items, handover documents, keys and customer acceptance. Rental or property-management operations are different: they may require tenants, leases, recurring rent, service charges, maintenance requests, renewals and occupancy reporting. These modules should be scoped separately so the system reflects the actual business model.</p>
<h2>Roles, integrations and deployment</h2><ul><li>Role-based access for management, sales, collections, finance, legal and administrators</li><li>Approval thresholds for pricing, discounts, refunds and contract changes</li><li>Audit history for unit status, customer obligations and sensitive records</li><li>Approved integrations with websites, portals, accounting, payment or messaging services</li><li>English, Dari and Pashto interfaces when required</li><li>Cloud or private-server deployment based on approved architecture</li></ul>
<h2>Implementation and data migration</h2><ol><li><strong>Discovery:</strong> confirm the property model, sales policy, contract process, collection rules, currencies and reporting.</li><li><strong>Prototype:</strong> validate representative projects, units, reservations, contracts and payment schedules.</li><li><strong>Configuration:</strong> implement permissions, approvals, reports, documents and approved integrations.</li><li><strong>Migration:</strong> clean and reconcile property inventory, customers, active contracts, schedules and opening balances.</li><li><strong>UAT:</strong> test availability conflicts, discounts, receipts, cancellations, permissions and finance reconciliation.</li><li><strong>Training and launch:</strong> prepare users by role, production access, documentation and support channels.</li></ol>
<h2>Evaluate Realist ERP for your property operation</h2><p>Share the property structure, sales or rental model, current inventory records, contract workflow, payment schedules, currencies, required reports and existing systems. Fida can demonstrate the relevant Realist ERP workflow and prepare a scope-based proposal without publishing an invented fixed price.</p>
HTML,
                'fa' => <<<'HTML'
<h2>ERP املاک چرخه ملکیت و مشتری را دنبال می‌کند</h2><p>یک توسعه‌دهنده یا شرکت املاک به بیشتر از فهرست عمومی تماس‌ها نیاز دارد. سیستم باید رابطه میان پروژه، تعمیر، منزل، واحد، وضعیت موجودی، مشتری، پیشنهاد تأییدشده، قرارداد، جدول پرداخت، رسید و سند تحویل را درک کند.</p><p>Fida Technologies محصول Realist ERP را ارائه می‌کند و می‌تواند تطبیق آن را مطابق روندهای تأییدشده تنظیم یا توسعه دهد. ماژول نهایی به فعالیت سازمان در توسعه و فروش، کرایه، مدیریت ملکیت مختلط یا ترکیب ساختمان و املاک وابسته است.</p>
<h2>ساختار ملکیت و موجودی کنترول‌شده</h2><ul><li>پروژه، مرحله، تعمیر، منزل، واحد، پارکینگ و موجودی تعریف‌شده</li><li>نوع واحد، مساحت، مشخصات، اساس قیمت و اسناد مرجع</li><li>وضعیت موجود، نگهداری، ریزرف، قراردادشده، تحویل یا لغوشده</li><li>قواعد عرضه و صلاحیت تیم فروش، شعبه یا نماینده</li><li>تاریخچه تغییر وضعیت، قیمت و کاربر مسئول</li></ul><p>قواعد موجودی باید از تعهد متضاد جلوگیری و سابقه تغییرات مجاز را حفظ کند.</p>
<h2>از درخواست و ریزرف تا قرارداد تأییدشده</h2><p>روند فروش می‌تواند درخواست مشتری، پیگیری، واحد انتخابی، نرخ، ریزرف، پیش‌پرداخت، درخواست تخفیف، تأیید، قرارداد و اسناد را وصل کند. نقش بروکر یا نماینده و قواعد کمیشن تنها پس از تأیید پالیسی تجارتی شامل می‌گردد.</p><p>قالب قرارداد، اسناد لازم، امضا و شرایط حقوقی زیر مسئولیت سازمان و مشاور حقوقی آن است. سیستم قواعد تأییدشده را تطبیق می‌کند؛ پالیسی حقوقی ایجاد نمی‌کند.</p>
<h2>جدول پرداخت، وصول و صورت‌حساب مشتری</h2><p>جدول نقدی، قسطی یا مرحله‌ای تأییدشده می‌تواند تعهد مشتری را به قرارداد و واحد درست وصل کند. رسید، تعدیل، بازپرداخت، لغو کنترول‌شده و انتقال باید اجازه و شواهد را حفظ کند.</p><ul><li>اقساط آینده، واجب، پرداخت‌شده، قسمی و معوق</li><li>صورت‌حساب مشتری در ارز معامله و گزارش تأییدشده</li><li>فهرست وصول، یادآوری و مسئول پیگیری</li><li>تخصیص رسید و مطابقت با مالی</li><li>گزارش وصول مطابق پروژه، تعمیر، واحد و مشتری</li></ul><p>جریمه تأخیر، شناسایی عاید، مالیه و نرخ ارز باید از پالیسی تأییدشده مالی و حقوقی پیروی کند.</p>
<h2>دید مالی و مدیریتی</h2><p>در صورت شامل بودن، عملیات املاک می‌تواند حساب مشتری، رسید نقد و بانک، پیش‌پرداخت، بازپرداخت، کمیشن، مصرف، پرداختنی، هزینه پروژه و صورت‌های مالی را وصل کند. مدیریت می‌تواند موجودی، انقضای ریزرف، روند فروش، وصول و بیلانس معوق را از داشبورد کنترول‌شده بررسی کند.</p>
<h2>تحویل و مدیریت ملکیت دو روند جدا است</h2><p>فروش پروژه ممکن است با بررسی، موارد باقی، اسناد تحویل، کلید و پذیرش مشتری ادامه یابد. کرایه یا مدیریت ملکیت متفاوت است و می‌تواند مستأجر، قرارداد کرایه، کرایه تکراری، هزینه خدمات، درخواست ترمیم، تمدید و گزارش اشغال را نیاز داشته باشد. این ماژول‌ها باید جداگانه تعریف شود.</p>
<h2>صلاحیت، ادغام و نصب</h2><ul><li>دسترسی مبتنی بر نقش برای مدیریت، فروش، وصول، مالی، حقوقی و ادمین</li><li>حدود تأیید قیمت، تخفیف، بازپرداخت و تغییر قرارداد</li><li>تاریخچه بررسی وضعیت واحد، تعهد مشتری و اسناد حساس</li><li>ادغام تأییدشده با وب‌سایت، پورتال، حسابداری، پرداخت یا پیام‌رسان</li><li>رابط انگلیسی، دری و پشتو در صورت نیاز</li><li>نصب کلود یا سرور خصوصی مطابق معماری تأییدشده</li></ul>
<h2>تطبیق و انتقال معلومات</h2><ol><li><strong>شناخت:</strong> مدل ملکیت، پالیسی فروش، قرارداد، وصول، ارز و گزارش تأیید می‌شود.</li><li><strong>نمونه:</strong> پروژه، واحد، ریزرف، قرارداد و جدول پرداخت نمونه بررسی می‌گردد.</li><li><strong>تنظیم:</strong> صلاحیت، تأییدی، گزارش، اسناد و ادغام تأییدشده تطبیق می‌شود.</li><li><strong>انتقال:</strong> موجودی ملکیت، مشتری، قرارداد فعال، جدول و بیلانس آغاز پاک و مطابقت می‌گردد.</li><li><strong>UAT:</strong> تضاد موجودی، تخفیف، رسید، لغو، صلاحیت و مطابقت مالی آزمایش می‌شود.</li><li><strong>آموزش و نشر:</strong> کاربران مطابق نقش، دسترسی اصلی، اسناد و پشتیبانی آماده می‌گردد.</li></ol>
<h2>Realist ERP را برای عملیات املاک ارزیابی کنید</h2><p>ساختار ملکیت، مدل فروش یا کرایه، اسناد موجودی، روند قرارداد، جدول پرداخت، ارز، گزارش و سیستم فعلی را شریک سازید. فدا می‌تواند روند مرتبط Realist ERP را نمایش و پیشنهاد مبتنی بر محدوده تهیه کند.</p>
HTML,
                'ps' => <<<'HTML'
<h2>د املاکو ERP د ملکیت او مشتری بشپړ ژوندڅرخ تعقیبوي</h2><p>د املاکو پراختیاکوونکی یا شرکت یوازې عمومي تماس‌لست ته اړتیا نه لري. سیسټم باید د پروژې، ودانۍ، پوړ، واحد، موجود حالت، مشتری، تایید شوي وړاندیز، قرارداد، د تادیاتو مهالوېش، رسید او سپارلو ترمنځ اړیکه وپېژني.</p><p>Fida Technologies د Realist ERP محصول وړاندې کوي او د تایید شوو بهیرونو مطابق یې تنظیم یا پراخولی شي. وروستي ماډیولونه په دې پورې اړه لري چې اداره ملکیت جوړوي او پلوري، کرایه اداره کوي، ګډ ملکیت چلوي یا ساختماني او املاکي عملیات یوځای لري.</p>
<h2>د ملکیت جوړښت او کنټرول شوې موجودي</h2><ul><li>پروژې، پړاوونه، ودانۍ، پوړونه، واحدونه، پارکینګ او ټاکلې موجودي</li><li>د واحد ډول، مساحت، ځانګړنې، د بیې اساس او اړوند اسناد</li><li>موجود، ساتل شوی، ریزرف، قرارداد شوی، سپارل شوی یا لغوه شوی حالت</li><li>د پلور ټیم، څانګې یا استازي د عرضه کولو قواعد او صلاحیت</li><li>د حالت، بیې او مسؤل کاروونکي د بدلون تاریخ</li></ul><p>د موجودۍ قواعد باید د متضادو ژمنو مخه ونیسي او د مجاز بدلون تاریخ وساتي.</p>
<h2>له غوښتنې او ریزرف تر تایید شوي قرارداد</h2><p>د پلور بهیر د مشتری غوښتنه، تعقیب، ټاکلی واحد، نرخ، ریزرف، پیشکي، د تخفیف غوښتنه، تایید، قرارداد او اسناد سره نښلوي. د بروکر یا استازي ونډه او کمیشن یوازې د سوداګریزې پالیسۍ له تایید وروسته شاملېږي.</p><p>د قرارداد نمونه، اړین اسناد، لاسلیک او حقوقي شرایط د ادارې او حقوقي سلاکار مسؤلیت دی. سیسټم تایید شوي قواعد پلي کوي؛ حقوقي پالیسي نه جوړوي.</p>
<h2>د تادیاتو مهالوېش، راټولونه او د مشتری حساب‌لیک</h2><p>تایید شوی نغدي، قسطي یا مرحله‌يي مهالوېش د مشتری مکلفیت له سم قرارداد او واحد سره نښلوي. رسیدونه، تعدیل، بېرته ورکړه، کنټرول شوې لغوه او انتقال باید اجازه او شواهد وساتي.</p><ul><li>راتلونکي، واجب، تادیه شوي، قسمی او ځنډېدلي قسطونه</li><li>د تایید شوو معاملاتي او راپور اسعارو حساب‌لیک</li><li>د راټولولو لست، یادونې او مسؤل تعقیب</li><li>د رسید تخصیص او له مالي چارو سره مطابقت</li><li>د پروژې، ودانۍ، واحد او مشتری د راټولولو راپور</li></ul><p>د ځنډ جریمه، د عاید پېژندنه، مالیه او د اسعارو نرخ باید د مالي او حقوقي ټیم له تایید شوې پالیسۍ سره برابر وي.</p>
<h2>مالي او مدیریتي لید</h2><p>که شامل وي، املاکي عملیات د مشتری حسابونه، نغدي او بانکي رسیدونه، پیشکي، بېرته ورکړه، کمیشن، مصارف، ورکړې، د پروژې لګښت او مالي راپورونه سره نښلوي. مدیریت موجودي، د ریزرف پای، د پلور لړۍ، راټولونه او پاتې بیلانس له کنټرول شوي ډشبورډه کتلی شي.</p>
<h2>سپارل او د ملکیت مدیریت جلا بهیرونه دي</h2><p>د پراختیا پلور تر معاینې، پاتې کارونو، سپارلو اسنادو، کلیو او د مشتری منلو پورې روانېدای شي. کرایه یا د ملکیت مدیریت جلا دی او مستأجر، اجاره، تکراري کرایه، خدماتي فیس، د ترمیم غوښتنه، تمدید او د اشغال راپور غواړي. دا ماډیولونه باید جلا تعریف شي.</p>
<h2>صلاحیتونه، ادغامونه او نصب</h2><ul><li>د مدیریت، پلور، راټولولو، مالي، حقوقي او اډمین لپاره رول-محور لاسرسی</li><li>د بیې، تخفیف، بېرته ورکړې او قرارداد بدلون د تایید حدود</li><li>د واحد حالت، مشتری مکلفیت او حساسو اسنادو تاریخ</li><li>له وېب‌سایټ، پورټل، حسابدارۍ، تادیې یا پیغام خدمت سره تایید شوی ادغام</li><li>د اړتیا پر مهال انګلیسي، دري او پښتو انترفېس</li><li>د تایید شوې معمارۍ مطابق کلاوډ یا شخصي سرور</li></ul>
<h2>پلي کول او د معلوماتو لېږد</h2><ol><li><strong>پېژندنه:</strong> د ملکیت ماډل، د پلور پالیسي، قرارداد، راټولونه، اسعار او راپورونه تاییدېږي.</li><li><strong>نمونه:</strong> استازي پروژې، واحدونه، ریزرفونه، قراردادونه او د تادیاتو مهالوېش کتل کېږي.</li><li><strong>تنظیم:</strong> صلاحیتونه، تاییدونه، راپورونه، اسناد او منظور ادغامونه پلي کېږي.</li><li><strong>لېږد:</strong> د ملکیت موجودي، مشتریان، فعال قراردادونه، مهالوېش او پرانیستي بیلانسونه پاک او مطابق کېږي.</li><li><strong>UAT:</strong> د موجودۍ ټکر، تخفیف، رسید، لغوه، صلاحیت او مالي مطابقت ازمویل کېږي.</li><li><strong>روزنه او نشر:</strong> کاروونکي د رول مطابق، اصلي لاسرسی، اسناد او ملاتړ چمتو کېږي.</li></ol>
<h2>Realist ERP د خپل املاکي کار لپاره وارزوئ</h2><p>د ملکیت جوړښت، د پلور یا کرایې ماډل، د موجودۍ اسناد، قرارداد بهیر، د تادیاتو مهالوېش، اسعار، راپورونه او اوسني سیسټمونه شریک کړئ. فدا کولی شي د Realist ERP اړوند بهیر وښيي او د حدودو پر اساس وړاندیز برابر کړي.</p>
HTML,
            ],
            metaTitle: ['en' => 'Real Estate ERP Software Afghanistan | Realist ERP', 'fa' => 'نرم‌افزار ERP املاک افغانستان | Realist ERP', 'ps' => 'د املاکو ERP سافټویر افغانستان | Realist ERP'],
            metaDescription: ['en' => 'Real estate ERP in Afghanistan for property inventory, reservations, contracts, installments, collections, customer accounts and controlled reporting.', 'fa' => 'ERP املاک در افغانستان برای موجودی ملکیت، ریزرف، قرارداد، اقساط، وصول، حساب مشتری و گزارش‌دهی کنترول‌شده.', 'ps' => 'په افغانستان کې د املاکو ERP د ملکیت موجودۍ، ریزرف، قراردادونو، قسطونو، راټولونو، مشتری حساب او راپورونو لپاره.'],
            primaryQuery: ['en' => 'real estate ERP Afghanistan', 'fa' => 'نرم‌افزار ERP املاک در افغانستان', 'ps' => 'په افغانستان کې د املاکو ERP'],
            secondaryTopics: ['en' => ['real estate software Afghanistan', 'property management system Afghanistan', 'real estate installment software', 'property sales ERP'], 'fa' => ['نرم‌افزار املاک افغانستان', 'سیستم مدیریت ملکیت', 'نرم‌افزار اقساط املاک'], 'ps' => ['د املاکو سافټویر افغانستان', 'د ملکیت مدیریت سیسټم', 'د املاکو د قسطونو سافټویر']],
            profile: [
                'operations' => ['en' => 'Projects, buildings, units, customers, reservations, contracts, collections and handover.', 'fa' => 'پروژه، تعمیر، واحد، مشتری، ریزرف، قرارداد، وصول و تحویل.', 'ps' => 'پروژې، ودانۍ، واحدونه، مشتریان، ریزرف، قراردادونه، راټولونه او سپارل.'],
                'control' => ['en' => 'Availability, pricing approvals, payment schedules, receipts, documents and role-based access.', 'fa' => 'موجودی، تأیید قیمت، جدول پرداخت، رسید، اسناد و دسترسی مبتنی بر نقش.', 'ps' => 'موجودي، د بیې تایید، د تادیاتو مهالوېش، رسیدونه، اسناد او رول-محور لاسرسی.'],
                'decisions' => ['en' => 'Sales pipeline, available inventory, upcoming collections, overdue balances and customer position.', 'fa' => 'روند فروش، موجودی قابل عرضه، وصول آینده، بیلانس معوق و وضعیت مشتری.', 'ps' => 'د پلور لړۍ، موجود واحدونه، راتلونکي راټولونه، پاتې بیلانس او د مشتری حالت.'],
                'capabilities' => [
                    ['en' => 'Unit inventory', 'fa' => 'موجودی واحد', 'ps' => 'د واحدونو موجودي'],
                    ['en' => 'Reservations', 'fa' => 'ریزرف', 'ps' => 'ریزرف'],
                    ['en' => 'Contracts', 'fa' => 'قرارداد', 'ps' => 'قراردادونه'],
                    ['en' => 'Installments', 'fa' => 'اقساط', 'ps' => 'قسطونه'],
                    ['en' => 'Collections', 'fa' => 'وصول', 'ps' => 'راټولونه'],
                    ['en' => 'Customer statements', 'fa' => 'صورت‌حساب مشتری', 'ps' => 'د مشتری حساب‌لیک'],
                    ['en' => 'Handover', 'fa' => 'تحویل', 'ps' => 'سپارل'],
                    ['en' => 'Realist ERP', 'fa' => 'Realist ERP', 'ps' => 'Realist ERP'],
                ],
            ],
            faqs: [
                $this->faq(['en' => 'Is real estate sales ERP the same as property management software?', 'fa' => 'آیا ERP فروش املاک با نرم‌افزار مدیریت ملکیت یکسان است؟', 'ps' => 'ایا د املاکو پلور ERP او د ملکیت مدیریت یو شان دي؟'], ['en' => 'No. Development sales focuses on inventory, reservations, contracts, installments, collections and handover. Property management may focus on leases, tenants, rent, service charges and maintenance. An implementation can include either or both after the scope is confirmed.', 'fa' => 'خیر. فروش پروژه بر موجودی، ریزرف، قرارداد، اقساط، وصول و تحویل تمرکز دارد. مدیریت ملکیت می‌تواند بر کرایه، مستأجر، خدمات و ترمیم تمرکز کند. پس از تأیید محدوده، یکی یا هر دو شامل می‌شود.', 'ps' => 'نه. د پراختیا پلور پر موجودۍ، ریزرف، قراردادونو، قسطونو، راټولونو او سپارلو تمرکز کوي. د ملکیت مدیریت اجاره، مستأجر، خدمات او ترمیم اداره کوي. د حدودو له تایید وروسته یو یا دواړه شاملېدای شي.']),
                $this->faq(['en' => 'Can Realist ERP manage multiple projects, buildings and units?', 'fa' => 'آیا Realist ERP چند پروژه، تعمیر و واحد را مدیریت می‌کند؟', 'ps' => 'ایا Realist ERP څو پروژې، ودانۍ او واحدونه اداره کوي؟'], ['en' => 'Realist ERP can be configured around a hierarchy of projects, buildings, floors and units with controlled availability, user permissions and reporting based on the approved implementation.', 'fa' => 'Realist ERP مطابق سلسله پروژه، تعمیر، منزل و واحد با موجودی کنترول‌شده، صلاحیت کاربر و گزارش‌دهی در تطبیق تأییدشده تنظیم می‌شود.', 'ps' => 'Realist ERP د پروژو، ودانیو، پوړونو او واحدونو د سلسلې مطابق له کنټرول شوې موجودۍ، صلاحیتونو او راپورونو سره تنظیمېدای شي.']),
                $this->faq(['en' => 'Can it handle installment schedules and multiple currencies?', 'fa' => 'آیا جدول اقساط و چند ارز را پشتیبانی می‌کند؟', 'ps' => 'ایا د قسطونو مهالوېش او څو اسعار اداره کوي؟'], ['en' => 'Payment schedules and multi-currency customer records can be included. Exchange rates, accounting treatment and reporting currency rules must be approved by the finance team.', 'fa' => 'جدول پرداخت و اسناد چندارزی مشتری می‌تواند شامل شود. نرخ ارز، روش حسابداری و ارز گزارش باید توسط تیم مالی تأیید گردد.', 'ps' => 'د تادیاتو مهالوېش او څو اسعارو د مشتری ثبت شاملېدای شي. د اسعارو نرخ، حسابداري او راپور قواعد باید مالي ټیم تایید کړي.']),
                $this->faq(['en' => 'Can customer documents and statements be kept with the unit?', 'fa' => 'آیا اسناد و صورت‌حساب مشتری با واحد نگهداری می‌شود؟', 'ps' => 'ایا د مشتری اسناد او حساب‌لیک له واحد سره ساتل کېږي؟'], ['en' => 'Yes, the approved workflow can connect customer records, contract documents, payment obligations, receipts and statements to the relevant property while applying permissions to sensitive information.', 'fa' => 'بلی، روند تأییدشده می‌تواند اسناد مشتری، قرارداد، تعهد پرداخت، رسید و صورت‌حساب را با ملکیت مربوط وصل و بر معلومات حساس صلاحیت تطبیق کند.', 'ps' => 'هو، تایید شوی بهیر د مشتری ثبت، قرارداد، د تادیې مکلفیت، رسید او حساب‌لیک له اړوند ملکیت سره نښلوي او حساسو معلوماتو ته صلاحیت ټاکي.']),
                $this->faq(['en' => 'Can existing unit, customer and contract data be migrated?', 'fa' => 'آیا معلومات موجود واحد، مشتری و قرارداد انتقال می‌شود؟', 'ps' => 'ایا د واحد، مشتری او قرارداد موجود معلومات لېږدول کېږي؟'], ['en' => 'Migration can be planned after the source files, identifiers, duplicates, contract status, balances and reconciliation responsibilities are reviewed. Only approved data should enter production.', 'fa' => 'انتقال پس از بررسی فایل منبع، شناسه، تکرار، وضعیت قرارداد، بیلانس و مسئولیت مطابقت پلان می‌شود. تنها معلومات تأییدشده وارد سیستم اصلی می‌گردد.', 'ps' => 'لېږد د سرچینې فایلونو، پېژندپاڼو، تکرارونو، قرارداد حالت، بیلانس او مطابقت مسؤلیت له کتنې وروسته پلان کېږي. یوازې تایید شوي معلومات اصلي سیسټم ته ځي.']),
                $this->faq(['en' => 'How is a Realist ERP implementation priced?', 'fa' => 'قیمت تطبیق Realist ERP چگونه تعیین می‌شود؟', 'ps' => 'د Realist ERP د پلي کولو بیه څنګه ټاکل کېږي؟'], ['en' => 'The quotation depends on the property model, modules, users, documents, approvals, migration, integrations, deployment, training and support. Fida prepares a written scope-based proposal after discovery.', 'fa' => 'قیمت به مدل ملکیت، ماژول، کاربر، اسناد، تأییدی، انتقال، ادغام، نصب، آموزش و پشتیبانی وابسته است. فدا پس از شناخت پیشنهاد کتبی مبتنی بر محدوده تهیه می‌کند.', 'ps' => 'بیه د ملکیت ماډل، ماډیولونو، کاروونکو، اسنادو، تاییدونو، لېږد، ادغامونو، نصب، روزنې او ملاتړ پورې تړلې ده. فدا له پېژندنې وروسته لیکلی وړاندیز ورکوي.']),
            ],
            relatedSlugs: ['realist-real-estate-erp', 'erp-systems-afghanistan', 'real-estate-construction-software-afghanistan', 'accounting-software-afghanistan', 'erp-implementation-services-afghanistan', 'construction-erp-software-afghanistan'],
            sortOrder: 4,
        );
    }

    private function page(string $slug, array $title, array $eyebrow, array $summary, array $body, array $metaTitle, array $metaDescription, array $primaryQuery, array $secondaryTopics, array $profile, array $faqs, array $relatedSlugs, int $sortOrder): array
    {
        return [
            'type' => 'industry', 'slug' => $slug, 'title' => $title, 'eyebrow' => $eyebrow,
            'summary' => $summary, 'body' => $body, 'meta_title' => $metaTitle,
            'meta_description' => $metaDescription, 'primary_query' => $primaryQuery,
            'search_intent' => 'commercial',
            'robots_directive' => config('website.discovery.default_robots'),
            'sitemap_included' => true, 'sitemap_priority' => 0.9,
            'sitemap_change_frequency' => 'monthly',
            'metadata' => ['industry' => $profile, 'secondary_topics' => $secondaryTopics, 'faqs' => $faqs, 'related_slugs' => $relatedSlugs],
            'status' => 'published', 'featured' => true, 'sort_order' => $sortOrder, 'published_at' => now(),
        ];
    }

    private function faq(array $question, array $answer): array
    {
        return compact('question', 'answer');
    }
}
