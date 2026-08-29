<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class EnterpriseSolutionLibrarySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            ContentPage::query()->firstOrCreate(['slug' => $page['slug']], $page);
        }
    }

    private function pages(): array
    {
        return [
            $this->hrmis(),
            $this->procurementInventory(),
            $this->documentWorkflow(),
            $this->businessIntelligence(),
        ];
    }

    private function hrmis(): array
    {
        return $this->page(
            slug: 'hrmis-payroll-software-afghanistan',
            title: [
                'en' => 'HRMIS & Payroll Software in Afghanistan',
                'fa' => 'نرم‌افزار HRMIS و معاشات در افغانستان',
                'ps' => 'په افغانستان کې د HRMIS او معاشونو سافټویر',
            ],
            eyebrow: [
                'en' => 'People, positions, attendance and payroll control',
                'fa' => 'کنترول کارمند، بست، حاضری و معاش',
                'ps' => 'د کارکوونکو، بستونو، حاضري او معاش کنټرول',
            ],
            summary: [
                'en' => 'Connect employee records, positions, contracts, attendance, leave, approved payroll inputs and management reporting in one controlled HR platform.',
                'fa' => 'سوابق کارمند، بست، قرارداد، حاضری، رخصتی، ورودی‌های تأییدشده معاش و گزارش مدیریتی را در یک پلتفرم کنترول‌شده وصل کنید.',
                'ps' => 'د کارکوونکو ثبتونه، بستونه، قراردادونه، حاضري، رخصتي، تایید شوي معاشي معلومات او مدیریتي راپورونه په یوه کنټرول شوي پلېټفارم کې ونښلوئ.',
            ],
            body: [
                'en' => <<<'HTML'
<h2>HRMIS should connect employment decisions to payroll evidence</h2><p>A useful HRMIS is more than an employee directory. It should preserve the authorized path from an approved position and employment record through attendance, leave, adjustments, payroll review, payment instruction and financial posting where those functions are included.</p><p>Employment, tax, pension, benefit and payroll rules must be approved by the organization’s qualified HR, finance and legal professionals. Software applies configured rules; it does not create legal policy.</p>
<h2>Authoritative people and position records</h2><ul><li>Organization structure, departments, locations and reporting lines</li><li>Approved positions, grades, employment types and vacancies</li><li>Employee identity, contacts, contracts and effective dates</li><li>Job history, transfers, promotions and separation records</li><li>Documents, qualifications and controlled expiry reminders</li><li>Emergency contacts and other approved personnel fields</li></ul><p>The organization should define the authoritative identifier, duplicate-checking method, document access and owner of each sensitive record.</p>
<h2>Recruitment and onboarding boundaries</h2><p>Where included, the workflow can record an approved vacancy, candidate stages, assessment, offer approval and onboarding checklist. Recruitment decisions remain with authorized people. Sensitive candidate information should have purpose, access and retention boundaries.</p>
<h2>Attendance, shifts and leave</h2><p>The design can support manual attendance, approved devices or fingerprint integrations, shifts, holidays, overtime, field work, absence, leave balance and correction requests. Every input needs an owner, effective time, approval and exception process.</p><p>A device log is evidence of an event; it is not automatically a final payable attendance decision. HR policies determine how lateness, overtime, leave, travel and exceptions are treated.</p>
<h2>Controlled payroll preparation</h2><p>Payroll can connect authorized salary components, allowances, deductions, attendance effects, advances, loans or benefits according to approved rules. A repeatable cycle should cover input freeze, validation, calculation, exception review, approval, payment output and posting.</p><ul><li>Effective-dated salary and component changes</li><li>Maker-checker review for sensitive adjustments</li><li>Variance comparison with the previous approved period</li><li>Employee-level detail and summarized control totals</li><li>Restricted payment files and payroll reports</li><li>Correction, reversal and rerun procedures</li></ul>
<h2>Employee and manager self-service</h2><p>Approved self-service may allow employees to update selected information, request leave, view attendance, receive approved documents or review payslips. Managers can review only the teams and actions within their authority. The scope should distinguish requests from final HR records.</p>
<h2>Security, privacy and accountability</h2><p>Personnel and payroll information is sensitive. The solution should define role-based access, privileged administration, approval history, data exports, document protection, retention, backups and incident responsibilities. Reports should minimize unnecessary personal data and record material access where required.</p>
<h2>Implementation and migration</h2><p>Implementation begins with the approved organization structure, policies, payroll calendar, components, attendance sources, responsibilities and reports. Migration should reconcile employee identity, active status, opening leave or loan balances, salary components and other included data with authorized owners before production use.</p>
<h2>Management reporting without bypassing professional review</h2><p>Reports can cover headcount, position occupancy, contract status, attendance exceptions, leave, payroll variance, cost by unit and approved workforce indicators. Definitions and access must be documented so the same indicator means the same thing across HR, finance and management.</p>
<h2>Planning reference</h2><p>The operating model was cross-checked against public-sector HRMIS control objectives described in a <a href="https://www.worldbank.org/en/news/press-release/2022/12/08/-20-million-grant-to-improve-fiscal-and-human-resource-management-in-guinea-bissau">World Bank HRMIS programme</a>, including establishment headcount, duplicate control and payroll oversight. This reference is not a claim that Fida participated in that programme or that its rules apply to an Afghan organization.</p>
HTML,
                'fa' => <<<'HTML'
<h2>HRMIS باید تصمیم استخدام را به شواهد معاش وصل کند</h2><p>HRMIS مفید تنها فهرست کارمندان نیست. سیستم باید مسیر مجاز را از بست و ثبت استخدام تأییدشده تا حاضری، رخصتی، تعدیل، بررسی معاش، هدایت پرداخت و ثبت مالی حفظ کند.</p><p>قواعد استخدام، مالیه، تقاعد، امتیاز و معاش باید توسط متخصصان مجاز منابع بشری، مالی و حقوقی سازمان تأیید شود. نرم‌افزار پالیسی حقوقی ایجاد نمی‌کند.</p>
<h2>ثبت معتبر کارمند و بست</h2><ul><li>ساختار سازمان، بخش، موقعیت و سلسله گزارش</li><li>بست تأییدشده، رتبه، نوع استخدام و جای خالی</li><li>هویت، تماس، قرارداد و تاریخ مؤثر کارمند</li><li>تاریخ وظیفه، تبدیلی، ترفیع و ختم کار</li><li>اسناد، تحصیلات و یادآوری انقضای کنترول‌شده</li><li>تماس اضطراری و سایر فیلدهای تأییدشده</li></ul><p>شناسه مرجع، روش تشخیص تکرار، دسترسی سند و مالک معلومات حساس باید مشخص باشد.</p>
<h2>استخدام و onboarding</h2><p>در صورت شمول، روند می‌تواند بست منظورشده، مراحل نامزد، ارزیابی، منظوری offer و چک‌لیست onboarding را ثبت کند. تصمیم استخدام با مسئولان مجاز می‌ماند و معلومات نامزد باید هدف، دسترسی و مدت نگهداری روشن داشته باشد.</p>
<h2>حاضری، شیفت و رخصتی</h2><p>سیستم می‌تواند حاضری دستی، دستگاه یا fingerprint تأییدشده، شیفت، رخصتی عمومی، اضافه‌کاری، کار ساحوی، غیابت، بیلانس رخصتی و درخواست اصلاح را پشتیبانی کند. هر ورودی مسئول، زمان مؤثر، تأیید و روش استثنا می‌خواهد.</p><p>log دستگاه یک شواهد است؛ به‌صورت خودکار تصمیم نهایی قابل پرداخت نیست.</p>
<h2>آماده‌سازی کنترول‌شده معاش</h2><p>معاش می‌تواند اجزای تأییدشده، امتیاز، کسر، اثر حاضری، پیش‌پرداخت، قرض و benefit را مطابق قواعد مصوب وصل کند. دوره باید freeze ورودی، validation، محاسبه، بررسی استثنا، منظوری، فایل پرداخت و posting را پوشش دهد.</p><ul><li>تغییر معاش با تاریخ مؤثر</li><li>maker-checker برای تعدیل حساس</li><li>مقایسه variance با دوره قبلی</li><li>تفصیل کارمند و control total</li><li>فایل محدود پرداخت و گزارش معاش</li><li>اصلاح، reversal و rerun</li></ul>
<h2>self-service کارمند و مدیر</h2><p>self-service تأییدشده می‌تواند ویرایش معلومات انتخابی، درخواست رخصتی، مشاهده حاضری، سند و payslip را فراهم کند. مدیر تنها تیم و اقدام داخل صلاحیت را می‌بیند. درخواست باید از ثبت نهایی HR جدا باشد.</p>
<h2>امنیت، محرمیت و حساب‌دهی</h2><p>معلومات پرسونل و معاش حساس است. دسترسی نقش‌محور، ادمین ممتاز، تاریخ تأیید، export، حفاظت سند، نگهداری، بکاپ و incident باید تعریف شود. گزارش‌ها نباید معلومات شخصی غیرضروری را نمایش دهد.</p>
<h2>تطبیق و انتقال</h2><p>تطبیق با ساختار، پالیسی، تقویم معاش، اجزا، منبع حاضری، مسئولیت و گزارش تأییدشده آغاز می‌شود. هویت، حالت فعال، بیلانس رخصتی یا قرض و اجزای معاش پیش از نشر باید reconciliation و sign-off شود.</p>
<h2>گزارش مدیریتی</h2><p>گزارش می‌تواند headcount، اشغال بست، قرارداد، استثنای حاضری، رخصتی، variance معاش، هزینه واحد و شاخص نیروی کار را پوشش دهد. تعریف و دسترسی شاخص باید میان HR، مالی و مدیریت یکسان باشد.</p>
<h2>مرجع پلان‌گذاری</h2><p>مدل با اهداف کنترول HRMIS در یک <a href="https://www.worldbank.org/en/news/press-release/2022/12/08/-20-million-grant-to-improve-fiscal-and-human-resource-management-in-guinea-bissau">برنامه بانک جهانی</a> درباره headcount، کنترول تکرار و نظارت معاش مقایسه شده است. این منبع به معنی اشتراک فیدا یا قابل اجرا بودن قواعد آن در افغانستان نیست.</p>
HTML,
                'ps' => <<<'HTML'
<h2>HRMIS باید د استخدام پرېکړه د معاش له شواهدو سره ونښلوي</h2><p>ګټور HRMIS یوازې د کارکوونکو لست نه دی. سیسټم باید له تایید شوي بست او استخدامي ثبت څخه تر حاضري، رخصتي، تعدیل، د معاش کتنې، د تادیې لارښوونې او مالي ثبت پورې مجاز لاره وساتي.</p><p>د استخدام، مالیې، تقاعد، امتیاز او معاش قواعد باید د ادارې مجاز HR، مالي او حقوقي متخصصین تایید کړي. سافټویر حقوقي پالیسي نه جوړوي.</p>
<h2>باوري کارکوونکي او بست ثبتونه</h2><ul><li>اداري جوړښت، څانګې، ځایونه او د راپور سلسله</li><li>تایید شوي بستونه، رتبې، د استخدام ډول او خالي بست</li><li>هویت، تماس، قرارداد او مؤثرې نېټې</li><li>د دندې تاریخ، تبدیلی، ترفیع او ختم</li><li>اسناد، تحصیلات او د ختمېدو کنټرول شوې خبرتیا</li><li>بیړنی تماس او نور تایید شوي فیلډونه</li></ul><p>مرجع شناسه، د تکرار کتنه، د سند لاسرسی او د حساسو معلوماتو مالک باید مشخص وي.</p>
<h2>استخدام او onboarding</h2><p>که شامل وي، بهیر د منظور شوي بست، نوماند پړاوونه، ارزونه، offer تایید او onboarding چک‌لېست ثبتوي. استخدامي پرېکړه له مجاز کسانو سره پاتې کېږي او د نوماند معلومات موخه، لاسرسی او ساتنې موده غواړي.</p>
<h2>حاضري، shift او رخصتي</h2><p>سیسټم د لاسي حاضري، تایید شوي device یا fingerprint ادغام، shift، عمومي رخصتي، overtime، ساحوي کار، غیابت، رخصتي بیلانس او اصلاح غوښتنه ملاتړولی شي. هر input مسؤل، مؤثر وخت، تایید او د استثنا لاره غواړي.</p><p>د device log یوازې شواهد دی؛ په اتومات ډول د تادیې وروستۍ پرېکړه نه ده.</p>
<h2>کنټرول شوې معاش چمتو کول</h2><p>معاش د تایید شوي salary component، allowance، deduction، د حاضري اغېز، advance، loan او benefit سره د مصوبو قواعدو مطابق نښلېدای شي. دوره باید input freeze، validation، محاسبه، د استثنا کتنه، تایید، د تادیې output او posting پوښي.</p><ul><li>له مؤثرې نېټې سره د معاش بدلون</li><li>د حساسو تعدیلونو maker-checker</li><li>له پخوانۍ دورې سره variance</li><li>د کارکوونکي تفصیل او control total</li><li>محدود تادیاتي فایل او معاش راپور</li><li>اصلاح، reversal او rerun</li></ul>
<h2>د کارکوونکي او مدیر self-service</h2><p>تایید شوی self-service د ټاکلو معلوماتو بدلون، د رخصتۍ غوښتنه، حاضري، اسناد او payslip ښودلی شي. مدیر یوازې د خپل صلاحیت ټیم او اقدام ویني. غوښتنه باید له وروستي HR ثبت څخه جلا وي.</p>
<h2>امنیت، محرمیت او حساب ورکونه</h2><p>پرسونل او معاش معلومات حساس دي. رول‌محور لاسرسی، ممتاز اډمین، د تایید تاریخ، export، د سند ساتنه، retention، بیک‌اپ او incident مسؤلیتونه باید تعریف شي. راپور باید غیرضروري شخصي معلومات ونه ښيي.</p>
<h2>پلي کول او لېږد</h2><p>پلي کول له تایید شوي جوړښت، پالیسي، معاش تقویم، اجزاوو، حاضري سرچینې، مسؤلیت او راپورونو پیلېږي. هویت، فعال حالت، د رخصتۍ یا پور بیلانس او معاشي اجزا باید تر نشر مخکې reconciliation او sign-off شي.</p>
<h2>مدیریتي راپورونه</h2><p>راپورونه headcount، د بست اشغال، قرارداد، د حاضري استثنا، رخصتي، معاش variance، د واحد لګښت او کاري ځواک شاخصونه پوښلی شي. تعریف او لاسرسی باید د HR، مالي او مدیریت ترمنځ یو شان وي.</p>
<h2>د پلان مرجع</h2><p>ماډل د <a href="https://www.worldbank.org/en/news/press-release/2022/12/08/-20-million-grant-to-improve-fiscal-and-human-resource-management-in-guinea-bissau">نړیوال بانک د HRMIS پروګرام</a> له headcount، تکرار کنټرول او معاش څارنې موخو سره پرتله شوی. دا سرچینه نه د فیدا د ګډون ادعا ده او نه یې قواعد په افغانستان کې حتمي دي.</p>
HTML,
            ],
            metaTitle: ['en' => 'HRMIS & Payroll Software Afghanistan | Fida', 'fa' => 'نرم‌افزار HRMIS و معاشات افغانستان | فیدا', 'ps' => 'د HRMIS او معاشونو سافټویر افغانستان | فیدا'],
            metaDescription: ['en' => 'HRMIS and payroll software for employee, position, attendance, leave, approved payroll, self-service and workforce reporting workflows.', 'fa' => 'HRMIS و معاشات برای کارمند، بست، حاضری، رخصتی، معاش تأییدشده، self-service و گزارش نیروی کار.', 'ps' => 'د کارکوونکو، بستونو، حاضري، رخصتي، تایید شوي معاش، self-service او کاري ځواک راپورونو لپاره HRMIS.'],
            primaryQuery: ['en' => 'HRMIS payroll software Afghanistan', 'fa' => 'نرم‌افزار HRMIS و معاشات افغانستان', 'ps' => 'د HRMIS او معاشونو سافټویر افغانستان'],
            faqs: [
                $this->faq('Can HRMIS connect attendance with payroll?', 'Yes, when attendance rules, approved sources, exceptions, effective dates and review responsibilities are documented. Device events should not bypass authorized HR and payroll approval.', 'آیا HRMIS حاضری را به معاش وصل می‌کند؟', 'بلی، وقتی قواعد حاضری، منبع تأییدشده، استثنا، تاریخ مؤثر و مسئول بررسی مستند باشد. log دستگاه نباید تأیید HR و معاش را دور بزند.', 'ایا HRMIS حاضري له معاش سره نښلوي؟', 'هو، کله چې د حاضري قواعد، تایید شوې سرچینه، استثنا، مؤثره نېټه او د کتنې مسؤلیت مستند وي. د device پېښه باید د HR او معاش تایید تېر نه کړي.'),
                $this->faq('Does the system decide employment or payroll law?', 'No. Authorized HR, finance and legal professionals must approve applicable employment, tax, pension, benefit and payroll rules. The system applies the configured policy.', 'آیا سیستم قانون کار یا معاش را تعیین می‌کند؟', 'خیر. متخصصان مجاز HR، مالی و حقوقی باید قواعد کار، مالیه، تقاعد، امتیاز و معاش را تأیید کنند. سیستم پالیسی تنظیم‌شده را اجرا می‌کند.', 'ایا سیسټم د استخدام یا معاش قانون ټاکي؟', 'نه. مجاز HR، مالي او حقوقي متخصصین باید د کار، مالیې، تقاعد، امتیاز او معاش قواعد تایید کړي. سیسټم تنظیم شوې پالیسي عملي کوي.'),
                $this->faq('Can fingerprint attendance be integrated?', 'An approved attendance device may be integrated after its API, identity matching, connectivity, duplicate handling, time rules, security and support ownership are reviewed.', 'آیا حاضری fingerprint قابل ادغام است؟', 'دستگاه تأییدشده پس از بررسی API، تطبیق هویت، اتصال، تکرار، قواعد زمان، امنیت و مسئول پشتیبانی قابل ادغام است.', 'ایا fingerprint حاضري ادغامېدای شي؟', 'تایید شوی device د API، هویت mapping، اتصال، تکرار، وخت قواعد، امنیت او د ملاتړ مالک له کتنې وروسته ادغامېدای شي.'),
                $this->faq('What should be migrated into an HRMIS?', 'The approved scope may include active employee and position records, contracts, effective-dated components, leave or loan balances and selected history. Business owners must validate each domain.', 'چه معلوماتی به HRMIS انتقال شود؟', 'محدوده می‌تواند کارمند و بست فعال، قرارداد، اجزای تاریخ‌دار، بیلانس رخصتی یا قرض و تاریخچه انتخابی را شامل کند. مالک تجارتی باید هر بخش را تأیید کند.', 'HRMIS ته کوم معلومات ولېږدول شي؟', 'حدود کې فعال کارکوونکي او بستونه، قراردادونه، د نېټې اجزا، د رخصتۍ یا پور بیلانس او ټاکلی تاریخ شاملېدای شي. سوداګریز مالک باید هره برخه تایید کړي.'),
                $this->faq('Can employees access their own information?', 'Role-based self-service can be included for approved fields, requests, attendance, documents and payslips. The organization defines which actions are requests and which update the authoritative record.', 'آیا کارمند به معلومات خود دسترسی دارد؟', 'self-service نقش‌محور برای فیلد، درخواست، حاضری، سند و payslip تأییدشده ممکن است. سازمان مشخص می‌کند کدام اقدام درخواست و کدام تغییر ثبت رسمی است.', 'ایا کارکوونکی خپلو معلوماتو ته لاسرسی لري؟', 'رول‌محور self-service د تایید شوو فیلډونو، غوښتنو، حاضري، اسنادو او payslip لپاره شاملېدای شي. اداره ټاکي چې کوم کار غوښتنه او کوم رسمي بدلون دی.'),
                $this->faq('How is an HRMIS implementation priced?', 'Pricing depends on organizations, locations, users, modules, payroll rules, attendance devices, migration, integrations, languages, hosting, training and support scope.', 'قیمت تطبیق HRMIS چگونه است؟', 'قیمت به واحد، موقعیت، کاربر، ماژول، قواعد معاش، دستگاه حاضری، انتقال، ادغام، زبان، میزبانی، آموزش و پشتیبانی وابسته است.', 'د HRMIS پلي کولو بیه څنګه ټاکل کېږي؟', 'بیه په ادارو، ځایونو، کاروونکو، ماډیولونو، معاش قواعدو، حاضري وسایلو، لېږد، ادغام، ژبو، کوربه‌توب، روزنې او ملاتړ پورې تړلې ده.'),
            ],
            relatedSlugs: ['erp-systems-afghanistan', 'government-public-sector-software-afghanistan', 'ngo-ingo-software-afghanistan'],
            profile: $this->profile(
                ['en' => 'Authoritative people and position records', 'fa' => 'ثبت معتبر کارمند و بست', 'ps' => 'باوري کارکوونکي او بست ثبتونه'],
                ['en' => 'Approved employment-to-payroll changes', 'fa' => 'تغییر تأییدشده از استخدام تا معاش', 'ps' => 'له استخدام تر معاش تایید شوي بدلونونه'],
                ['en' => 'Workforce, attendance and payroll oversight', 'fa' => 'نظارت نیروی کار، حاضری و معاش', 'ps' => 'د کاري ځواک، حاضري او معاش څارنه'],
                [['Employee records', 'سوابق کارمند', 'د کارکوونکو ثبت'], ['Positions & contracts', 'بست و قرارداد', 'بستونه او قراردادونه'], ['Attendance & leave', 'حاضری و رخصتی', 'حاضري او رخصتي'], ['Payroll controls', 'کنترول معاش', 'د معاش کنټرول'], ['Self-service', 'self-service', 'self-service'], ['Workforce reporting', 'گزارش نیروی کار', 'د کاري ځواک راپور']],
            ),
            sortOrder: 20,
        );
    }

    private function procurementInventory(): array
    {
        return $this->page(
            slug: 'procurement-inventory-management-software-afghanistan',
            title: [
                'en' => 'Procurement & Inventory Management Software in Afghanistan',
                'fa' => 'نرم‌افزار مدیریت تدارکات و موجودی در افغانستان',
                'ps' => 'په افغانستان کې د تدارکاتو او موجودۍ مدیریت سافټویر',
            ],
            eyebrow: [
                'en' => 'From approved demand to received and reconciled stock',
                'fa' => 'از تقاضای تأییدشده تا موجودی دریافت و تطبیق‌شده',
                'ps' => 'له تایید شوې اړتیا تر ترلاسه او تصفیه شوې موجودۍ',
            ],
            summary: [
                'en' => 'Connect requisitions, approvals, sourcing, purchase orders, receipts, warehouses, inventory movements, invoice matching and management reporting.',
                'fa' => 'درخواست، منظوری، منبع‌یابی، سفارش خرید، دریافت، گدام، حرکت موجودی، تطبیق بل و گزارش مدیریتی را وصل کنید.',
                'ps' => 'غوښتنې، تایید، سرچینه موندنه، پېر امر، ترلاسه کول، ګدام، موجودي حرکت، د بل تصفیه او مدیریتي راپورونه ونښلوئ.',
            ],
            body: [
                'en' => <<<'HTML'
<h2>One traceable path from need to stock</h2><p>Procurement and inventory control works when an approved need remains connected to sourcing, commitment, receipt, inspection, stock movement, supplier invoice and accounting. The design should expose exceptions without allowing users to erase the evidence behind them.</p><p>The organization’s authorized procurement, finance, legal and technical teams approve applicable policy, thresholds, evaluation methods and contract terms. Software enforces configured controls; it does not create procurement law.</p>
<h2>Demand, approval and sourcing</h2><ul><li>Requisitions with purpose, quantity, specification, budget and required date</li><li>Approval paths based on organization, amount, category or project</li><li>Requests for quotation and controlled supplier responses where included</li><li>Evaluation records, declared conflicts and approval of the selected source</li><li>Purchase orders, amendments, cancellation and remaining commitment</li></ul><p>Urgent and exceptional purchases need an explicit route, reason and retrospective review rather than an invisible bypass.</p>
<h2>Supplier and item master data</h2><p>Supplier identities, contacts, status, tax or banking details and supporting documents should have owners and change approval. Items need consistent codes, descriptions, units, categories and permitted substitutes so purchasing and warehouse records describe the same thing.</p>
<h2>Receiving, inspection and returns</h2><p>A receipt should reference the order, receiving location, quantity, date and responsible user. Inspection, acceptance, rejection, damage, short delivery and returns require recorded status and evidence. Service acceptance can use milestones or deliverables instead of physical stock.</p>
<h2>Warehouse and inventory control</h2><ul><li>Locations, bins and accountable custodians</li><li>Receipts, issues, transfers, adjustments and cycle counts</li><li>Reorder, minimum, maximum and availability views</li><li>Lot, serial or expiry control where the material requires it</li><li>Reservations and project, department or cost-center attribution</li><li>Reconciliation between physical count and system balance</li></ul>
<h2>Invoice matching and financial integration</h2><p>The agreed process may compare purchase order, accepted receipt and supplier invoice before payment approval. Tolerances, tax treatment, prepayments, landed cost, returns and accounting entries need qualified owners. Exceptions should remain visible until resolved.</p>
<h2>Implementation, migration and reporting</h2><p>Implementation defines the approval matrix, procurement methods, catalog, warehouses, opening balances, valuation approach, integrations and reports. Migration needs item and supplier deduplication, unit conversion, open-order review and signed opening-stock reconciliation.</p><p>Reporting can cover cycle time, open commitments, supplier performance, stock availability, ageing, movement, variances, expiry exposure and consumption. Each measure needs an owner and documented calculation.</p>
<h2>Planning references</h2><p>The workflow was cross-checked against Microsoft’s public <a href="https://learn.microsoft.com/en-us/dynamics365/supply-chain/procurement/procurement-sourcing-overview">procurement and sourcing overview</a> and <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/business-processes/inventory-to-deliver-overview">inventory-to-deliver guidance</a>. These are general process references, not product affiliation or rules for an Afghan organization.</p>
HTML,
                'fa' => <<<'HTML'
<h2>یک مسیر قابل پیگیری از نیاز تا موجودی</h2><p>کنترول تدارکات و موجودی زمانی مؤثر است که نیاز تأییدشده به منبع‌یابی، تعهد، دریافت، تفتیش، حرکت موجودی، بل تأمین‌کننده و حسابداری وصل بماند. استثنا باید دیده شود و شواهد آن حذف نشود.</p><p>تیم‌های مجاز تدارکات، مالی، حقوقی و تخنیکی پالیسی، حد صلاحیت، روش ارزیابی و شرایط قرارداد را تأیید می‌کنند. نرم‌افزار قانون تدارکات ایجاد نمی‌کند.</p>
<h2>تقاضا، منظوری و منبع‌یابی</h2><ul><li>درخواست با هدف، مقدار، مشخصات، بودجه و تاریخ نیاز</li><li>مسیر منظوری بر اساس واحد، مبلغ، کتگوری یا پروژه</li><li>درخواست قیمت و پاسخ کنترول‌شده تأمین‌کننده</li><li>ثبت ارزیابی، تضاد منافع و منظوری انتخاب</li><li>سفارش خرید، تعدیل، لغو و تعهد باقی‌مانده</li></ul><p>خرید عاجل یا استثنایی باید مسیر، دلیل و بررسی بعدی روشن داشته باشد.</p>
<h2>ثبت تأمین‌کننده و قلم</h2><p>هویت، تماس، حالت، معلومات مالی و اسناد تأمین‌کننده مالک و منظوری تغییر می‌خواهد. قلم‌ها باید کود، شرح، واحد، کتگوری و بدیل یکسان داشته باشند.</p>
<h2>دریافت، تفتیش و برگشت</h2><p>دریافت باید سفارش، موقعیت، مقدار، تاریخ و مسئول را ثبت کند. قبول، رد، خساره، کمبود و برگشت حالت و شواهد می‌خواهد. خدمات می‌تواند با milestone یا deliverable پذیرفته شود.</p>
<h2>کنترول گدام و موجودی</h2><ul><li>موقعیت، bin و متصدی مسئول</li><li>دریافت، مصرف، انتقال، تعدیل و شمارش دوره‌ای</li><li>نقطه سفارش و موجودی قابل استفاده</li><li>lot، serial یا expiry در صورت نیاز</li><li>رزرو و نسبت به پروژه یا cost center</li><li>تطبیق شمارش فزیکی با بیلانس سیستم</li></ul>
<h2>تطبیق بل و اتصال مالی</h2><p>روند می‌تواند سفارش، دریافت پذیرفته‌شده و بل را پیش از منظوری پرداخت مقایسه کند. tolerance، مالیه، پیش‌پرداخت، landed cost، برگشت و ثبت حسابداری مسئول متخصص می‌خواهد.</p>
<h2>تطبیق، انتقال و گزارش</h2><p>تطبیق matrix منظوری، روش خرید، catalog، گدام، opening balance، valuation، integration و گزارش را تعریف می‌کند. انتقال نیازمند پاک‌کاری قلم و تأمین‌کننده، تبدیل واحد، بررسی سفارش باز و sign-off موجودی آغاز است.</p><p>گزارش می‌تواند زمان دوره، تعهد باز، عملکرد تأمین‌کننده، موجودی، ageing، حرکت، تفاوت، expiry و مصرف را پوشش دهد.</p>
<h2>مراجع پلان‌گذاری</h2><p>روند با راهنمای عمومی Microsoft درباره <a href="https://learn.microsoft.com/en-us/dynamics365/supply-chain/procurement/procurement-sourcing-overview">تدارکات و منبع‌یابی</a> و <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/business-processes/inventory-to-deliver-overview">موجودی تا تحویل</a> مقایسه شده است. این منابع وابستگی محصول یا قانون افغانستان نیست.</p>
HTML,
                'ps' => <<<'HTML'
<h2>له اړتیا تر موجودۍ یوه د تعقیب وړ لاره</h2><p>تدارکات او موجودي هغه وخت کنټرولېږي چې تایید شوې اړتیا له سرچینې، ژمنې، ترلاسه کولو، تفتیش، موجودي حرکت، عرضه کوونکي بل او حسابدارۍ سره تړلې پاتې شي. استثنا باید ښکاره او شواهد یې خوندي وي.</p><p>مجاز تدارکاتي، مالي، حقوقي او تخنیکي ټیمونه پالیسي، صلاحیت حد، ارزونه او قرارداد تاییدوي. سافټویر د تدارکاتو قانون نه جوړوي.</p>
<h2>غوښتنه، تایید او سرچینه موندنه</h2><ul><li>غوښتنه له موخې، مقدار، مشخصاتو، بودجې او اړینې نېټې سره</li><li>د ادارې، مبلغ، کتګورۍ یا پروژې له مخې تایید</li><li>د نرخ غوښتنه او کنټرول شوی ځواب</li><li>د ارزونې، د ګټو ټکر او انتخاب ثبت</li><li>پېر امر، تعدیل، لغوه کول او پاتې ژمنه</li></ul><p>عاجل یا استثنايي پېر باید روښانه لاره، دلیل او وروسته کتنه ولري.</p>
<h2>د عرضه کوونکي او توکي ثبت</h2><p>د عرضه کوونکي هویت، تماس، حالت، مالي معلومات او اسناد مالک او د بدلون تایید غواړي. توکي باید یو شان کوډ، تشریح، واحد، کتګوري او بدیل ولري.</p>
<h2>ترلاسه کول، تفتیش او بېرته سپارل</h2><p>ترلاسه کول باید امر، ځای، مقدار، نېټه او مسؤل ثبت کړي. منل، رد، زیان، کموالی او بېرته سپارل حالت او شواهد غواړي. خدمت د milestone یا deliverable له مخې منل کېدای شي.</p>
<h2>د ګدام او موجودۍ کنټرول</h2><ul><li>ځایونه، bin او مسؤل ساتونکي</li><li>رسید، مصرف، انتقال، تعدیل او دوره‌یي شمېرنه</li><li>د بیا غوښتنې حد او شته موجودي</li><li>lot، serial یا expiry که توکی یې غواړي</li><li>reservation او پروژه یا cost center</li><li>د فزیکي شمېر او سیسټم بیلانس تصفیه</li></ul>
<h2>د بل تصفیه او مالي ادغام</h2><p>بهیر د تادیې تر تایید مخکې پېر امر، منل شوی رسید او بل پرتله کولی شي. tolerance، مالیه، advance، landed cost، بېرته سپارل او حسابداري ثبت مسلکي مالک غواړي.</p>
<h2>پلي کول، لېږد او راپور</h2><p>پلي کول د تایید matrix، پېر طریقې، catalog، ګدامونه، پرانیستونکي بیلانسونه، valuation، ادغام او راپورونه تعریفوي. لېږد د توکو او عرضه کوونکو پاکول، واحد بدلون، خلاص امر کتنه او د پیل موجودۍ sign-off غواړي.</p><p>راپور د دورې وخت، خلاصې ژمنې، عرضه کوونکي فعالیت، موجودي، ageing، حرکت، توپیر، expiry او مصرف ښودلی شي.</p>
<h2>د پلان مراجع</h2><p>بهیر د Microsoft عمومي <a href="https://learn.microsoft.com/en-us/dynamics365/supply-chain/procurement/procurement-sourcing-overview">تدارکاتو او سرچینې</a> او <a href="https://learn.microsoft.com/en-us/dynamics365/guidance/business-processes/inventory-to-deliver-overview">موجودۍ تر سپارلو</a> لارښود سره پرتله شوی. دا نه د محصول اړیکه ده او نه د افغانستان قانون.</p>
HTML,
            ],
            metaTitle: ['en' => 'Procurement & Inventory Software Afghanistan | Fida', 'fa' => 'نرم‌افزار تدارکات و موجودی افغانستان | فیدا', 'ps' => 'د تدارکاتو او موجودۍ سافټویر افغانستان | فیدا'],
            metaDescription: ['en' => 'Procurement and inventory software for requisitions, sourcing, purchase orders, receiving, warehouses, stock control and invoice matching.', 'fa' => 'نرم‌افزار تدارکات و موجودی برای درخواست، منبع‌یابی، سفارش، دریافت، گدام، کنترول stock و تطبیق بل.', 'ps' => 'د غوښتنو، سرچینې، پېر امر، ترلاسه کولو، ګدام، موجودي کنټرول او بل تصفیې لپاره سافټویر.'],
            primaryQuery: ['en' => 'procurement inventory management software Afghanistan', 'fa' => 'نرم‌افزار مدیریت تدارکات و موجودی افغانستان', 'ps' => 'د تدارکاتو او موجودۍ مدیریت سافټویر افغانستان'],
            faqs: [
                $this->faq('Can the system enforce procurement approvals?', 'It can route and record configured approvals by organization, value, category, project or other approved criteria. Authorized professionals define the policy and exceptions.', 'آیا سیستم منظوری تدارکات را تطبیق می‌کند؟', 'سیستم می‌تواند منظوری تنظیم‌شده را بر اساس واحد، مبلغ، کتگوری، پروژه یا معیار تأییدشده ثبت و مسیر دهد. متخصصان مجاز پالیسی و استثنا را تعیین می‌کنند.', 'ایا سیسټم تدارکاتي تایید عملي کوي؟', 'سیسټم د ادارې، مبلغ، کتګورۍ، پروژې یا تایید شوي معیار له مخې منظوري ثبت او مسیر کوي. مجاز متخصصین پالیسي او استثنا ټاکي.'),
                $this->faq('Can purchase orders, receipts and invoices be matched?', 'Yes, if the approved process, tolerances, acceptance evidence, tax treatment and exception ownership are defined. Service and goods workflows may differ.', 'آیا سفارش، دریافت و بل تطبیق می‌شود؟', 'بلی، اگر روند، tolerance، شواهد قبول، مالیه و مسئول استثنا تعریف شود. روند خدمت و جنس می‌تواند متفاوت باشد.', 'ایا پېر امر، رسید او بل تصفیه کېږي؟', 'هو، که بهیر، tolerance، د منلو شواهد، مالیه او د استثنا مالک تعریف شي. د خدمت او توکي بهیر توپیر کولی شي.'),
                $this->faq('Does inventory support lots, serials or expiry?', 'These controls can be included for applicable item categories after identification, receiving, issue, recall and counting rules are agreed.', 'آیا موجودی lot، serial و expiry دارد؟', 'برای کتگوری لازم، پس از توافق قواعد شناسه، دریافت، مصرف، recall و شمارش قابل شمول است.', 'ایا موجودي lot، serial او expiry لري؟', 'د اړینو کتګوریو لپاره د پېژندنې، رسید، مصرف، recall او شمېر قواعدو له توافق وروسته شاملېدای شي.'),
                $this->faq('Can multiple warehouses and projects be managed?', 'The solution can separate locations, custodians and access while attributing reservations, issues and costs to approved projects, departments or cost centers.', 'آیا چند گدام و پروژه مدیریت می‌شود؟', 'سیستم می‌تواند موقعیت، متصدی و دسترسی را جدا و رزرو، مصرف و هزینه را به پروژه، بخش یا cost center نسبت دهد.', 'ایا څو ګدامونه او پروژې اداره کېږي؟', 'سیسټم ځایونه، ساتونکي او لاسرسی جلا او reservation، مصرف او لګښت تایید شوې پروژې، څانګې یا cost center ته اړوند کولی شي.'),
                $this->faq('What data is needed for migration?', 'Typical inputs include approved suppliers, items, units, warehouses, opening stock, open purchase orders and selected history. Each balance needs an accountable owner and reconciliation.', 'برای انتقال چه معلومات لازم است؟', 'معمولاً تأمین‌کننده، قلم، واحد، گدام، موجودی آغاز، سفارش باز و تاریخچه انتخابی لازم است. هر بیلانس مالک و reconciliation می‌خواهد.', 'د لېږد لپاره کوم معلومات پکار دي؟', 'عموماً عرضه کوونکي، توکي، واحدونه، ګدامونه، پیل موجودي، خلاص امرونه او ټاکلی تاریخ پکار دی. هر بیلانس مالک او تصفیه غواړي.'),
                $this->faq('How is procurement and inventory software priced?', 'Pricing depends on organizations, approval complexity, sourcing, warehouses, item controls, users, integrations, migration, hosting, training and support.', 'قیمت نرم‌افزار چگونه تعیین می‌شود؟', 'قیمت به واحد، پیچیدگی منظوری، منبع‌یابی، گدام، کنترول قلم، کاربر، ادغام، انتقال، میزبانی، آموزش و پشتیبانی وابسته است.', 'د سافټویر بیه څنګه ټاکل کېږي؟', 'بیه په ادارو، د تایید پیچلتیا، سرچینې، ګدامونو، توکي کنټرول، کاروونکو، ادغام، لېږد، کوربه‌توب، روزنې او ملاتړ پورې تړلې ده.'),
            ],
            relatedSlugs: ['erp-systems-afghanistan', 'government-public-sector-software-afghanistan', 'manufacturing-erp-software-afghanistan'],
            profile: $this->profile(
                ['en' => 'A traceable need-to-stock record', 'fa' => 'ثبت قابل پیگیری از نیاز تا موجودی', 'ps' => 'له اړتیا تر موجودۍ د تعقیب وړ ثبت'],
                ['en' => 'Approved purchasing and inventory movements', 'fa' => 'خرید و حرکت موجودی تأییدشده', 'ps' => 'تایید شوي پېر او موجودي حرکتونه'],
                ['en' => 'Supplier, stock, commitment and cost visibility', 'fa' => 'دید تأمین‌کننده، موجودی، تعهد و هزینه', 'ps' => 'د عرضه کوونکي، موجودۍ، ژمنې او لګښت لید'],
                [['Requisitions & approvals', 'درخواست و منظوری', 'غوښتنې او تایید'], ['Sourcing & purchase orders', 'منبع‌یابی و سفارش', 'سرچینه او پېر امر'], ['Receiving & inspection', 'دریافت و تفتیش', 'ترلاسه کول او تفتیش'], ['Warehouse control', 'کنترول گدام', 'د ګدام کنټرول'], ['Invoice matching', 'تطبیق بل', 'د بل تصفیه'], ['Stock reporting', 'گزارش موجودی', 'د موجودۍ راپور']],
            ),
            sortOrder: 30,
        );
    }

    private function documentWorkflow(): array
    {
        return $this->page(
            slug: 'document-management-workflow-system-afghanistan',
            title: [
                'en' => 'Document Management & Workflow System in Afghanistan',
                'fa' => 'سیستم مدیریت اسناد و جریان کار در افغانستان',
                'ps' => 'په افغانستان کې د اسنادو مدیریت او کاري بهیر سیسټم',
            ],
            eyebrow: [
                'en' => 'Authoritative records, controlled actions and accountable retention',
                'fa' => 'اسناد معتبر، اقدام کنترول‌شده و نگهداری حساب‌ده',
                'ps' => 'باوري اسناد، کنټرول شوي اقدامونه او حساب‌ورکوونکې ساتنه',
            ],
            summary: [
                'en' => 'Control document capture, classification, versions, access, review, approval, search, retention, disposition and audit evidence.',
                'fa' => 'دریافت، طبقه‌بندی، نسخه، دسترسی، بررسی، منظوری، جستجو، نگهداری، تعیین تکلیف و شواهد audit اسناد را کنترول کنید.',
                'ps' => 'د اسنادو ترلاسه کول، طبقه‌بندي، نسخې، لاسرسی، کتنه، تایید، لټون، ساتنه، تعیین او audit شواهد کنټرول کړئ.',
            ],
            body: [
                'en' => <<<'HTML'
<h2>A document system is more than shared file storage</h2><p>A controlled document and records system should show what the record is, who owns it, which version is authoritative, who may act on it and what must happen at the end of its approved lifecycle. Folders alone rarely provide that accountability.</p><p>Authorized records, legal, compliance and business professionals must approve classification, privacy, evidentiary, retention, disposition and transfer requirements. The system applies those rules; it does not decide legal obligations.</p>
<h2>Capture, classification and metadata</h2><p>Records may enter through upload, controlled scanning, email, forms, integrations or generated output. Required metadata can include reference, type, owner, unit, date, subject, confidentiality, related case and retention class. Duplicate, quality and completeness checks should occur before a record becomes authoritative.</p>
<h2>Version and access control</h2><ul><li>Draft, review, approved, superseded and archived status</li><li>Major and minor versions with change notes where required</li><li>Role, unit, case or classification-based access</li><li>Restricted download, print, share and export options</li><li>Privileged administration and material access logging</li><li>Controlled external collaboration when approved</li></ul><p>Users should know whether they are reading a working copy or the approved record.</p>
<h2>Workflow, review and approval</h2><p>A workflow can assign steps, due dates, delegation, comments, returns, escalation and final approval. It should preserve the actor, time, decision and version reviewed. An electronic approval is not automatically a legally recognized digital signature; applicable requirements must be confirmed by qualified professionals.</p>
<h2>Search and controlled retrieval</h2><p>Users can search permitted metadata and, when suitable, indexed content. Saved views, filters, case files and related-record links reduce repeated copies. Search must respect access rights and avoid exposing sensitive snippets.</p>
<h2>Retention, disposition and transfer</h2><p>Records move through active use, inactive retention, hold, approved destruction or archival transfer according to an authorized schedule. Disposition needs eligibility calculation, review, approval, evidence and suspension when a hold applies. Backups are not a substitute for retention and disposition control.</p>
<h2>Implementation, migration and continuity</h2><p>Implementation begins with the record inventory, taxonomy, roles, workflows, retention schedule, integrations and service levels. Migration should map owners, dates, versions, permissions and retention classes, while identifying duplicates and unsupported formats. The exit plan should cover export with usable content, metadata and audit evidence.</p>
<h2>Operational reporting</h2><p>Dashboards can show intake, workflow status, overdue actions, approval time, access exceptions, disposition eligibility and transfer completion. Measures should support responsible action rather than encouraging users to close tasks without completing the required review.</p>
<h2>Records-management reference</h2><p>The lifecycle was cross-checked against the US National Archives’ public <a href="https://www.archives.gov/records-mgmt/policy/universalermrequirements">Universal Electronic Records Management Requirements</a>, which cover capture, maintenance and use, disposal, transfer, metadata and reporting. This is a general design reference, not Afghan law or a certification claim.</p>
HTML,
                'fa' => <<<'HTML'
<h2>سیستم سند بیشتر از ذخیره فایل مشترک است</h2><p>سیستم کنترول‌شده باید نشان دهد سند چیست، مالک آن کیست، کدام نسخه معتبر است، چه کسی اقدام می‌کند و در پایان دوره تأییدشده چه می‌شود. فولدر به‌تنهایی این حساب‌دهی را فراهم نمی‌کند.</p><p>متخصصان مجاز اسناد، حقوقی، compliance و تجارتی باید طبقه‌بندی، محرمیت، شواهد، نگهداری، disposal و انتقال را تأیید کنند. سیستم تعهد حقوقی را تعیین نمی‌کند.</p>
<h2>دریافت، طبقه‌بندی و metadata</h2><p>سند می‌تواند از upload، scan کنترول‌شده، ایمیل، form، integration یا خروجی سیستم وارد شود. metadata می‌تواند reference، نوع، مالک، واحد، تاریخ، موضوع، محرمیت، دوسیه و retention class را شامل کند. پیش از معتبر شدن، تکرار، کیفیت و تکمیل باید بررسی شود.</p>
<h2>کنترول نسخه و دسترسی</h2><ul><li>حالت draft، review، approved، superseded و archive</li><li>نسخه major و minor با یادداشت تغییر</li><li>دسترسی بر اساس نقش، واحد، دوسیه یا طبقه</li><li>کنترول download، print، share و export</li><li>ادمین ممتاز و ثبت دسترسی مهم</li><li>همکاری بیرونی کنترول‌شده در صورت تأیید</li></ul><p>کاربر باید بداند نسخه کاری می‌بیند یا سند تأییدشده.</p>
<h2>جریان کار، بررسی و منظوری</h2><p>workflow می‌تواند مرحله، مهلت، delegation، comment، برگشت، escalation و منظوری نهایی را مدیریت کند و شخص، زمان، تصمیم و نسخه بررسی‌شده را نگه دارد. منظوری الکترونیکی خودکار معادل امضای دیجیتال قانونی نیست.</p>
<h2>جستجو و دریافت کنترول‌شده</h2><p>کاربر metadata مجاز و در صورت مناسب متن index‌شده را جستجو می‌کند. view، filter، دوسیه و لینک سند مرتبط از کاپی تکراری می‌کاهد. search باید صلاحیت را رعایت کند.</p>
<h2>نگهداری، disposal و انتقال</h2><p>سند مطابق schedule تأییدشده از استفاده فعال به نگهداری غیرفعال، hold، destruction منظورشده یا archive transfer می‌رود. disposal محاسبه، review، approval، شواهد و توقف در حالت hold می‌خواهد. backup جای retention control را نمی‌گیرد.</p>
<h2>تطبیق، انتقال و تداوم</h2><p>تطبیق با inventory سند، taxonomy، نقش، workflow، schedule، integration و SLA آغاز می‌شود. انتقال باید مالک، تاریخ، نسخه، permission و retention class را map و تکرار یا format نامناسب را مشخص کند. exit plan باید content، metadata و audit را قابل استفاده صادر کند.</p>
<h2>گزارش عملیاتی</h2><p>dashboard می‌تواند intake، حالت workflow، اقدام overdue، زمان منظوری، استثنای دسترسی، eligibility برای disposal و تکمیل transfer را نشان دهد.</p>
<h2>مرجع مدیریت اسناد</h2><p>دوره حیات با <a href="https://www.archives.gov/records-mgmt/policy/universalermrequirements">الزامات عمومی مدیریت اسناد الکترونیکی</a> آرشیف ملی امریکا درباره capture، استفاده، disposal، transfer، metadata و reporting مقایسه شده است. این منبع قانون افغانستان یا certification نیست.</p>
HTML,
                'ps' => <<<'HTML'
<h2>د اسنادو سیسټم له ګډ file storage څخه ډېر دی</h2><p>کنټرول شوی سیسټم باید وښيي چې سند څه دی، مالک یې څوک دی، کومه نسخه باوري ده، څوک اقدام کولی شي او د تایید شوي ژوند په پای کې څه ورسره کېږي. یوازې folder دا حساب‌ورکونه نه برابروي.</p><p>مجاز records، حقوقي، compliance او سوداګریز متخصصین باید طبقه‌بندي، محرمیت، شواهد، ساتنه، disposal او transfer تایید کړي. سیسټم حقوقي مکلفیت نه ټاکي.</p>
<h2>ترلاسه کول، طبقه‌بندي او metadata</h2><p>سند د upload، کنټرول شوي scan، ایمیل، form، integration یا سیسټم output له لارې راتللی شي. metadata کې reference، ډول، مالک، واحد، نېټه، موضوع، محرمیت، دوسیه او retention class شاملېدای شي. تر باوري کېدو مخکې تکرار، کیفیت او بشپړتیا باید وکتل شي.</p>
<h2>د نسخې او لاسرسي کنټرول</h2><ul><li>draft، review، approved، superseded او archive حالت</li><li>major او minor نسخه له بدلون یادښت سره</li><li>د رول، واحد، دوسیې یا طبقه له مخې لاسرسی</li><li>download، print، share او export کنټرول</li><li>ممتاز اډمین او د مهم لاسرسي ثبت</li><li>تایید شوې بهرنۍ همکاري</li></ul><p>کاروونکی باید پوه شي چې کاري نسخه ویني که تایید شوی سند.</p>
<h2>کاري بهیر، کتنه او تایید</h2><p>workflow پړاو، مهلت، delegation، comment، بېرته ستنول، escalation او وروستی تایید اداره کوي او شخص، وخت، پرېکړه او کتل شوې نسخه ساتي. برېښنايي تایید په اتومات ډول قانوني digital signature نه دی.</p>
<h2>لټون او کنټرول شوی ترلاسه کول</h2><p>کاروونکی مجاز metadata او که مناسب وي indexed متن لټوي. view، filter، دوسیه او د اړوند سند لینک تکراري کاپي کموي. search باید صلاحیت مراعات کړي.</p>
<h2>ساتنه، disposal او transfer</h2><p>سند د تایید شوي schedule له مخې له فعال کارونې غیرفعال ساتنې، hold، منظور شوي destruction یا archive transfer ته ځي. disposal eligibility، review، approval، شواهد او د hold پر مهال ځنډ غواړي. backup د retention کنټرول بدیل نه دی.</p>
<h2>پلي کول، لېږد او دوام</h2><p>پلي کول د سند inventory، taxonomy، رولونو، workflow، schedule، integration او SLA سره پیلېږي. لېږد باید مالک، نېټه، نسخه، permission او retention class map او تکرار یا نامناسب format وښيي. exit plan باید content، metadata او audit د کار وړ صادر کړي.</p>
<h2>عملیاتي راپور</h2><p>dashboard intake، workflow حالت، overdue اقدام، د تایید وخت، د لاسرسي استثنا، disposal eligibility او transfer بشپړتیا ښودلی شي.</p>
<h2>د اسنادو مدیریت مرجع</h2><p>د ژوند دوره د امریکا ملي آرشیف له <a href="https://www.archives.gov/records-mgmt/policy/universalermrequirements">عمومي برېښنايي اسنادو اړتیاوو</a> سره د capture، کارونې، disposal، transfer، metadata او reporting په برخه کې پرتله شوې. دا د افغانستان قانون یا certification نه دی.</p>
HTML,
            ],
            metaTitle: ['en' => 'Document Management & Workflow Afghanistan | Fida', 'fa' => 'سیستم مدیریت اسناد و جریان کار افغانستان | فیدا', 'ps' => 'د اسنادو مدیریت او کاري بهیر افغانستان | فیدا'],
            metaDescription: ['en' => 'Document management and workflow for capture, classification, versions, access, approval, search, retention, disposition and audit evidence.', 'fa' => 'مدیریت اسناد و workflow برای دریافت، طبقه‌بندی، نسخه، دسترسی، منظوری، search، retention، disposal و audit.', 'ps' => 'د capture، طبقه‌بندۍ، نسخې، لاسرسي، تایید، search، retention، disposal او audit لپاره د اسنادو سیستم.'],
            primaryQuery: ['en' => 'document management workflow system Afghanistan', 'fa' => 'سیستم مدیریت اسناد و جریان کار افغانستان', 'ps' => 'د اسنادو مدیریت او کاري بهیر سیسټم افغانستان'],
            faqs: [
                $this->faq('How is a document management system different from shared folders?', 'It adds authoritative metadata, version status, controlled access, workflow evidence, retention, disposition and auditability around approved records.', 'سیستم مدیریت اسناد چه تفاوتی با فولدر مشترک دارد؟', 'metadata معتبر، حالت نسخه، دسترسی کنترول‌شده، شواهد workflow، retention، disposal و audit را به اسناد تأییدشده اضافه می‌کند.', 'د اسنادو سیسټم له ګډو folderونو څه توپیر لري؟', 'باوري metadata، د نسخې حالت، کنټرول شوی لاسرسی، workflow شواهد، retention، disposal او audit ورزیاتوي.'),
                $this->faq('Can review and approval workflows be configured?', 'Yes. Steps, roles, due dates, delegation, return, escalation and approval evidence can follow an authorized process and preserve the version reviewed.', 'آیا workflow بررسی و منظوری تنظیم می‌شود؟', 'بلی. مرحله، نقش، مهلت، delegation، برگشت، escalation و شواهد منظوری مطابق روند مجاز تنظیم و نسخه بررسی‌شده حفظ می‌شود.', 'ایا د کتنې او تایید workflow تنظیمېږي؟', 'هو. پړاوونه، رولونه، مهلت، delegation، بېرته ستنول، escalation او شواهد د مجاز بهیر مطابق تنظیم او کتل شوې نسخه ساتل کېږي.'),
                $this->faq('Does electronic approval equal a legal digital signature?', 'Not automatically. Qualified legal and records professionals must determine signature, identity, evidentiary and retention requirements for the applicable document and jurisdiction.', 'آیا منظوری الکترونیکی همان امضای دیجیتال قانونی است؟', 'خودکار نه. متخصص حقوقی و اسناد باید الزامات امضا، هویت، شواهد و نگهداری را برای سند و حوزه مربوط تعیین کند.', 'ایا برېښنايي تایید قانوني digital signature دی؟', 'په اتومات ډول نه. حقوقي او اسنادو متخصصین باید د سند او صلاحیت لپاره د لاسلیک، هویت، شواهدو او ساتنې اړتیاوې وټاکي.'),
                $this->faq('Can scanned and email records be captured?', 'They can be included with approved scanning quality, indexing, duplicate, malware, mailbox, ownership and classification controls.', 'آیا scan و ایمیل ثبت می‌شود؟', 'با کنترول تأییدشده کیفیت scan، indexing، تکرار، malware، mailbox، مالکیت و طبقه‌بندی قابل شمول است.', 'ایا scan او ایمیل ثبتېږي؟', 'د تایید شوي scan کیفیت، indexing، تکرار، malware، mailbox، مالکیت او طبقه‌بندۍ کنټرول سره شاملېدای شي.'),
                $this->faq('How are retention and deletion controlled?', 'An authorized schedule determines retention, holds, review, destruction or archival transfer. The system should preserve approval and disposition evidence.', 'نگهداری و حذف چگونه کنترول می‌شود؟', 'schedule مجاز retention، hold، review، destruction یا archive transfer را تعیین می‌کند و سیستم شواهد منظوری و disposal را حفظ می‌کند.', 'ساتنه او حذف څنګه کنټرولېږي؟', 'مجاز schedule retention، hold، review، destruction یا archive transfer ټاکي او سیسټم د تایید او disposal شواهد ساتي.'),
                $this->faq('How is document management priced?', 'Pricing depends on users, repositories, storage, workflows, scanning, integrations, migration volume, security, hosting, training, retention and support scope.', 'قیمت سیستم اسناد چگونه تعیین می‌شود؟', 'قیمت به کاربر، repository، storage، workflow، scanning، integration، حجم انتقال، امنیت، hosting، آموزش، retention و support وابسته است.', 'د اسنادو سیسټم بیه څنګه ټاکل کېږي؟', 'بیه په کاروونکو، repository، storage، workflow، scanning، integration، لېږد حجم، امنیت، hosting، روزنې، retention او support پورې تړلې ده.'),
            ],
            relatedSlugs: ['custom-software-development-afghanistan', 'government-public-sector-software-afghanistan', 'ngo-ingo-software-afghanistan'],
            profile: $this->profile(
                ['en' => 'Authoritative and searchable records', 'fa' => 'اسناد معتبر و قابل جستجو', 'ps' => 'باوري او د لټون وړ اسناد'],
                ['en' => 'Version, access, approval and retention control', 'fa' => 'کنترول نسخه، دسترسی، منظوری و نگهداری', 'ps' => 'د نسخې، لاسرسي، تایید او ساتنې کنټرول'],
                ['en' => 'Workload, status, overdue and disposition oversight', 'fa' => 'نظارت کار، حالت، تأخیر و disposal', 'ps' => 'د کار، حالت، ځنډ او disposal څارنه'],
                [['Capture & metadata', 'دریافت و metadata', 'capture او metadata'], ['Version control', 'کنترول نسخه', 'د نسخې کنټرول'], ['Review & approval', 'بررسی و منظوری', 'کتنه او تایید'], ['Secure search', 'جستجوی امن', 'خوندي لټون'], ['Retention & disposition', 'نگهداری و disposal', 'retention او disposal'], ['Audit reporting', 'گزارش audit', 'د audit راپور']],
            ),
            sortOrder: 40,
        );
    }

    private function businessIntelligence(): array
    {
        return $this->page(
            slug: 'business-intelligence-reporting-afghanistan',
            title: [
                'en' => 'Business Intelligence & Reporting in Afghanistan',
                'fa' => 'هوش تجارتی و گزارش‌دهی در افغانستان',
                'ps' => 'په افغانستان کې سوداګریز هوښیارتیا او راپور ورکول',
            ],
            eyebrow: [
                'en' => 'Owned definitions, trusted data and decision-ready reporting',
                'fa' => 'تعریف دارای مالک، معلومات معتبر و گزارش آماده تصمیم',
                'ps' => 'مالک لرونکي تعریفونه، باوري معلومات او پرېکړې ته چمتو راپورونه',
            ],
            summary: [
                'en' => 'Design governed metrics, source integrations, quality controls, dashboards, reports, validation and controlled analytics releases.',
                'fa' => 'شاخص دارای حاکمیت، اتصال منبع، کنترول کیفیت، dashboard، گزارش، validation و نشر کنترول‌شده analytics را طراحی کنید.',
                'ps' => 'حاکمیت لرونکي شاخصونه، سرچینې ادغام، کیفیت کنټرول، dashboard، راپور، validation او کنټرول شوې analytics نشر طرحه کړئ.',
            ],
            body: [
                'en' => <<<'HTML'
<h2>Business intelligence starts with decisions, not charts</h2><p>A useful BI programme identifies the decisions, responsible roles, definitions, source evidence and action expected from each measure before choosing a visualization. A polished dashboard cannot compensate for disputed definitions or incomplete source records.</p><p>Business owners approve metric meaning and action. Data owners approve sources and quality rules. Security owners approve access. Qualified finance, programme, clinical or other professionals validate domain calculations.</p>
<h2>Metric definitions and ownership</h2><ul><li>Business question, purpose and accountable owner</li><li>Calculation, numerator, denominator, filters and exclusions</li><li>Time period, cutoff, currency, unit and organizational scope</li><li>Source system, field lineage and refresh expectation</li><li>Quality threshold, exception route and sign-off</li><li>Audience, access and permitted export</li></ul><p>A shared glossary and governed semantic layer reduce conflicting versions of the same indicator.</p>
<h2>Source integration and data quality</h2><p>Sources may include ERP, MIS, CRM, spreadsheets, databases or authorized APIs. The design should profile completeness, validity, uniqueness, timeliness and reconciliation before publication. Corrections belong in the accountable source process where possible, not as hidden dashboard adjustments.</p>
<h2>Dashboards, reports and analysis</h2><p>Executives may need trends and exceptions; operational teams need queues and drill-through; analysts may need governed detail. The solution can combine scorecards, tables, charts, filters, scheduled reports and approved exports while preserving definitions and access.</p><p>“Real time” should not be promised unless source availability, connectivity, refresh architecture, latency and operational support can sustain it. Each output should display its data period and last successful refresh.</p>
<h2>Security and accountable use</h2><p>Access can follow organization, location, project, role or data classification. Row-level restrictions, privileged administration, sharing, subscriptions and exports require testing. Aggregation does not automatically remove privacy or confidentiality risk.</p>
<h2>Validation and controlled release</h2><p>Development, test and production content should be separated where the platform supports it. Validation compares representative outputs with approved source evidence, tests filters and security, records discrepancies and obtains business sign-off. Release notes, rollback and ownership reduce unmanaged dashboard changes.</p>
<h2>Monitoring, change and continuity</h2><p>Operations should monitor refresh failures, source schema changes, gateway or integration health, usage, slow reports and stale content. Changes to a definition need impact analysis, approval, effective date and communication. Exports, documentation and source mappings support continuity and exit.</p>
<h2>Analytics planning references</h2><p>The approach was cross-checked against Microsoft’s public Power BI guidance for <a href="https://learn.microsoft.com/en-us/power-bi/guidance/powerbi-implementation-planning-bi-strategy-bi-solution-planning">BI solution planning</a>, <a href="https://learn.microsoft.com/en-us/power-bi/guidance/powerbi-implementation-planning-content-lifecycle-management-plan-design">content lifecycle management</a> and <a href="https://learn.microsoft.com/en-us/power-bi/guidance/powerbi-implementation-planning-content-lifecycle-management-validate">validation</a>. These are general planning references, not a product-affiliation or certification claim.</p>
HTML,
                'fa' => <<<'HTML'
<h2>هوش تجارتی با تصمیم آغاز می‌شود، نه chart</h2><p>برنامه مفید BI پیش از انتخاب visualization، تصمیم، مسئول، تعریف، شواهد منبع و اقدام مورد انتظار هر شاخص را مشخص می‌کند. dashboard زیبا تعریف مورد اختلاف یا منبع ناقص را اصلاح نمی‌کند.</p><p>مالک تجارتی معنی و اقدام شاخص، مالک data منبع و کیفیت، مالک امنیت دسترسی و متخصص مالی، برنامه، صحی یا بخش مربوط محاسبه را تأیید می‌کند.</p>
<h2>تعریف و مالکیت شاخص</h2><ul><li>پرسش تجارتی، هدف و مالک پاسخگو</li><li>محاسبه، numerator، denominator، filter و exclusion</li><li>دوره، cutoff، ارز، واحد و محدوده سازمان</li><li>سیستم منبع، lineage فیلد و refresh</li><li>حد کیفیت، مسیر استثنا و sign-off</li><li>مخاطب، دسترسی و export مجاز</li></ul><p>glossary مشترک و semantic layer دارای حاکمیت از نسخه‌های متضاد یک شاخص می‌کاهد.</p>
<h2>اتصال منبع و کیفیت معلومات</h2><p>منبع می‌تواند ERP، MIS، CRM، spreadsheet، database یا API مجاز باشد. تکمیل، اعتبار، یگانگی، به‌موقع بودن و reconciliation باید پیش از نشر ارزیابی شود. اصلاح تا حد ممکن در روند منبع انجام شود، نه adjustment پنهان dashboard.</p>
<h2>dashboard، گزارش و تحلیل</h2><p>مدیر به trend و exception، تیم عملیاتی به queue و drill-through و analyst به تفصیل دارای حاکمیت نیاز دارد. scorecard، table، chart، filter، گزارش زمان‌بندی‌شده و export مجاز می‌تواند یکجا شود.</p><p>«real time» تنها زمانی وعده شود که منبع، اتصال، refresh، latency و support آن را تحمل کند. هر خروجی باید دوره data و آخرین refresh موفق را نشان دهد.</p>
<h2>امنیت و استفاده حساب‌ده</h2><p>دسترسی می‌تواند بر اساس واحد، موقعیت، پروژه، نقش یا classification باشد. row-level security، ادمین، sharing، subscription و export باید test شود. aggregate همیشه خطر محرمیت را حذف نمی‌کند.</p>
<h2>validation و نشر کنترول‌شده</h2><p>development، test و production باید در صورت امکان جدا باشد. validation خروجی را با شواهد منبع مقایسه، filter و security را test، اختلاف را ثبت و sign-off تجارتی را می‌گیرد. release note، rollback و مالکیت تغییر بی‌رویه را کم می‌کند.</p>
<h2>monitoring، تغییر و تداوم</h2><p>عملیات باید failure refresh، تغییر schema منبع، سلامت integration، استفاده، گزارش کند و محتوای stale را نظارت کند. تغییر تعریف impact analysis، منظوری، تاریخ مؤثر و ارتباط می‌خواهد.</p>
<h2>مراجع پلان‌گذاری analytics</h2><p>رویکرد با راهنمای عمومی Microsoft برای <a href="https://learn.microsoft.com/en-us/power-bi/guidance/powerbi-implementation-planning-bi-strategy-bi-solution-planning">پلان BI</a>، <a href="https://learn.microsoft.com/en-us/power-bi/guidance/powerbi-implementation-planning-content-lifecycle-management-plan-design">چرخه content</a> و <a href="https://learn.microsoft.com/en-us/power-bi/guidance/powerbi-implementation-planning-content-lifecycle-management-validate">validation</a> مقایسه شده است. این وابستگی محصول یا certification نیست.</p>
HTML,
                'ps' => <<<'HTML'
<h2>سوداګریز هوښیارتیا له پرېکړې پیلېږي، نه له chart</h2><p>ګټور BI پروګرام د visualization تر ټاکلو مخکې د هر شاخص پرېکړه، مسؤل رول، تعریف، سرچینې شواهد او تمه شوی اقدام معلوموي. ښکلی dashboard لانجمن تعریف یا نیمګړې سرچینه نه سموي.</p><p>سوداګریز مالک د شاخص مانا او اقدام، data مالک سرچینه او کیفیت، امنیت مالک لاسرسی او مالي، پروګرامي، روغتیايي یا بل متخصص محاسبه تاییدوي.</p>
<h2>د شاخص تعریف او مالکیت</h2><ul><li>سوداګریزه پوښتنه، موخه او حساب‌ورکوونکی مالک</li><li>محاسبه، numerator، denominator، filter او exclusion</li><li>دوره، cutoff، اسعار، واحد او اداري حدود</li><li>سرچینه، field lineage او refresh تمه</li><li>د کیفیت حد، استثنا لاره او sign-off</li><li>مخاطب، لاسرسی او مجاز export</li></ul><p>ګډ glossary او حاکمیت لرونکی semantic layer د یوه شاخص متضادې نسخې کموي.</p>
<h2>د سرچینې ادغام او د معلوماتو کیفیت</h2><p>سرچینه ERP، MIS، CRM، spreadsheet، database یا مجاز API کېدای شي. بشپړتیا، اعتبار، یکتایي، پر وخت والي او reconciliation باید تر نشر مخکې وارزول شي. اصلاح تر ممکنه په مسؤلې سرچینې کې وشي، نه د dashboard په پټ adjustment کې.</p>
<h2>dashboard، راپور او تحلیل</h2><p>مشران trend او exception، عملیاتي ټیمونه queue او drill-through او analyst حاکمیت لرونکی تفصیل غواړي. scorecard، table، chart، filter، وختي راپور او مجاز export یوځای کېدای شي.</p><p>«real time» باید یوازې هغه وخت ژمنه شي چې سرچینه، اتصال، refresh، latency او support یې وساتي. هر output باید data دوره او وروستی بریالی refresh وښيي.</p>
<h2>امنیت او حساب‌ورکوونکې کارونه</h2><p>لاسرسی د ادارې، ځای، پروژې، رول یا classification له مخې کېدای شي. row-level security، اډمین، sharing، subscription او export باید وازمویل شي. aggregate تل د محرمیت خطر نه ختموي.</p>
<h2>validation او کنټرول شوی نشر</h2><p>development، test او production باید چې امکان وي جلا وي. validation output له سرچینې شواهدو سره پرتله، filter او security ازمويي، توپیر ثبتوي او سوداګریز sign-off اخلي. release note، rollback او مالکیت بې‌کنټروله بدلون کموي.</p>
<h2>monitoring، بدلون او دوام</h2><p>عملیات باید refresh failure، د سرچینې schema بدلون، integration روغتیا، کارونه، ورو راپورونه او stale content وڅاري. د تعریف بدلون impact analysis، تایید، مؤثره نېټه او خبرتیا غواړي.</p>
<h2>د analytics پلان مراجع</h2><p>لار د Microsoft له عمومي <a href="https://learn.microsoft.com/en-us/power-bi/guidance/powerbi-implementation-planning-bi-strategy-bi-solution-planning">BI پلان</a>، <a href="https://learn.microsoft.com/en-us/power-bi/guidance/powerbi-implementation-planning-content-lifecycle-management-plan-design">content lifecycle</a> او <a href="https://learn.microsoft.com/en-us/power-bi/guidance/powerbi-implementation-planning-content-lifecycle-management-validate">validation</a> لارښود سره پرتله شوې. دا د محصول اړیکه یا certification نه دی.</p>
HTML,
            ],
            metaTitle: ['en' => 'Business Intelligence & Reporting Afghanistan | Fida', 'fa' => 'هوش تجارتی و گزارش‌دهی افغانستان | فیدا', 'ps' => 'سوداګریز هوښیارتیا او راپور ورکول افغانستان | فیدا'],
            metaDescription: ['en' => 'Business intelligence and reporting for governed metrics, source integration, data quality, dashboards, security, validation and controlled releases.', 'fa' => 'BI و reporting برای شاخص دارای حاکمیت، integration، کیفیت data، dashboard، امنیت، validation و نشر کنترول‌شده.', 'ps' => 'د حاکمیت شاخصونو، integration، data کیفیت، dashboard، امنیت، validation او کنټرول شوي نشر لپاره BI.'],
            primaryQuery: ['en' => 'business intelligence reporting Afghanistan', 'fa' => 'هوش تجارتی و گزارش‌دهی افغانستان', 'ps' => 'سوداګریز هوښیارتیا او راپور ورکول افغانستان'],
            faqs: [
                $this->faq('Can BI combine data from multiple systems?', 'Yes, after source ownership, interfaces, identifiers, mapping, refresh, quality, security and reconciliation requirements are verified.', 'آیا BI معلومات چند سیستم را یکجا می‌کند؟', 'بلی، پس از تأیید مالک منبع، interface، شناسه، mapping، refresh، کیفیت، امنیت و reconciliation.', 'ایا BI د څو سیسټمونو معلومات یوځای کوي؟', 'هو، د سرچینې مالک، interface، شناسه، mapping، refresh، کیفیت، امنیت او reconciliation له تایید وروسته.'),
                $this->faq('Does a dashboard fix poor source data?', 'No. It can expose quality issues, but accountable source owners must correct the underlying records and processes. Hidden reporting adjustments create another disputed source.', 'آیا dashboard معلومات ضعیف منبع را اصلاح می‌کند؟', 'خیر. مشکل کیفیت را نشان می‌دهد، اما مالک منبع باید ثبت و روند اصلی را اصلاح کند. adjustment پنهان منبع متضاد دیگر می‌سازد.', 'ایا dashboard د سرچینې خراب معلومات سموي؟', 'نه. ستونزه ښودلی شي، خو مسؤل سرچینه مالک باید اصلي ثبت او بهیر سم کړي. پټ adjustment بل لانجمن source جوړوي.'),
                $this->faq('Can reports be real time?', 'Only when source systems, connectivity, refresh design, capacity, latency and support can sustain the agreed target. Otherwise a documented refresh schedule is more reliable.', 'آیا گزارش real time است؟', 'تنها وقتی منبع، اتصال، طرح refresh، ظرفیت، latency و support هدف توافق‌شده را حفظ کند. در غیر آن schedule مستند معتبرتر است.', 'ایا راپور real time دی؟', 'یوازې کله چې سرچینې، اتصال، refresh طرحه، ظرفیت، latency او support موافقه شوی هدف وساتي. که نه، مستند schedule باوري دی.'),
                $this->faq('How are metric definitions governed?', 'Each measure should have a business owner, documented calculation, scope, source, refresh, quality threshold, access, effective date and approval process.', 'تعریف شاخص چگونه اداره می‌شود؟', 'هر شاخص مالک تجارتی، محاسبه، محدوده، منبع، refresh، حد کیفیت، دسترسی، تاریخ مؤثر و روند منظوری مستند می‌خواهد.', 'د شاخص تعریف څنګه اداره کېږي؟', 'هر شاخص سوداګریز مالک، مستند محاسبه، حدود، سرچینه، refresh، د کیفیت حد، لاسرسی، مؤثره نېټه او تایید غواړي.'),
                $this->faq('How are dashboards validated before release?', 'Representative totals, calculations, filters, drill paths, refresh, row-level security and exports should be tested against approved evidence, with discrepancies resolved and business sign-off recorded.', 'dashboard پیش از نشر چگونه validation می‌شود؟', 'total، محاسبه، filter، drill، refresh، row-level security و export با شواهد تأییدشده test، اختلاف حل و sign-off تجارتی ثبت می‌شود.', 'dashboard تر نشر مخکې څنګه validation کېږي؟', 'total، محاسبه، filter، drill، refresh، row-level security او export له تایید شوو شواهدو سره ازمویل، توپیر حل او سوداګریز sign-off ثبتېږي.'),
                $this->faq('How is a BI solution priced?', 'Pricing depends on sources, interfaces, data volumes, refresh, metrics, reports, users, security, licensing, deployment, migration, training and support.', 'قیمت راهکار BI چگونه تعیین می‌شود؟', 'قیمت به منبع، interface، حجم data، refresh، شاخص، گزارش، کاربر، امنیت، licensing، deployment، انتقال، آموزش و support وابسته است.', 'د BI حل بیه څنګه ټاکل کېږي؟', 'بیه په سرچینو، interface، data حجم، refresh، شاخصونو، راپورونو، کاروونکو، امنیت، licensing، deployment، لېږد، روزنې او support پورې تړلې ده.'),
            ],
            relatedSlugs: ['mis-development-afghanistan', 'digital-transformation-afghanistan', 'erp-systems-afghanistan'],
            profile: $this->profile(
                ['en' => 'Governed metrics and decision-ready reporting', 'fa' => 'شاخص دارای حاکمیت و گزارش آماده تصمیم', 'ps' => 'حاکمیت لرونکي شاخصونه او پرېکړې ته چمتو راپور'],
                ['en' => 'Owned definitions, quality and access', 'fa' => 'تعریف، کیفیت و دسترسی دارای مالک', 'ps' => 'مالک لرونکي تعریف، کیفیت او لاسرسی'],
                ['en' => 'Trend, exception, plan and accountable action', 'fa' => 'trend، استثنا، پلان و اقدام حساب‌ده', 'ps' => 'trend، استثنا، پلان او حساب‌ورکوونکی اقدام'],
                [['Metric governance', 'حاکمیت شاخص', 'د شاخص حاکمیت'], ['Source integration', 'اتصال منبع', 'د سرچینې ادغام'], ['Data quality', 'کیفیت معلومات', 'د معلوماتو کیفیت'], ['Dashboards & reports', 'dashboard و گزارش', 'dashboard او راپور'], ['Security & validation', 'امنیت و validation', 'امنیت او validation'], ['Release monitoring', 'نظارت نشر', 'د نشر څارنه']],
            ),
            sortOrder: 50,
        );
    }

    private function page(
        string $slug,
        array $title,
        array $eyebrow,
        array $summary,
        array $body,
        array $metaTitle,
        array $metaDescription,
        array $primaryQuery,
        array $faqs,
        array $relatedSlugs,
        array $profile,
        int $sortOrder,
    ): array {
        return [
            'type' => 'solution', 'slug' => $slug, 'title' => $title, 'eyebrow' => $eyebrow,
            'summary' => $summary, 'body' => $body, 'meta_title' => $metaTitle,
            'meta_description' => $metaDescription, 'primary_query' => $primaryQuery,
            'search_intent' => 'commercial', 'robots_directive' => config('website.discovery.default_robots'),
            'sitemap_included' => true, 'sitemap_priority' => 0.9, 'sitemap_change_frequency' => 'monthly',
            'metadata' => ['solution' => $profile, 'faqs' => $faqs, 'related_slugs' => $relatedSlugs],
            'status' => 'published', 'featured' => true, 'sort_order' => $sortOrder, 'published_at' => now(),
        ];
    }

    private function profile(array $outcomes, array $control, array $decisions, array $capabilities): array
    {
        return [
            'outcomes' => $outcomes,
            'control' => $control,
            'decisions' => $decisions,
            'capabilities' => array_map(
                fn (array $item): array => ['en' => $item[0], 'fa' => $item[1], 'ps' => $item[2]],
                $capabilities,
            ),
        ];
    }

    private function faq(string $enQuestion, string $enAnswer, string $faQuestion, string $faAnswer, string $psQuestion, string $psAnswer): array
    {
        return [
            'question' => ['en' => $enQuestion, 'fa' => $faQuestion, 'ps' => $psQuestion],
            'answer' => ['en' => $enAnswer, 'fa' => $faAnswer, 'ps' => $psAnswer],
        ];
    }
}
