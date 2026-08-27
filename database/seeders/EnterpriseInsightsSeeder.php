<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class EnterpriseInsightsSeeder extends Seeder
{
    public function run(): void
    {
        $planningCategoryId = ArticleCategory::query()
            ->where('slug', 'business-software-planning')
            ->value('id');

        $securityCategory = ArticleCategory::query()->firstOrCreate(
            ['slug' => 'software-security-resilience'],
            [
                'name' => [
                    'en' => 'Software Security & Resilience',
                    'fa' => 'امنیت و تاب‌آوری نرم‌افزار',
                    'ps' => 'د سافټویر امنیت او پایښت',
                ],
                'description' => [
                    'en' => 'Practical guidance for specifying, verifying and operating secure business software.',
                    'fa' => 'راهنمای عملی برای تعیین، ارزیابی و بهره‌برداری امن نرم‌افزار تجارتی.',
                    'ps' => 'د خوندي سوداګریز سافټویر د اړتیا، تایید او عملیاتو عملي لارښود.',
                ],
                'meta_title' => [
                    'en' => 'Software Security & Resilience Insights | Fida',
                    'fa' => 'راهنماهای امنیت و تاب‌آوری نرم‌افزار | فیدا',
                    'ps' => 'د سافټویر امنیت او پایښت لارښودونه | فیدا',
                ],
                'meta_description' => [
                    'en' => 'Multilingual guidance for software security requirements, verification, hosting, recovery and operational responsibility.',
                    'fa' => 'راهنمای چندزبانه نیازمندی امنیت، ارزیابی، میزبانی، بازیابی و مسئولیت عملیاتی نرم‌افزار.',
                    'ps' => 'د سافټویر د امنیت اړتیاوو، تایید، کوربه‌توب، رغونې او عملیاتي مسؤلیت څوژبی لارښود.',
                ],
                'active' => true,
                'sort_order' => 30,
            ],
        );

        foreach ($this->articles($planningCategoryId, $securityCategory->id) as $article) {
            ContentPage::query()->firstOrCreate(['slug' => $article['slug']], $article);
        }
    }

    private function articles(?int $planningCategoryId, int $securityCategoryId): array
    {
        return [
            $this->article(
                slug: 'erp-procurement-tender-guide-afghanistan',
                categoryId: $planningCategoryId,
                title: [
                    'en' => 'ERP Procurement & Tender Guide for Organizations in Afghanistan',
                    'fa' => 'راهنمای تدارکات و داوطلبی ERP برای سازمان‌ها در افغانستان',
                    'ps' => 'په افغانستان کې د ادارو لپاره د ERP تدارکاتو او داوطلبۍ لارښود',
                ],
                eyebrow: [
                    'en' => 'Enterprise software procurement guide',
                    'fa' => 'راهنمای تدارکات نرم‌افزار سازمانی',
                    'ps' => 'د اداري سافټویر تدارکاتي لارښود',
                ],
                summary: [
                    'en' => 'Build an ERP solicitation around measurable workflows, evidence, implementation duties, security, total cost and acceptance—not a generic feature list.',
                    'fa' => 'درخواست ERP را بر روندهای قابل سنجش، شواهد، مسئولیت تطبیق، امنیت، هزینه کامل و پذیرش بنا کنید؛ نه بر فهرست عمومی امکانات.',
                    'ps' => 'د ERP غوښتنه پر سنجېدونکو بهیرونو، شواهدو، د پلي کولو مسؤلیتونو، امنیت، ټول لګښت او منلو جوړه کړئ؛ نه پر عمومي فیچر لست.',
                ],
                body: [
                    'en' => <<<'HTML'
<h2>ERP procurement starts with an operating problem, not a product name</h2><p>An ERP tender should explain which decisions, records and controls need to improve. “Finance, HR and inventory” is not enough: bidders need to understand the organizations, locations, users, approval levels, currencies, reports, integrations, data sources and operating constraints inside the intended scope.</p><p>The issuing organization remains responsible for its procurement method, applicable law or donor rules, evaluation authority and final contract. This guide is a planning aid, not a substitute for those requirements.</p>
<h2>1. Establish governance before drafting the solicitation</h2><ul><li>Name the procurement owner, business sponsor, process owners, technical reviewers and authorized approver.</li><li>Record the procurement objective, budget authority, target decision and material dependencies.</li><li>Define how clarification, addenda, conflicts of interest, confidentiality and bidder communication will be handled.</li><li>Separate people who prepare requirements, evaluate responses and authorize the award where the applicable rules require it.</li></ul><p>A small decision group with written authority is more useful than a long participant list without ownership.</p>
<h2>2. Describe outcomes and representative workflows</h2><p>Translate broad module names into end-to-end scenarios. A procurement workflow might run from request through approval, quotation, purchase order, receipt, invoice, payment and accounting. A payroll workflow might include attendance inputs, approved adjustments, calculation, review, payment and posting.</p><p>For each scenario, identify roles, required data, approval boundaries, exceptions, outputs and acceptance evidence. This gives evaluators something concrete to compare during written review and demonstration.</p>
<h2>3. Build a traceable requirements matrix</h2><p>Give every material requirement an identifier and classify it using the organization’s approved method. Ask bidders to answer with one controlled status such as standard capability, configuration, custom development, third-party dependency, future roadmap or exception.</p><ul><li>Functional workflows, validations, approvals and reports</li><li>Roles, segregation of duties and activity history</li><li>Languages, RTL behavior, branches, units and currencies</li><li>Data migration, integrations and external dependencies</li><li>Availability, performance, accessibility and supported devices</li><li>Security, privacy, retention, backup and recovery</li><li>Training, documentation, deployment, support and exit requirements</li></ul><p>A “yes” without explanation or evidence should not be treated as equivalent to a demonstrated, contractually included capability.</p>
<h2>4. State the implementation responsibility matrix</h2><p>The solicitation should distinguish supplier work, client work and shared work. Typical responsibilities include process confirmation, source-data ownership, cleaning, configuration decisions, integration access, test scenarios, UAT, training attendance, infrastructure, cutover approval and support contacts.</p><p>Dates become credible only when the dependencies and decision deadlines on both sides are visible. A bidder cannot responsibly guarantee migration quality when the source data, owner and validation method are unknown.</p>
<h2>5. Request security evidence proportionate to risk</h2><p>Describe data sensitivity, privileged actions, user populations, locations, internet exposure, uptime and recovery needs. Ask how the proposed team controls source access, changes, dependencies, secrets, environments, testing, releases, logging, incidents and vulnerability handling.</p><p>Do not turn a framework name into an automatic certification claim. The evidence, scope and responsible party must be clear. Security obligations should continue through implementation, hosting, maintenance and exit—not end with the proposal.</p>
<h2>6. Compare total evaluated responsibility, not only licence price</h2><p>Request a price structure that makes comparison possible. Depending on the procurement, this can include licences or subscriptions, implementation, configuration, custom work, migration, integrations, infrastructure, travel, training, taxes, support, renewals and optional items.</p><p>Record commercial assumptions: user counts, environments, data volumes, service hours, currencies, payment milestones, price validity and change-control rules. Lowest initial price and lowest evaluated cost are not automatically the same.</p>
<h2>7. Use demonstrations as controlled evidence</h2><p>Give shortlisted bidders the same representative scenarios, sample roles and evaluation time. Require them to distinguish existing capability from configuration, proposed development and third-party services. Record unanswered questions and written clarifications through the authorized procurement channel.</p><p>A polished generic presentation is not evidence that the proposed scope can perform the organization’s transactions, controls and reports.</p>
<h2>8. Define acceptance and contract boundaries before award</h2><ul><li>Deliverables and reviewable stages</li><li>Requirements baseline and change procedure</li><li>Migration scope and reconciliation evidence</li><li>Test environments, defect classification and UAT authority</li><li>Cutover, rollback, handover and documentation</li><li>Data ownership, export, licences and intellectual-property terms</li><li>Warranty, support, SLA measurement, renewal and termination</li></ul><p>Evaluation promises that matter should be reflected in the signed scope or contract. Marketing language that never becomes a deliverable cannot be accepted objectively.</p>
<h2>A practical tender pack</h2><p>A complete pack commonly contains instructions, background, scope, workflow scenarios, requirements matrix, data and integration overview, security expectations, implementation responsibilities, deliverables, evaluation method, response format, commercial schedule, contract conditions and an authorized clarification process.</p>
<h2>Primary guidance used for this article</h2><p>The structure was cross-checked against the <a href="https://documents.worldbank.org/en/publication/documents-reports/documentdetail/099120102072534901">World Bank Procurement Regulations for IPF Borrowers, sixth edition</a> and its current <a href="https://documents.worldbank.org/en/publication/documents-reports/documentdetail/099325208202512194">guidance on evaluating bids and proposals</a>. Those documents apply only where their governing framework says they apply; every organization must follow its own current legal, donor and internal procurement rules.</p>
HTML,
                    'fa' => <<<'HTML'
<h2>تدارک ERP از مشکل عملیاتی آغاز می‌شود، نه از نام محصول</h2><p>داوطلبی ERP باید روشن سازد کدام تصمیم، ثبت و کنترول باید بهتر شود. نوشتن «مالی، منابع بشری و گدام» کافی نیست؛ داوطلب باید واحدها، موقعیت‌ها، کاربران، سطوح تأیید، اسعار، گزارش‌ها، ادغام‌ها، منابع معلومات و محدودیت‌های عملیاتی داخل محدوده را بداند.</p><p>نهاد صادرکننده مسئول روش تدارکات، قانون یا قواعد تمویل‌کننده، صلاحیت ارزیابی و قرارداد نهایی است. این راهنما ابزار پلان‌گذاری است و جای آن الزامات را نمی‌گیرد.</p>
<h2>۱. پیش از تهیه سند، حاکمیت را تعیین کنید</h2><ul><li>مسئول تدارکات، حامی تجارتی، مسئولان روند، ارزیابان تخنیکی و مرجع تأیید را مشخص کنید.</li><li>هدف تدارکات، صلاحیت بودجه، تصمیم مورد نظر و وابستگی‌های مهم را ثبت کنید.</li><li>روش وضاحت، تعدیل سند، تعارض منافع، محرمیت و ارتباط با داوطلب را تعریف کنید.</li><li>در صورت الزام قواعد نافذ، مسئول تهیه نیازمندی، ارزیابی و منظوری قرارداد را جدا سازید.</li></ul>
<h2>۲. نتیجه و سناریوی واقعی را تشریح کنید</h2><p>نام عمومی ماژول را به روند end-to-end تبدیل کنید. روند تدارکات می‌تواند از درخواست، تأیید و نرخ‌گیری تا سفارش، رسید، فاکتور، پرداخت و ثبت حسابداری ادامه یابد. برای هر سناریو نقش، معلومات، حدود تأیید، استثنا، خروجی و شواهد پذیرش را مشخص کنید.</p>
<h2>۳. ماتریس قابل پیگیری نیازمندی بسازید</h2><p>به هر نیاز مهم شناسه بدهید و مطابق روش تأییدشده سازمان دسته‌بندی کنید. از داوطلب بخواهید وضعیت را واضح بیان کند: امکان استاندارد، تنظیم، توسعه اختصاصی، وابستگی بیرونی، پلان آینده یا انحراف.</p><ul><li>روند، اعتبارسنجی، تأیید و گزارش</li><li>نقش، تفکیک وظیفه و تاریخچه فعالیت</li><li>زبان، RTL، شعبه، واحد و اسعار</li><li>انتقال معلومات، ادغام و وابستگی بیرونی</li><li>دسترس‌پذیری، سرعت، accessibility و دستگاه</li><li>امنیت، محرمیت، نگهداری، بکاپ و بازیابی</li><li>آموزش، اسناد، نصب، پشتیبانی و خروج</li></ul><p>پاسخ «بلی» بدون تشریح یا شواهد نباید با امکان نمایش‌شده و شامل قرارداد یکسان ارزیابی شود.</p>
<h2>۴. ماتریس مسئولیت تطبیق را واضح سازید</h2><p>کار عرضه‌کننده، کار مشتری و مسئولیت مشترک را جدا کنید. تأیید روند، مالکیت معلومات منبع، پاک‌سازی، تصمیم تنظیم، دسترسی ادغام، سناریوی تست، UAT، اشتراک آموزش، زیربنا، اجازه cutover و تماس پشتیبانی باید مسئول مشخص داشته باشد.</p><p>زمان‌بندی زمانی معتبر است که وابستگی و مهلت تصمیم هر دو طرف معلوم باشد.</p>
<h2>۵. شواهد امنیت متناسب با خطر بخواهید</h2><p>حساسیت معلومات، فعالیت ممتاز، گروه‌های کاربر، موقعیت، دسترسی انترنتی، uptime و نیاز بازیابی را توضیح دهید. روش کنترول سورس، تغییر، dependency، secret، محیط، تست، نشر، log، incident و vulnerability را بپرسید.</p><p>نام یک framework را خودکار به ادعای تصدیق تبدیل نکنید. شواهد، محدوده و مسئول باید روشن باشد و مسئولیت امنیت تا میزبانی، نگهداری و ختم قرارداد ادامه یابد.</p>
<h2>۶. مسئولیت و هزینه کامل را مقایسه کنید</h2><p>ساختار نرخ قابل مقایسه بخواهید: لایسنس یا اشتراک، تطبیق، تنظیم، توسعه، انتقال، ادغام، زیربنا، سفر، آموزش، مالیه، پشتیبانی، تمدید و موارد اختیاری. تعداد کاربر، محیط، حجم معلومات، ساعت خدمت، اسعار، milestone پرداخت، اعتبار نرخ و قواعد تغییر را ثبت کنید.</p>
<h2>۷. نمایش را به شواهد کنترول‌شده تبدیل کنید</h2><p>به داوطلبان منتخب سناریو، نقش و زمان یکسان بدهید. از آنان بخواهید امکان موجود را از تنظیم، توسعه پیشنهادی و خدمت بیرونی جدا نشان دهند. پرسش‌ها و وضاحت‌ها را از کانال مجاز ثبت کنید. نمایش عمومی زیبا، اثبات روند واقعی سازمان نیست.</p>
<h2>۸. پذیرش و حدود قرارداد را پیش از اعطا تعیین کنید</h2><ul><li>خروجی‌ها و مراحل قابل بررسی</li><li>baseline نیازمندی و روش تغییر</li><li>محدوده انتقال و شواهد reconciliation</li><li>محیط تست، طبقه‌بندی defect و صلاحیت UAT</li><li>cutover، rollback، تحویل و اسناد</li><li>مالکیت معلومات، export، لایسنس و مالکیت فکری</li><li>تضمین، پشتیبانی، سنجش SLA، تمدید و فسخ</li></ul><p>وعده مهم ارزیابی باید در قرارداد یا محدوده امضاشده انعکاس یابد.</p>
<h2>بسته عملی داوطلبی</h2><p>بسته کامل معمولاً شامل هدایت، معلومات پس‌منظر، محدوده، سناریو، ماتریس نیازمندی، معلومات و ادغام، امنیت، مسئولیت تطبیق، خروجی، روش ارزیابی، قالب پاسخ، جدول تجارتی، شرایط قرارداد و کانال وضاحت است.</p>
<h2>منابع اصلی این راهنما</h2><p>ساختار با <a href="https://documents.worldbank.org/en/publication/documents-reports/documentdetail/099120102072534901">مقرره تدارکات پروژه‌های IPF بانک جهانی، ویرایش ششم</a> و <a href="https://documents.worldbank.org/en/publication/documents-reports/documentdetail/099325208202512194">راهنمای فعلی ارزیابی پیشنهادها</a> تطبیق داده شده است. این منابع تنها در محدوده‌ای قابل اجرا است که چارچوب مربوط تعیین کند؛ هر نهاد باید قواعد قانونی، تمویل‌کننده و داخلی فعلی خود را رعایت کند.</p>
HTML,
                    'ps' => <<<'HTML'
<h2>د ERP تدارکات له عملیاتي ستونزې پیلېږي، نه د محصول له نومه</h2><p>د ERP داوطلبۍ سند باید وښيي چې کومې پرېکړې، ثبتونه او کنټرولونه ښه کېدل غواړي. یوازې «مالي، بشري سرچینې او ګدام» کافي نه دي؛ داوطلب باید ادارې، ځایونه، کاروونکي، د تایید کچې، اسعار، راپورونه، ادغامونه، معلوماتي سرچینې او عملیاتي محدودیتونه وپېژني.</p><p>صادروونکې اداره د خپل تدارکاتي میتود، قانون یا تمویلوونکي قواعدو، ارزونې صلاحیت او وروستي قرارداد مسؤله ده. دا لارښود د پلان وسیله ده او هغه شرطونه نه بدلوي.</p>
<h2>۱. تر سند لیکلو مخکې حاکمیت وټاکئ</h2><ul><li>د تدارکاتو مسؤل، سوداګریز sponsor، د بهیر خاوندان، تخنیکي ارزونکي او مجاز تاییدوونکی وټاکئ.</li><li>د تدارکاتو موخه، د بودجې صلاحیت، هدف پرېکړه او مهمې وابستګۍ ثبت کړئ.</li><li>د وضاحت، addendum، د ګټو ټکر، محرمیت او له داوطلب سره د اړیکې لاره تعریف کړئ.</li><li>که نافذ اصول غواړي، د اړتیا جوړوونکی، ارزونکی او د قرارداد تاییدوونکی جلا کړئ.</li></ul>
<h2>۲. پایلې او واقعي سناریوګانې تشریح کړئ</h2><p>د ماډیول عمومي نوم په end-to-end بهیر بدل کړئ. د تدارکاتو بهیر له غوښتنې، تایید او نرخ اخیستو تر فرمایش، رسید، فاکتور، تادیې او حسابداري ثبت پورې رسېدای شي. د هرې سناریو رولونه، معلومات، د تایید حدود، استثناوې، پایلې او د منلو شواهد مشخص کړئ.</p>
<h2>۳. د تعقیب وړ اړتیاوو matrix جوړ کړئ</h2><p>هرې مهمې اړتیا ته شناسه ورکړئ او د ادارې په تایید شوې لاره یې طبقه‌بندي کړئ. له داوطلبه وغواړئ چې یو روښانه حالت وټاکي: معیاري امکان، تنظیم، ځانګړې پراختیا، بهرنۍ وابستګي، راتلونکی پلان یا انحراف.</p><ul><li>کاري بهیر، validation، تایید او راپور</li><li>رول، د دندو جلاوالی او د فعالیت تاریخ</li><li>ژبه، RTL، څانګه، واحد او اسعار</li><li>د معلوماتو لېږد، ادغام او بهرنۍ وابستګي</li><li>شتون، چټکتیا، accessibility او وسایل</li><li>امنیت، محرمیت، ساتنه، بیک‌اپ او رغونه</li><li>روزنه، اسناد، نصب، ملاتړ او د وتلو شرطونه</li></ul><p>بې تشریح یا شواهدو «هو» باید د ښودل شوي او قرارداد کې شامل امکان سره یو شان ونه ارزول شي.</p>
<h2>۴. د پلي کولو د مسؤلیت matrix روښانه کړئ</h2><p>د عرضه کوونکي، مشتری او ګډ کار ترمنځ توپیر وکړئ. د بهیر تایید، د سرچینې معلوماتو مالکیت، پاکول، تنظیمي پرېکړې، د ادغام لاسرسی، تست سناریو، UAT، روزنیز حضور، زیربنا، cutover اجازه او د ملاتړ تماس باید مسؤل ولري.</p><p>مهال‌وېش هغه وخت معتبر دی چې د دواړو خواوو وابستګي او د پرېکړې مهلتونه ښکاره وي.</p>
<h2>۵. له خطر سره برابر امنیتي شواهد وغواړئ</h2><p>د معلوماتو حساسیت، ممتاز فعالیتونه، کاروونکي، ځایونه، انټرنېټي لاسرسی، uptime او د رغونې اړتیا بیان کړئ. د source، بدلون، dependency، secret، چاپېریال، تست، release، log، incident او vulnerability د کنټرول لاره وپوښتئ.</p><p>د framework نوم په اتومات ډول تصدیق نه دی. شواهد، حدود او مسؤل باید روښانه وي او امنیتي مسؤلیت تر کوربه‌توب، ساتنې او وتلو دوام وکړي.</p>
<h2>۶. بشپړ مسؤلیت او لګښت پرتله کړئ</h2><p>د پرتله کېدو وړ نرخ وغواړئ: لایسنس یا ګډون، پلي کول، تنظیم، پراختیا، لېږد، ادغام، زیربنا، سفر، روزنه، مالیه، ملاتړ، تمدید او اختیاري موارد. د کاروونکو شمېر، چاپېریالونه، معلوماتي حجم، د خدمت ساعتونه، اسعار، تادیې milestone، د نرخ اعتبار او د بدلون قواعد ثبت کړئ.</p>
<h2>۷. نمایش په کنټرول شوو شواهدو بدل کړئ</h2><p>ټاکل شوو داوطلبانو ته یو شان سناریو، رولونه او وخت ورکړئ. ترې وغواړئ چې موجود امکان له تنظیم، وړاندیز شوې پراختیا او بهرني خدمت څخه جلا وښيي. پوښتنې او وضاحت د مجاز کانال له لارې ثبت کړئ.</p>
<h2>۸. تر قرارداد مخکې د منلو حدود وټاکئ</h2><ul><li>پایلې او د کتنې وړ پړاوونه</li><li>د اړتیاوو baseline او د بدلون لاره</li><li>د لېږد حدود او reconciliation شواهد</li><li>تست چاپېریال، defect طبقه او د UAT صلاحیت</li><li>cutover، rollback، سپارل او اسناد</li><li>د معلوماتو مالکیت، export، لایسنس او فکري ملکیت</li><li>تضمین، ملاتړ، د SLA سنجش، تمدید او فسخ</li></ul><p>د ارزونې مهمه ژمنه باید په لاسلیک شوي قرارداد یا حدودو کې شامله وي.</p>
<h2>عملي داوطلبۍ بسته</h2><p>بشپړه بسته معمولاً لارښوونې، شالید، حدود، سناریو، د اړتیاوو matrix، معلومات او ادغام، امنیت، د پلي کولو مسؤلیت، پایلې، د ارزونې لاره، د ځواب بڼه، سوداګریز جدول، قراردادي شرایط او د وضاحت کانال لري.</p>
<h2>د دې لارښود اصلي سرچینې</h2><p>جوړښت د <a href="https://documents.worldbank.org/en/publication/documents-reports/documentdetail/099120102072534901">نړیوال بانک د IPF تدارکاتو مقرراتو شپږمې نسخې</a> او د <a href="https://documents.worldbank.org/en/publication/documents-reports/documentdetail/099325208202512194">داوطلبیو او وړاندیزونو د ارزونې اوسني لارښود</a> سره پرتله شوی. دا منابع یوازې هلته تطبیقېږي چې اړوند چوکاټ یې لازم وبولي؛ هره اداره باید خپل اوسني قانوني، تمویلوونکي او داخلي اصول تعقیب کړي.</p>
HTML,
                ],
                metaTitle: [
                    'en' => 'ERP Procurement & Tender Guide Afghanistan | Fida',
                    'fa' => 'راهنمای تدارکات و داوطلبی ERP افغانستان | فیدا',
                    'ps' => 'د ERP تدارکاتو او داوطلبۍ لارښود افغانستان | فیدا',
                ],
                metaDescription: [
                    'en' => 'A practical ERP tender guide for requirements, demonstrations, evaluation, implementation responsibility, security, cost and acceptance.',
                    'fa' => 'راهنمای عملی داوطلبی ERP برای نیازمندی، نمایش، ارزیابی، مسئولیت تطبیق، امنیت، هزینه و پذیرش.',
                    'ps' => 'د ERP داوطلبۍ عملي لارښود؛ اړتیاوې، نمایش، ارزونه، د پلي کولو مسؤلیت، امنیت، لګښت او منل.',
                ],
                primaryQuery: [
                    'en' => 'ERP procurement tender guide Afghanistan',
                    'fa' => 'راهنمای داوطلبی ERP در افغانستان',
                    'ps' => 'په افغانستان کې د ERP داوطلبۍ لارښود',
                ],
                faqs: [
                    $this->faq('Should an ERP tender contain a complete feature list?', 'It should contain traceable requirements, but a generic feature list is insufficient. Representative workflows, roles, data, controls, reports, integrations, implementation duties and acceptance evidence make the requirements evaluable.', 'آیا داوطلبی ERP باید فهرست کامل امکانات داشته باشد؟', 'نیازمندی قابل پیگیری لازم است، اما فهرست عمومی کافی نیست. روند واقعی، نقش، معلومات، کنترول، گزارش، ادغام، مسئولیت تطبیق و شواهد پذیرش باید مشخص شود.', 'ایا د ERP داوطلبۍ کې بشپړ فیچر لست اړین دی؟', 'د تعقیب وړ اړتیاوې اړینې دي، خو عمومي لست کافي نه دی. واقعي بهیر، رول، معلومات، کنټرول، راپور، ادغام، د پلي کولو مسؤلیت او د منلو شواهد باید روښانه وي.'),
                    $this->faq('How should ERP demonstrations be compared?', 'Give shortlisted bidders the same scenarios, roles, sample data and time. Record whether each result is standard, configured, custom, third-party or unavailable, and preserve authorized written clarifications.', 'نمایش ERP چگونه مقایسه شود؟', 'به داوطلبان منتخب سناریو، نقش، معلومات نمونه و زمان یکسان بدهید. استاندارد، تنظیمی، اختصاصی، بیرونی یا ناموجود بودن هر نتیجه و وضاحت کتبی را ثبت کنید.', 'د ERP نمایشونه څنګه پرتله شي؟', 'ټاکل شوو داوطلبانو ته یو شان سناریو، رول، نمونوي معلومات او وخت ورکړئ. هره پایله معیاري، تنظیمي، ځانګړې، بهرنۍ یا ناموجوده ثبت او لیکلی وضاحت وساتئ.'),
                    $this->faq('Is the lowest ERP price always the lowest evaluated cost?', 'No. Implementation, migration, integrations, infrastructure, training, support, renewals, internal effort and excluded work can materially change the evaluated responsibility and total cost.', 'آیا کمترین نرخ ERP همیشه کمترین هزینه ارزیابی‌شده است؟', 'خیر. تطبیق، انتقال، ادغام، زیربنا، آموزش، پشتیبانی، تمدید، تلاش داخلی و کار خارج‌شده می‌تواند هزینه و مسئولیت کامل را تغییر دهد.', 'ایا د ERP تر ټولو ټیټه بیه تل تر ټولو ټیټ ارزول شوی لګښت دی؟', 'نه. پلي کول، لېږد، ادغام، زیربنا، روزنه، ملاتړ، تمدید، داخلي هڅه او خارج کار ټول لګښت او مسؤلیت بدلولی شي.'),
                    $this->faq('Can this guide replace procurement law or donor rules?', 'No. The issuing organization must follow its current applicable law, donor framework, internal policy and authorized procurement documents. This article only provides a software-scoping checklist.', 'آیا این راهنما جای قانون یا قواعد تمویل‌کننده را می‌گیرد؟', 'خیر. نهاد باید قانون نافذ، چارچوب تمویل‌کننده، پالیسی داخلی و اسناد مجاز تدارکات را رعایت کند. این مقاله تنها چک‌لیست محدوده نرم‌افزار است.', 'ایا دا لارښود قانون یا د تمویلوونکي اصول بدلوي؟', 'نه. اداره باید نافذ قانون، د تمویلوونکي چوکاټ، داخلي پالیسي او مجاز تدارکاتي اسناد تعقیب کړي. دا مقاله یوازې د سافټویر د حدودو چک‌لېست دی.'),
                ],
                relatedSlugs: ['software-procurement-tender-support-afghanistan', 'erp-systems-afghanistan', 'questions-before-hiring-software-company-afghanistan'],
                sortOrder: 60,
            ),
            $this->migrationArticle($planningCategoryId),
            $this->securityArticle($securityCategoryId),
        ];
    }

    private function migrationArticle(?int $categoryId): array
    {
        return $this->article(
            slug: 'erp-data-migration-checklist-afghanistan',
            categoryId: $categoryId,
            title: [
                'en' => 'ERP Data Migration Checklist: From Legacy Records to Go-Live',
                'fa' => 'چک‌لیست انتقال معلومات ERP؛ از سیستم قبلی تا راه‌اندازی',
                'ps' => 'د ERP معلوماتو د لېږد چک‌لېست؛ له زاړه سیسټم تر پیل',
            ],
            eyebrow: [
                'en' => 'Data migration and cutover guide',
                'fa' => 'راهنمای انتقال معلومات و cutover',
                'ps' => 'د معلوماتو لېږد او cutover لارښود',
            ],
            summary: [
                'en' => 'Define ownership, scope, mapping, cleansing, trial loads, reconciliation, cutover and rollback before production data enters a new ERP.',
                'fa' => 'پیش از ورود معلومات اصلی به ERP جدید، مالکیت، محدوده، mapping، پاک‌سازی، انتقال آزمایشی، reconciliation، cutover و rollback را تعیین کنید.',
                'ps' => 'اصلي معلومات نوي ERP ته تر داخلېدو مخکې مالکیت، حدود، mapping، پاکول، ازمایښتي لېږد، reconciliation، cutover او rollback وټاکئ.',
            ],
            body: [
                'en' => <<<'HTML'
<h2>Data migration is a controlled business decision</h2><p>Migration is not successful because a file imported without an error. The target records must be complete enough for the approved workflow, mapped to the intended meaning, reconciled with trusted sources and accepted by an authorized owner.</p><p>The organization owns the meaning and approval of its source data. The implementation team can profile, map, transform and load it, but should not silently decide which duplicate customer, opening balance or historical record is correct.</p>
<h2>1. Name owners and define the migration scope</h2><ul><li>Business owner for each data domain</li><li>Source-system contact and extraction responsibility</li><li>Migration analyst or technical mapping owner</li><li>Reviewer for quality, balances and exceptions</li><li>Authorized sign-off and cutover decision</li></ul><p>State which companies, branches, periods, master records, opening balances, open transactions, documents and history will move. Also state what will remain in an archive or legacy system.</p>
<h2>2. Inventory every source before designing the load</h2><p>List databases, spreadsheets, documents, devices and external systems. Record the owner, format, volume, encoding, identifiers, relationships, date and currency rules, access method, extraction frequency and known quality problems.</p><p>Do not assume the newest file is authoritative. A source register should identify which source wins when the same record exists in several places.</p>
<h2>3. Agree on the target data model and mapping</h2><p>Map source fields to target fields with meaning, type, required status, allowed values, transformation, default, reference dependency and validation rule. Confirm how identifiers will be preserved or replaced and how old identifiers can be traced after go-live.</p><ul><li>Customers, suppliers, employees, items and chart of accounts</li><li>Branches, warehouses, projects, cost centers and currencies</li><li>Opening balances, stock on hand and open documents</li><li>Attachments, historical transactions and audit requirements</li></ul>
<h2>4. Clean data under business authority</h2><p>Profile missing values, duplicates, invalid codes, impossible dates, inconsistent units, inactive records and broken relationships. Create correction rules and an exception list. Business owners should approve merges, closures, conversions and material adjustments.</p><p>Keep the original extract and the approved transformed version. An undocumented spreadsheet correction cannot be audited or repeated reliably.</p>
<h2>5. Protect migration environments and files</h2><p>Migration data may contain payroll, identity, financial, supplier or beneficiary information. Limit access, use approved transfer and storage, separate environments, protect credentials, log material activity and define when temporary files will be removed. Production data should not be copied into uncontrolled test tools.</p>
<h2>6. Run repeatable trial migrations</h2><p>A trial should use the intended extraction, transformation and load sequence. Record runtime, failures, rejected rows, manual steps and dependencies. Repeat the process after corrections so the final cutover is based on a rehearsed procedure rather than a one-time script.</p><p>Test data must arrive early enough for configuration review, integrations, training and UAT, while still being controlled against unauthorized use.</p>
<h2>7. Reconcile structure, counts and value</h2><p>Validation needs more than row counts. Compare control totals and representative records across the source, transformed data and ERP.</p><ul><li>Record counts by company, branch, status or period</li><li>Opening trial balance and account balances</li><li>Customer and supplier receivables or payables</li><li>Inventory quantity and value by item and location</li><li>Open orders, commitments and document totals</li><li>Relationships, attachments and sample history</li></ul><p>Define tolerances, exception ownership and the evidence required for sign-off.</p>
<h2>8. Plan cutover, freeze, rollback and communication</h2><p>The cutover plan should state the last legacy transaction, data freeze, final extraction, load order, reconciliation, integration activation, access release and authorized go-live decision. Include estimated durations, owners, checkpoints and communication.</p><p>A rollback plan should explain what triggers it, how systems and users return to a safe state, how transactions created during the attempt are handled and who authorizes the decision.</p>
<h2>9. Retain evidence and close temporary access</h2><p>After acceptance, preserve the approved mapping, scripts or configurations, extracts, reconciliation, exceptions and sign-off according to policy. Remove temporary credentials and files, confirm archive access and record the ongoing owner for data quality.</p>
<h2>Primary guidance used for this article</h2><p>This checklist was cross-checked against Microsoft’s official implementation guidance for <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/implementation-guide/data-management-configuration-data-migration">configuration and migration data</a>, its <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/implementation-guide/data-management-check-list">data-management checklist</a> and its guidance on <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/implementation-guide/project-governance-key-project-areas">data migration governance and cutover alignment</a>. The principles are adapted generically; they do not imply that Fida uses or resells Dynamics 365.</p>
HTML,
                'fa' => <<<'HTML'
<h2>انتقال معلومات یک تصمیم کنترول‌شده تجارتی است</h2><p>انتقال تنها به دلیل import بدون خطا موفق نیست. ثبت هدف باید برای روند تأییدشده کافی، مطابق معنای درست mapping، با منبع معتبر reconciliation و توسط مسئول مجاز پذیرفته شود.</p><p>سازمان مالک معنا و تأیید معلومات منبع است. تیم تطبیق می‌تواند معلومات را بررسی، mapping، تبدیل و load کند؛ اما نباید خودسرانه مشتری تکراری، بیلانس افتتاحیه یا سابقه درست را انتخاب کند.</p>
<h2>۱. مسئولان و محدوده انتقال را مشخص کنید</h2><ul><li>مالک تجارتی هر بخش معلومات</li><li>مسئول سیستم منبع و استخراج</li><li>مسئول تخنیکی mapping و انتقال</li><li>بازبین کیفیت، بیلانس و استثنا</li><li>مرجع sign-off و تصمیم cutover</li></ul><p>شرکت، شعبه، دوره، معلومات اصلی، بیلانس، معامله باز، سند و تاریخچه قابل انتقال و موارد باقی‌مانده در archive را ثبت کنید.</p>
<h2>۲. تمام منابع را فهرست کنید</h2><p>دیتابیس، Excel، سند، دستگاه و سیستم بیرونی را با مالک، فرمت، حجم، encoding، شناسه، رابطه، قاعده تاریخ و اسعار، روش دسترسی و مشکل کیفیت ثبت کنید. مشخص سازید هنگام تکرار، کدام منبع مرجع است.</p>
<h2>۳. مدل هدف و mapping را تأیید کنید</h2><p>هر فیلد منبع را با معنای فیلد هدف، نوع، اجباری بودن، مقدار مجاز، تبدیل، default، وابستگی و validation وصل کنید. روش حفظ یا تبدیل شناسه قبلی و قابلیت پیگیری آن را تعیین کنید.</p><ul><li>مشتری، عرضه‌کننده، کارمند، جنس و چارت حساب</li><li>شعبه، گدام، پروژه، مرکز هزینه و اسعار</li><li>بیلانس افتتاحیه، موجودی و اسناد باز</li><li>ضمیمه، تاریخچه و نیاز audit</li></ul>
<h2>۴. پاک‌سازی را با صلاحیت تجارتی انجام دهید</h2><p>مقدار مفقود، تکرار، کود نادرست، تاریخ ناممکن، واحد ناسازگار، ثبت غیرفعال و رابطه شکسته را پیدا کنید. قواعد اصلاح و فهرست استثنا بسازید. ادغام، بسته‌شدن و تعدیل مهم باید تأیید مالک روند را داشته باشد.</p><p>نسخه اصلی و نسخه تبدیل‌شده تأییدشده را حفظ کنید. اصلاح بدون سند قابل تکرار و audit نیست.</p>
<h2>۵. محیط و فایل‌های انتقال را محافظت کنید</h2><p>معلومات می‌تواند شامل معاش، هویت، مالی، عرضه‌کننده یا مستفید باشد. دسترسی را محدود، انتقال و ذخیره را تأیید، محیط را جدا، credentials را محافظت، فعالیت مهم را log و زمان حذف فایل موقت را تعیین کنید.</p>
<h2>۶. انتقال آزمایشی قابل تکرار اجرا کنید</h2><p>آزمایش باید همان ترتیب استخراج، تبدیل و load نهایی را استفاده کند. زمان، خطا، ردیف ردشده، کار دستی و وابستگی را ثبت و پس از اصلاح دوباره اجرا کنید. معلومات تست باید برای تنظیم، ادغام، آموزش و UAT به‌موقع آماده باشد.</p>
<h2>۷. ساختار، تعداد و ارزش را reconciliation کنید</h2><ul><li>تعداد ثبت بر اساس شرکت، شعبه، وضعیت و دوره</li><li>تراز آزمایشی و بیلانس حساب</li><li>طلب و بدهی مشتری و عرضه‌کننده</li><li>تعداد و ارزش موجودی بر جنس و محل</li><li>سفارش، تعهد و مجموع سند باز</li><li>رابطه، ضمیمه و نمونه تاریخچه</li></ul><p>حد قابل قبول، مسئول استثنا و شواهد sign-off را از قبل تعیین کنید.</p>
<h2>۸. cutover، freeze، rollback و ارتباط را پلان کنید</h2><p>آخرین معامله سیستم قبلی، توقف ثبت، استخراج نهایی، ترتیب load، reconciliation، فعال‌سازی ادغام، بازشدن دسترسی و مرجع go-live را مشخص کنید. rollback باید trigger، حالت امن، معامله ایجادشده و مرجع تصمیم را واضح سازد.</p>
<h2>۹. شواهد را حفظ و دسترسی موقت را ببندید</h2><p>پس از پذیرش، mapping، تنظیم یا script، extract، reconciliation، استثنا و sign-off را مطابق پالیسی نگهدارید. credentials و فایل موقت را حذف و مالک دوامدار کیفیت معلومات را مشخص کنید.</p>
<h2>منابع اصلی این راهنما</h2><p>چک‌لیست با راهنمای رسمی Microsoft درباره <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/implementation-guide/data-management-configuration-data-migration">معلومات تنظیم و انتقال</a>، <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/implementation-guide/data-management-check-list">چک‌لیست مدیریت معلومات</a> و <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/implementation-guide/project-governance-key-project-areas">حاکمیت انتقال و هماهنگی cutover</a> مقایسه شده است. اصول به شکل عمومی استفاده شده و به معنی استفاده یا فروش Dynamics 365 توسط فیدا نیست.</p>
HTML,
                'ps' => <<<'HTML'
<h2>د معلوماتو لېږد یوه کنټرول شوې سوداګریزه پرېکړه ده</h2><p>لېږد یوازې ځکه بریالی نه دی چې فایل بې خطا import شي. هدف ثبتونه باید د تایید شوي بهیر لپاره بشپړ، سمې معنا ته mapping، له باوري سرچینو سره reconciliation او د مجاز مالک له خوا منل شوي وي.</p><p>اداره د سرچینه معلوماتو د معنا او تایید مالکه ده. د پلي کولو ټیم یې کتلی، mapping، بدل او load کولی شي؛ خو تکراري مشتری، افتتاحي بیلانس یا سم تاریخ باید په خپله ونه ټاکي.</p>
<h2>۱. مسؤلین او د لېږد حدود وټاکئ</h2><ul><li>د هر معلوماتي ډومېن سوداګریز مالک</li><li>د سرچینې سیسټم او استخراج مسؤل</li><li>د mapping او لېږد تخنیکي مسؤل</li><li>د کیفیت، بیلانس او استثنا کتونکی</li><li>د sign-off او cutover مجاز مسؤل</li></ul><p>شرکتونه، څانګې، دورې، اصلي ثبتونه، بیلانسونه، پرانیستې معاملې، اسناد او تاریخ چې لېږدول کېږي یا archive کې پاتې کېږي، ولیکئ.</p>
<h2>۲. ټولې سرچینې ثبت کړئ</h2><p>ډیټابیس، Excel، اسناد، وسایل او بهرني سیسټمونه له مالک، بڼې، حجم، encoding، شناسه، اړیکو، د نېټې او اسعارو قواعدو، لاسرسي او کیفیت ستونزو سره ثبت کړئ. د تکرار په صورت کې مرجع سرچینه وټاکئ.</p>
<h2>۳. هدف ماډل او mapping تایید کړئ</h2><p>د سرچینې هر فیلډ د هدف له معنا، ډول، اجباري حالت، مجاز ارزښت، بدلون، default، وابستګي او validation سره ونښلوئ. د زړو شناسو د ساتلو یا بدلولو او وروسته تعقیب لاره وټاکئ.</p><ul><li>مشتریان، عرضه کوونکي، کارکوونکي، اجناس او د حسابونو چارت</li><li>څانګې، ګدامونه، پروژې، لګښت مرکزونه او اسعار</li><li>افتتاحي بیلانس، موجودي او پرانیستي اسناد</li><li>ضمیمې، تاریخ او audit اړتیاوې</li></ul>
<h2>۴. معلومات د سوداګریز صلاحیت لاندې پاک کړئ</h2><p>ورک ارزښتونه، تکرار، ناسم کوډ، ناممکنه نېټه، ناساز واحد، غیرفعال ثبت او ماتې اړیکې ومومئ. د اصلاح قواعد او استثنا لست جوړ کړئ. مهم ادغام، تړل او تعدیل باید د بهیر مالک تایید کړي.</p><p>اصلي extract او تایید شوې بدله نسخه وساتئ. بې سنده اصلاح نه تکرارېږي او نه audit کېدای شي.</p>
<h2>۵. چاپېریال او فایلونه خوندي کړئ</h2><p>معلومات کېدای شي معاش، هویت، مالي، عرضه کوونکي یا مستفید معلومات ولري. لاسرسی محدود، لېږد او ذخیره تایید، چاپېریالونه جلا، credentials خوندي، مهم فعالیت log او د موقتي فایل د حذف وخت مشخص کړئ.</p>
<h2>۶. د تکرار وړ ازمایښتي لېږد وکړئ</h2><p>ازموینه باید د وروستي استخراج، بدلون او load هماغه ترتیب وکاروي. وخت، خطا، رد شوي ریکارډونه، لاسي ګامونه او وابستګي ثبت او تر اصلاح وروسته بیا یې وچلوئ. معلومات باید د تنظیم، ادغام، روزنې او UAT لپاره پر وخت چمتو وي.</p>
<h2>۷. جوړښت، شمېر او ارزښت reconciliation کړئ</h2><ul><li>د شرکت، څانګې، حالت او دورې له مخې د ثبت شمېر</li><li>ازمایښتي بیلانس او حسابي بیلانسونه</li><li>د مشتری او عرضه کوونکي طلب او بدهی</li><li>د جنس او ځای له مخې موجودي او ارزښت</li><li>پرانیستي فرمایشونه، تعهدات او مجموعې</li><li>اړیکې، ضمیمې او نمونوي تاریخ</li></ul><p>د منلو حد، د استثنا مسؤل او د sign-off شواهد مخکې وټاکئ.</p>
<h2>۸. cutover، freeze، rollback او اړیکه پلان کړئ</h2><p>د زاړه سیسټم وروستۍ معامله، د ثبت درول، وروستی استخراج، load ترتیب، reconciliation، د ادغام فعالول، لاسرسی او د go-live اجازه مشخص کړئ. rollback باید trigger، خوندي حالت، د هڅې پر مهال معاملې او د پرېکړې مسؤل روښانه کړي.</p>
<h2>۹. شواهد وساتئ او موقتي لاسرسی بند کړئ</h2><p>تر منلو وروسته mapping، script یا تنظیم، extract، reconciliation، استثنا او sign-off د پالیسي مطابق وساتئ. موقتي credentials او فایلونه حذف او د معلوماتو د کیفیت دوامدار مالک وټاکئ.</p>
<h2>د دې لارښود اصلي سرچینې</h2><p>چک‌لېست د Microsoft د <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/implementation-guide/data-management-configuration-data-migration">تنظیم او لېږد معلوماتو</a>، <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/implementation-guide/data-management-check-list">معلوماتو مدیریت چک‌لېست</a> او <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/implementation-guide/project-governance-key-project-areas">د لېږد حاکمیت او cutover همغږۍ</a> له رسمي لارښود سره پرتله شوی. اصول په عمومي ډول کارول شوي او دا نه ښيي چې فیدا Dynamics 365 کاروي یا پلوري.</p>
HTML,
            ],
            metaTitle: [
                'en' => 'ERP Data Migration Checklist Afghanistan | Fida',
                'fa' => 'چک‌لیست انتقال معلومات ERP افغانستان | فیدا',
                'ps' => 'د ERP معلوماتو لېږد چک‌لېست افغانستان | فیدا',
            ],
            metaDescription: [
                'en' => 'ERP data migration checklist covering ownership, source inventory, mapping, cleansing, trial loads, reconciliation, cutover and rollback.',
                'fa' => 'چک‌لیست انتقال ERP؛ مالکیت، منبع، mapping، پاک‌سازی، انتقال آزمایشی، reconciliation، cutover و rollback.',
                'ps' => 'د ERP لېږد چک‌لېست؛ مالکیت، سرچینه، mapping، پاکول، ازمایښتي لېږد، reconciliation، cutover او rollback.',
            ],
            primaryQuery: [
                'en' => 'ERP data migration checklist Afghanistan',
                'fa' => 'چک‌لیست انتقال معلومات ERP افغانستان',
                'ps' => 'د ERP معلوماتو لېږد چک‌لېست افغانستان',
            ],
            faqs: [
                $this->faq('Who owns decisions about migrated data?', 'The organization’s authorized business owners decide meaning, quality, corrections and acceptance. The implementation team supports profiling, mapping, transformation, loading and evidence.', 'تصمیم معلومات انتقالی با چه کسی است؟', 'مسئولان مجاز تجارتی سازمان معنا، کیفیت، اصلاح و پذیرش را تعیین می‌کنند. تیم تطبیق بررسی، mapping، تبدیل، load و شواهد را پشتیبانی می‌کند.', 'د لېږدول شوو معلوماتو پرېکړه څوک کوي؟', 'د ادارې مجاز سوداګریز مالکان معنا، کیفیت، اصلاح او منل ټاکي. د پلي کولو ټیم کتنه، mapping، بدلون، load او شواهد برابروي.'),
                $this->faq('Should every historical record move into the new ERP?', 'Not automatically. The scope should distinguish operationally required history, legally or professionally retained records, archived data and information that should be corrected or excluded under approved rules.', 'آیا تمام سابقه باید به ERP جدید منتقل شود؟', 'نه به شکل خودکار. محدوده باید تاریخچه لازم عملیاتی، اسناد قابل نگهداری، archive و معلومات قابل اصلاح یا حذف را مطابق قواعد تأییدشده جدا کند.', 'ایا ټول تاریخي ثبتونه باید نوي ERP ته ولېږدول شي؟', 'په اتومات ډول نه. حدود باید اړین عملیاتي تاریخ، د ساتنې اسناد، archive او د تایید شوو اصولو مطابق د اصلاح یا خارج معلومات جلا کړي.'),
                $this->faq('Why are trial migrations necessary?', 'They expose mapping errors, runtime, rejected records, manual steps and dependencies before the production cutover. Repeated dry runs also produce a procedure the team can rehearse and measure.', 'چرا انتقال آزمایشی لازم است؟', 'خطای mapping، زمان اجرا، ثبت ردشده، کار دستی و وابستگی را پیش از cutover اصلی آشکار می‌کند و یک روش قابل تمرین و سنجش می‌سازد.', 'ولې ازمایښتي لېږد اړین دی؟', 'د اصلي cutover مخکې د mapping خطا، وخت، رد شوي ثبتونه، لاسي ګامونه او وابستګي ښيي او د تمرین او سنجش وړ لاره جوړوي.'),
                $this->faq('Is a successful import enough to approve migration?', 'No. Approval should include structural checks, business reconciliation, representative workflow testing, exception treatment and sign-off by authorized owners.', 'آیا import موفق برای تأیید انتقال کافی است؟', 'خیر. بررسی ساختار، reconciliation تجارتی، تست روند واقعی، رسیدگی استثنا و sign-off مسئولان مجاز لازم است.', 'ایا بریالی import د لېږد د تایید لپاره کافي دی؟', 'نه. د جوړښت کتنه، سوداګریز reconciliation، د واقعي بهیر تست، د استثنا حل او د مجاز مالک sign-off اړین دي.'),
            ],
            relatedSlugs: ['erp-implementation-services-afghanistan', 'business-process-analysis-afghanistan', 'software-integration-api-development-afghanistan'],
            sortOrder: 70,
        );
    }

    private function securityArticle(int $categoryId): array
    {
        return $this->article(
            slug: 'software-security-requirements-checklist-afghanistan',
            categoryId: $categoryId,
            title: [
                'en' => 'Software Security Requirements Checklist for Business Systems',
                'fa' => 'چک‌لیست نیازمندی امنیت نرم‌افزار برای سیستم‌های تجارتی',
                'ps' => 'د سوداګریزو سیسټمونو لپاره د سافټویر امنیتي اړتیاوو چک‌لېست',
            ],
            eyebrow: [
                'en' => 'Security procurement and verification guide',
                'fa' => 'راهنمای تدارکات و ارزیابی امنیت',
                'ps' => 'د امنیت د تدارک او تایید لارښود',
            ],
            summary: [
                'en' => 'Turn security expectations into scoped responsibilities, verifiable controls and operational evidence across development, hosting, support and exit.',
                'fa' => 'انتظارات امنیت را به مسئولیت مشخص، کنترول قابل ارزیابی و شواهد عملیاتی در توسعه، میزبانی، پشتیبانی و خروج تبدیل کنید.',
                'ps' => 'امنیتي تمې په مشخصو مسؤلیتونو، د تایید وړ کنټرولونو او د پراختیا، کوربه‌توب، ملاتړ او وتلو په شواهدو بدلې کړئ.',
            ],
            body: [
                'en' => <<<'HTML'
<h2>Security requirements must describe the system and its risk</h2><p>“The software must be secure” cannot be designed, priced or accepted objectively. Start with the business purpose, data categories, users, privileged actions, locations, integrations, internet exposure, service dependencies, availability and recovery expectations.</p><p>No checklist or test can prove that software has no vulnerabilities. The goal is to define proportionate practices, verify agreed controls, treat findings and operate the released system responsibly.</p>
<h2>1. Assign security and data responsibilities</h2><ul><li>Business and data owner</li><li>Access approvers and privileged administrators</li><li>Development, review and release responsibility</li><li>Hosting, patching, monitoring and backup owner</li><li>Incident, communication and escalation contacts</li><li>Third-party service and integration owners</li></ul><p>A cloud provider, software supplier and client may each control different layers. The contract and operating plan should state those boundaries.</p>
<h2>2. Define identity, access and sensitive actions</h2><p>Specify user identity, authentication, account recovery, roles, permissions, approval limits, segregation of duties, session behavior and privileged access. High-impact actions may require re-authentication, dual control, notification or extra logging according to risk.</p><p>The organization should define who authorizes access, how inactive users are removed and how permissions are reviewed.</p>
<h2>3. Document data protection and lifecycle</h2><p>Identify permitted use, classification, storage locations, transfers, exports, retention, deletion, backup and exit requirements. State where encryption is expected and who manages keys or credentials. Encryption does not correct excessive permissions, unsafe exports or uncontrolled devices by itself.</p>
<h2>4. Require secure development and release practices</h2><ul><li>Controlled source repositories and authorized contributors</li><li>Review of material code, configuration and infrastructure changes</li><li>Separate development, testing and production environments</li><li>Secret, dependency and build-artifact management</li><li>Security testing appropriate to the application and risk</li><li>Recorded releases, approvals, rollback and defect treatment</li></ul><p>Ask for evidence that matches the agreed practice. A scanner report is one input; it is not proof that every business-logic, access or operational risk has been tested.</p>
<h2>5. Specify verification and acceptance</h2><p>Translate requirements into testable outcomes for authentication, authorization, validation, sessions, sensitive transactions, files, APIs, logging, configuration, backups and restoration. Define the expected verification depth, environment, test data, finding severity, correction, retest and acceptance authority.</p><p>Independent review may be required for higher-risk systems, but its scope and independence must be explicit.</p>
<h2>6. Design hosting, recovery and continuity together</h2><p>Compare cloud, private hosting, on-premise or hybrid options using data sensitivity, connectivity, internal capacity, physical security, patching, monitoring, backup, recovery, scalability and cost. Record recovery objectives and dependencies only after the business owner approves what loss and downtime are tolerable.</p><p>Backups need defined scope, frequency, retention, protection, owner and restoration tests. An untested backup is not verified recovery capability.</p>
<h2>7. Prepare logging, monitoring and incident handling</h2><p>Identify important security and operational events, log access, time synchronization, retention, alert ownership and escalation. The incident plan should cover triage, containment, evidence, restoration, communication, required notification, root-cause review and follow-up actions.</p><p>Do not promise a response time unless service hours, severity definitions, dependencies and measurement rules are included in an approved support agreement.</p>
<h2>8. Review integrations and software dependencies</h2><p>For each API, identity service, payment service, device or external platform, document authentication, authorized data, validation, rate or volume assumptions, errors, retries, reconciliation, monitoring, version change and support ownership. Maintain an approved way to identify and update material software dependencies.</p>
<h2>9. Plan maintenance, change and exit</h2><p>Security continues after launch. Define supported versions, patch and dependency review, vulnerability reporting, change approval, regression testing, access review, restoration tests and service reporting. Exit planning should cover data export, deletion, credentials, domains, infrastructure, source or licence terms, documents and unresolved findings.</p>
<h2>Evidence buyers can request</h2><ul><li>Responsibility matrix and architecture or data-flow overview</li><li>Requirements and verification traceability</li><li>Release and change-control records</li><li>Access model and privileged-role list</li><li>Backup and restoration-test evidence</li><li>Finding register with ownership and treatment</li><li>Incident and support escalation procedure</li></ul><p>Evidence must be current, relevant to the proposed system and shared with appropriate confidentiality. A document title alone is not proof that a practice is operating.</p>
<h2>Primary guidance used for this article</h2><p>The checklist was cross-checked against <a href="https://csrc.nist.gov/pubs/sp/800/218/final">NIST SP 800-218 Secure Software Development Framework</a>, CISA’s <a href="https://www.cisa.gov/resources-tools/resources/secure-demand-guide">Secure by Demand Guide</a> for software buyers, and the <a href="https://owasp.org/www-project-application-security-verification-standard/">OWASP Application Security Verification Standard</a>. These are reference frameworks, not evidence that a supplier or product is certified or compliant.</p>
HTML,
                'fa' => <<<'HTML'
<h2>نیازمندی امنیت باید سیستم و خطر آن را تشریح کند</h2><p>عبارت «نرم‌افزار باید امن باشد» قابل طراحی، قیمت‌گذاری یا پذیرش عینی نیست. هدف تجارتی، نوع معلومات، کاربران، فعالیت ممتاز، موقعیت، ادغام، دسترسی انترنتی، وابستگی خدمت، uptime و انتظار بازیابی را مشخص کنید.</p><p>هیچ چک‌لیست یا تست ثابت نمی‌کند نرم‌افزار هیچ آسیب‌پذیری ندارد. هدف، تعیین روش متناسب، ارزیابی کنترول توافق‌شده، رسیدگی یافته و عملیات مسئولانه است.</p>
<h2>۱. مسئولیت امنیت و معلومات را تعیین کنید</h2><ul><li>مالک تجارتی و معلومات</li><li>مرجع تأیید دسترسی و ادمین ممتاز</li><li>مسئول توسعه، review و release</li><li>مالک میزبانی، patch، monitoring و بکاپ</li><li>تماس incident، ارتباط و escalation</li><li>مالک خدمت بیرونی و ادغام</li></ul><p>ارائه‌کننده cloud، عرضه‌کننده نرم‌افزار و مشتری می‌تواند لایه‌های متفاوت را کنترول کند؛ قرارداد باید مرز را واضح سازد.</p>
<h2>۲. هویت، دسترسی و فعالیت حساس را تعریف کنید</h2><p>هویت کاربر، authentication، بازیابی حساب، نقش، صلاحیت، حد تأیید، تفکیک وظیفه، session و دسترسی ممتاز را مشخص کنید. فعالیت پرخطر می‌تواند مطابق خطر به احراز دوباره، کنترول دوگانه، اطلاع یا log اضافی نیاز داشته باشد.</p>
<h2>۳. حفاظت و چرخه عمر معلومات را مستند کنید</h2><p>استفاده مجاز، طبقه‌بندی، محل ذخیره، انتقال، export، نگهداری، حذف، بکاپ و خروج را ثبت کنید. محل encryption و مسئول key یا credential را تعیین کنید. encryption به‌تنهایی صلاحیت زیاد یا export ناامن را حل نمی‌کند.</p>
<h2>۴. روش امن توسعه و release بخواهید</h2><ul><li>source repository کنترول‌شده و contributor مجاز</li><li>review تغییر مهم code، config و infrastructure</li><li>جدایی محیط توسعه، تست و اصلی</li><li>مدیریت secret، dependency و build artifact</li><li>تست امنیت متناسب با سیستم و خطر</li><li>release، منظوری، rollback و رسیدگی defect ثبت‌شده</li></ul><p>گزارش scanner یک شواهد است؛ اثبات آزمایش تمام خطرهای منطق تجارتی، دسترسی و عملیات نیست.</p>
<h2>۵. ارزیابی و پذیرش را تعیین کنید</h2><p>نیازمندی را به نتیجه قابل تست برای authentication، authorization، validation، session، معامله حساس، فایل، API، log، config، بکاپ و restoration تبدیل کنید. عمق تست، محیط، معلومات تست، شدت یافته، اصلاح، retest و مرجع پذیرش را مشخص سازید.</p>
<h2>۶. میزبانی، بازیابی و تداوم را یکجا طراحی کنید</h2><p>cloud، private hosting، on-premise یا hybrid را بر حساسیت، اتصال، ظرفیت داخلی، امنیت فزیکی، patch، monitoring، بکاپ، recovery، رشد و هزینه مقایسه کنید. بکاپ باید محدوده، تکرار، نگهداری، حفاظت، مالک و تست restoration داشته باشد.</p>
<h2>۷. log، monitoring و incident را آماده کنید</h2><p>رویداد مهم، دسترسی log، هماهنگی زمان، نگهداری، مالک alert و escalation را تعیین کنید. پلان incident باید triage، مهار، شواهد، restoration، ارتباط، اطلاع لازم، بررسی علت و اقدام بعدی را پوشش دهد.</p><p>زمان پاسخ تنها وقتی تعهد است که ساعت خدمت، شدت، وابستگی و روش سنجش در SLA تأییدشده باشد.</p>
<h2>۸. ادغام و dependency را بررسی کنید</h2><p>برای هر API، identity provider، payment service، دستگاه یا پلتفرم بیرونی، authentication، معلومات مجاز، validation، حجم، خطا، retry، reconciliation، monitoring، تغییر نسخه و مالک پشتیبانی را ثبت کنید.</p>
<h2>۹. نگهداری، تغییر و خروج را پلان کنید</h2><p>امنیت پس از نشر ادامه دارد. نسخه قابل پشتیبانی، patch، dependency، گزارش vulnerability، تأیید تغییر، regression، بررسی دسترسی، تست restoration و گزارش خدمت را تعیین کنید. خروج باید export، حذف، credential، domain، infrastructure، source یا licence، اسناد و یافته باز را پوشش دهد.</p>
<h2>شواهد قابل درخواست</h2><ul><li>ماتریس مسئولیت و نمای معماری یا data flow</li><li>قابلیت پیگیری نیازمندی و verification</li><li>ثبت release و change control</li><li>مدل دسترسی و نقش ممتاز</li><li>شواهد بکاپ و تست restoration</li><li>فهرست یافته با مالک و treatment</li><li>روش incident و escalation پشتیبانی</li></ul><p>شواهد باید فعلی، مرتبط و با محرمیت مناسب شریک شود. عنوان سند به‌تنهایی اثبات اجرای روش نیست.</p>
<h2>منابع اصلی این راهنما</h2><p>چک‌لیست با <a href="https://csrc.nist.gov/pubs/sp/800/218/final">NIST SP 800-218 SSDF</a>، <a href="https://www.cisa.gov/resources-tools/resources/secure-demand-guide">راهنمای Secure by Demand اداره CISA</a> و <a href="https://owasp.org/www-project-application-security-verification-standard/">معیار ASVS بنیاد OWASP</a> مقایسه شده است. این‌ها منابع مرجع است و تصدیق یا مطابقت عرضه‌کننده یا محصول را ثابت نمی‌کند.</p>
HTML,
                'ps' => <<<'HTML'
<h2>امنیتي اړتیا باید سیسټم او خطر تشریح کړي</h2><p>«سافټویر باید خوندي وي» نه په عیني ډول ډیزاین، بیه یا منل کېدای شي. سوداګریزه موخه، معلوماتي ډولونه، کاروونکي، ممتاز فعالیتونه، ځایونه، ادغامونه، انټرنېټي لاسرسی، د خدمت وابستګي، uptime او د رغونې تمې مشخصې کړئ.</p><p>هېڅ چک‌لېست یا تست نه شي ثابتولی چې سافټویر هېڅ vulnerability نه لري. موخه متناسبې لارې، د هوکړه شوو کنټرولونو تایید، د موندنو حل او مسؤل عملیات دي.</p>
<h2>۱. امنیتي او معلوماتي مسؤلیتونه وټاکئ</h2><ul><li>سوداګریز او معلوماتي مالک</li><li>د لاسرسي تاییدوونکي او ممتاز اډمینان</li><li>د پراختیا، review او release مسؤل</li><li>د کوربه‌توب، patch، monitoring او بیک‌اپ مالک</li><li>د incident، اړیکې او escalation تماس</li><li>د بهرني خدمت او ادغام مالکان</li></ul><p>cloud provider، سافټویر عرضه کوونکی او مشتری جلا لایه کنټرولولی شي؛ قرارداد باید حدود روښانه کړي.</p>
<h2>۲. هویت، لاسرسی او حساس فعالیت تعریف کړئ</h2><p>د کاروونکي هویت، authentication، د حساب رغونه، رول، صلاحیت، د تایید حد، د دندو جلاوالی، session او ممتاز لاسرسی مشخص کړئ. لوړ خطر فعالیت د بیا احراز، دوه‌ګوني کنټرول، خبرتیا یا اضافي log اړتیا لرلی شي.</p>
<h2>۳. د معلوماتو ساتنه او ژوند دوره مستنده کړئ</h2><p>مجاز استعمال، طبقه، د ذخیرې ځای، لېږد، export، ساتنه، حذف، بیک‌اپ او وتل ولیکئ. encryption او د key یا credential مسؤل وټاکئ. encryption یوازې ډېر صلاحیت یا ناامن export نه حل کوي.</p>
<h2>۴. خوندي پراختیا او release وغواړئ</h2><ul><li>کنټرول شوی source repository او مجاز contributor</li><li>د مهم code، config او infrastructure بدلون review</li><li>د پراختیا، تست او اصلي چاپېریال جلاوالی</li><li>د secret، dependency او build artifact اداره</li><li>له سیسټم او خطر سره برابر امنیتي تست</li><li>ثبت شوی release، تایید، rollback او defect treatment</li></ul><p>د scanner راپور یوازې یو شواهد دی؛ د ټولو سوداګریزو منطقونو، لاسرسي او عملیاتي خطرونو د تست ثبوت نه دی.</p>
<h2>۵. verification او منل تعریف کړئ</h2><p>اړتیاوې د authentication، authorization، validation، session، حساس معاملې، فایل، API، log، config، بیک‌اپ او restoration لپاره په تست کېدونکو پایلو بدلې کړئ. د تست ژورتیا، چاپېریال، معلومات، د موندنې شدت، اصلاح، retest او د منلو مسؤل وټاکئ.</p>
<h2>۶. کوربه‌توب، رغونه او دوام یوځای طرحه کړئ</h2><p>cloud، private hosting، on-premise یا hybrid د معلوماتو حساسیت، اتصال، داخلي ظرفیت، فزیکي امنیت، patch، monitoring، بیک‌اپ، recovery، وده او لګښت له مخې پرتله کړئ. بیک‌اپ باید حدود، تکرار، ساتنه، حفاظت، مالک او د restoration تست ولري.</p>
<h2>۷. log، monitoring او incident چمتو کړئ</h2><p>مهمې پېښې، log لاسرسی، د وخت همغږي، ساتنه، د alert مالک او escalation وټاکئ. incident پلان باید triage، مهار، شواهد، restoration، اړیکه، اړین خبر، د علت کتنه او راتلونکی اقدام پوښي.</p><p>د ځواب وخت یوازې هغه وخت ژمنه ده چې د خدمت ساعتونه، شدت، وابستګي او سنجش په تایید شوي SLA کې وي.</p>
<h2>۸. ادغامونه او dependency وڅېړئ</h2><p>د هر API، identity provider، payment service، وسیله یا بهرني پلېټفارم لپاره authentication، مجاز معلومات، validation، حجم، خطا، retry، reconciliation، monitoring، version بدلون او د ملاتړ مالک ثبت کړئ.</p>
<h2>۹. ساتنه، بدلون او وتل پلان کړئ</h2><p>امنیت تر نشر وروسته دوام کوي. ملاتړ شوې نسخه، patch، dependency، vulnerability راپور، د بدلون تایید، regression، د لاسرسي کتنه، restoration تست او د خدمت راپور وټاکئ. د وتلو پلان باید export، حذف، credential، domain، infrastructure، source یا licence، اسناد او پرانیستې موندنې پوښي.</p>
<h2>هغه شواهد چې پېرودونکی یې غوښتلی شي</h2><ul><li>د مسؤلیت matrix او د معمارۍ یا data flow لنډیز</li><li>د اړتیا او verification تعقیب</li><li>د release او change control ثبت</li><li>د لاسرسي ماډل او ممتاز رولونه</li><li>د بیک‌اپ او restoration تست شواهد</li><li>د موندنو لست له مالک او treatment سره</li><li>د incident او ملاتړ escalation کړنلاره</li></ul><p>شواهد باید اوسني، اړوند او په مناسب محرمیت شریک شي. یوازې د سند نوم د عملي کېدو ثبوت نه دی.</p>
<h2>د دې لارښود اصلي سرچینې</h2><p>چک‌لېست د <a href="https://csrc.nist.gov/pubs/sp/800/218/final">NIST SP 800-218 SSDF</a>، د CISA <a href="https://www.cisa.gov/resources-tools/resources/secure-demand-guide">Secure by Demand لارښود</a> او د OWASP <a href="https://owasp.org/www-project-application-security-verification-standard/">ASVS معیار</a> سره پرتله شوی. دا مرجع چوکاټونه دي او د عرضه کوونکي یا محصول تصدیق یا مطابقت نه ثابتوي.</p>
HTML,
            ],
            metaTitle: [
                'en' => 'Software Security Requirements Checklist | Fida',
                'fa' => 'چک‌لیست نیازمندی امنیت نرم‌افزار | فیدا',
                'ps' => 'د سافټویر امنیتي اړتیاوو چک‌لېست | فیدا',
            ],
            metaDescription: [
                'en' => 'A practical checklist for software security requirements, access, data, secure development, verification, hosting, recovery and support.',
                'fa' => 'چک‌لیست عملی امنیت نرم‌افزار؛ دسترسی، معلومات، توسعه امن، ارزیابی، میزبانی، بازیابی و پشتیبانی.',
                'ps' => 'د سافټویر امنیت عملي چک‌لېست؛ لاسرسی، معلومات، خوندي پراختیا، تایید، کوربه‌توب، رغونه او ملاتړ.',
            ],
            primaryQuery: [
                'en' => 'software security requirements checklist Afghanistan',
                'fa' => 'چک‌لیست نیازمندی امنیت نرم‌افزار افغانستان',
                'ps' => 'د سافټویر امنیتي اړتیاوو چک‌لېست افغانستان',
            ],
            faqs: [
                $this->faq('Can a supplier guarantee that software has no vulnerabilities?', 'No responsible test or process can prove the absence of every vulnerability. A buyer should require proportionate secure-development practices, verification evidence, finding treatment and ongoing maintenance responsibilities.', 'آیا عرضه‌کننده نبود آسیب‌پذیری را تضمین می‌کند؟', 'هیچ تست یا روند مسئولانه نبود تمام آسیب‌پذیری را ثابت نمی‌کند. خریدار باید روش توسعه امن، شواهد ارزیابی، رسیدگی یافته و مسئولیت نگهداری متناسب بخواهد.', 'ایا عرضه کوونکی د ټولو vulnerability د نشتون ضمانت کولی شي؟', 'هېڅ مسؤل تست یا بهیر د هر vulnerability نشتون نه شي ثابتولی. پېرودونکی باید متناسبه خوندي پراختیا، د تایید شواهد، د موندنو حل او د ساتنې مسؤلیت وغواړي.'),
                $this->faq('Is cloud hosting automatically more secure than on-premise hosting?', 'No. Security depends on architecture, configuration, data, access, provider controls, client capacity, monitoring, patching, backup, recovery and clearly allocated responsibilities.', 'آیا cloud به شکل خودکار امن‌تر از on-premise است؟', 'خیر. امنیت به معماری، تنظیم، معلومات، دسترسی، کنترول provider، ظرفیت مشتری، monitoring، patch، بکاپ، recovery و مسئولیت روشن وابسته است.', 'ایا cloud hosting په اتومات ډول له on-premise خوندي دی؟', 'نه. امنیت په معمارۍ، تنظیم، معلوماتو، لاسرسي، provider کنټرول، د مشتری ظرفیت، monitoring، patch، بیک‌اپ، recovery او روښانه مسؤلیت پورې تړلی دی.'),
                $this->faq('Is a vulnerability scan enough for security acceptance?', 'No. Scanning can support verification, but access control, business logic, configuration, integrations, recovery and operational responsibilities also require appropriate evidence and testing.', 'آیا vulnerability scan برای پذیرش امنیت کافی است؟', 'خیر. scan به ارزیابی کمک می‌کند؛ اما کنترول دسترسی، منطق تجارتی، config، ادغام، recovery و مسئولیت عملیاتی نیز شواهد و تست مناسب می‌خواهد.', 'ایا vulnerability scan د امنیت منلو لپاره کافي دی؟', 'نه. scan له تایید سره مرسته کوي؛ خو د لاسرسي کنټرول، سوداګریز منطق، config، ادغام، recovery او عملیاتي مسؤلیت هم مناسب شواهد او تست غواړي.'),
                $this->faq('Who is responsible for software security after launch?', 'Responsibility is shared across the parties that control the application, hosting, identities, devices, data, integrations and operations. The contract and operating plan should allocate each duty explicitly.', 'پس از نشر مسئول امنیت کیست؟', 'مسئولیت میان طرف‌هایی شریک است که نرم‌افزار، میزبانی، هویت، دستگاه، معلومات، ادغام و عملیات را کنترول می‌کنند. قرارداد باید هر وظیفه را واضح تعیین کند.', 'تر نشر وروسته د امنیت مسؤل څوک دی؟', 'مسؤلیت د هغو خواوو ترمنځ شریک دی چې اپلېکېشن، کوربه‌توب، هویت، وسایل، معلومات، ادغام او عملیات کنټرولوي. قرارداد باید هره دنده روښانه وټاکي.'),
            ],
            relatedSlugs: ['software-security-hosting-afghanistan', 'software-training-support-afghanistan', 'software-integration-api-development-afghanistan'],
            sortOrder: 80,
        );
    }

    private function article(
        string $slug,
        ?int $categoryId,
        array $title,
        array $eyebrow,
        array $summary,
        array $body,
        array $metaTitle,
        array $metaDescription,
        array $primaryQuery,
        array $faqs,
        array $relatedSlugs,
        int $sortOrder,
    ): array {
        return [
            'type' => 'article',
            'article_category_id' => $categoryId,
            'slug' => $slug,
            'title' => $title,
            'eyebrow' => $eyebrow,
            'summary' => $summary,
            'body' => $body,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'primary_query' => $primaryQuery,
            'search_intent' => 'informational',
            'robots_directive' => 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
            'sitemap_included' => true,
            'sitemap_priority' => 0.7,
            'sitemap_change_frequency' => 'monthly',
            'metadata' => [
                'faqs' => $faqs,
                'related_slugs' => $relatedSlugs,
            ],
            'status' => 'published',
            'featured' => true,
            'sort_order' => $sortOrder,
            'published_at' => now(),
        ];
    }

    private function faq(
        string $questionEn,
        string $answerEn,
        string $questionFa,
        string $answerFa,
        string $questionPs,
        string $answerPs,
    ): array {
        return [
            'question' => ['en' => $questionEn, 'fa' => $questionFa, 'ps' => $questionPs],
            'answer' => ['en' => $answerEn, 'fa' => $answerFa, 'ps' => $answerPs],
        ];
    }
}
