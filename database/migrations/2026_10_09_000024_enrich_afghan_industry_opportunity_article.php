<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const MARKER = '<section data-opportunity-enrichment="v1">';

    public function up(): void
    {
        $page = ContentPage::query()
            ->where('slug', 'industry-software-opportunities-afghanistan')
            ->first();

        if (! $page) {
            return;
        }

        $body = (array) $page->body;
        $sections = [
            'en' => <<<'HTML'
<section data-opportunity-enrichment="v1">
<h2>Product scope, customer fit and working name ideas</h2>
<p>The names below are brainstorming options only. Fida has not checked trademark, company-name or domain availability. The module outlines describe possible first releases, not confirmed customer requirements or products already available from Fida.</p>

<h3>Poultry farm software: FlockFlow, ParwarPro or Fida PoultryOS</h3>
<p><strong>Potential users:</strong> broiler and layer farms, hatcheries, breeder farms, feed mills and poultry integrators. Interview each type separately because a single-farm record book and an integrator platform have different scope.</p>
<p><strong>Possible first release:</strong> farm and shed setup; flock or batch placement; daily feed, water, weight and mortality records; vaccination and medicine logs entered by farm staff; feed and chick purchases; egg, bird or chick output; sales; expense allocation; batch close-out and cost reports. A manager dashboard can compare batches, while staff capture records from a phone or shared computer.</p>
<p><strong>Validate locally:</strong> paper registers in use, measurement units, batch handover, supplier credit, feed conversion calculations, connectivity in sheds, printer needs and who is qualified to approve animal-health instructions. The software should record veterinary plans; it should not diagnose disease or prescribe treatment.</p>
<p><strong>Keep for a later phase:</strong> integrations with weighing equipment, feed-mill production, automated sensors and multi-company contract-grower settlements, unless a pilot buyer needs one of them from day one.</p>

<h3>Dairy collection and milk accounting: ShirPro, MilkLedger or LactoFlow</h3>
<p><strong>Potential users:</strong> milk collection points, cooperatives, chilling centers, dairy processors and organized farmer groups. Decide whether the first customer pays at collection, on a periodic settlement, or through a processor.</p>
<p><strong>Possible first release:</strong> farmer and collection-point records; shift or route opening; milk quantity by delivery; quality readings and rejection reasons; configurable price rules; approved deductions or advances; daily collection totals; farmer statements and settlement; cash or bank payment tracking; and basic chilling-center inventory and dispatch. Keep quality thresholds and price formulas configurable by the operator.</p>
<p><strong>Validate locally:</strong> weighing equipment and units, morning/evening shifts, sample handling, fat or quality tests actually used, payment frequency, rejected milk handling, seasonal pricing, farmer identity and whether connectivity is available at each point. Offline entry with later synchronization may matter, but confirm it with the pilot.</p>
<p><strong>Keep for a later phase:</strong> route optimization, laboratory equipment links, production recipes, cold-chain sensors and full factory planning until the collection-and-settlement workflow is proven.</p>

<h3>Vehicle workshop and spare-parts software: GarageFlow, UstadAuto or MekanikPro</h3>
<p><strong>Potential users:</strong> independent mechanics, multi-bay garages, fleet maintenance teams and spare-parts retailers. A repair shop and a parts wholesaler may need separate plans or permissions.</p>
<p><strong>Possible first release:</strong> customer and vehicle file; mileage and complaint at check-in; inspection checklist and photos; estimate with customer approval; numbered job card; mechanic assignment; labor and parts used; parts purchase and stock balance; invoice, partial payments and balance due; job status; warranty notes; and next-service reminders. Add a simple fleet view only if the pilot workshop maintains vehicles for business clients.</p>
<p><strong>Validate locally:</strong> common vehicle details, bilingual job cards, local part names and interchangeable codes, cash/credit sales, paper-print formats, permission to message customers, and whether the shop has stable internet. Start with a browser-based desktop layout if staff work at a counter, then add mobile workflows based on observation.</p>
<p><strong>Keep for a later phase:</strong> supplier marketplaces, vehicle history exchange, insurance claims and automatic parts catalog matching unless a named partner provides the data and integration access.</p>

<h3>Microfinance loan operations: QarzPro, QardFlow or AmanatCore</h3>
<p><strong>Potential users:</strong> licensed microfinance institutions, community finance organizations and approved small-business lenders. This opportunity requires a qualified institution to define requirements and compliance ownership.</p>
<p><strong>Possible first release:</strong> branch and staff roles; borrower and household records; configurable financing products; application checklist; review and approval trail; schedule generation from institution-approved rules; disbursement register; installment collection; arrears and follow-up queue; receipts; portfolio and branch reports; audit log; and controlled corrections. Separate test data from real borrower records during development.</p>
<p><strong>Validate locally:</strong> applicable permissions, product contracts, identity and consent requirements, data retention, approval limits, accounting interfaces, hosting/security requirements and whether a digital repayment channel is actually available. A lender must approve the rules. The software must not make eligibility decisions or claim legal, regulatory or Sharia compliance on its own.</p>
<p><strong>Keep for a later phase:</strong> credit scoring, national identity lookups, mobile-money or bank integrations, automated decisions and cross-institution data sharing. These require explicit legal, security and partner review.</p>

<h3>Travel agency back office: SafarDesk, SafarPro or TicketFlow</h3>
<p><strong>Potential users:</strong> agencies handling airline tickets, visa support, group travel or pilgrimage packages. Because travel software is already marketed for Afghanistan, begin only with agencies that can name a problem current tools do not solve.</p>
<p><strong>Possible first release:</strong> customer and traveler files; trip and booking register; document checklist with expiry reminders; supplier and booking references; package costing; installments and receipts; refund tracking; commission and margin reports; and a printable itinerary. Clearly distinguish manual booking records from live ticket issuance.</p>
<p><strong>Integration boundary:</strong> live airline inventory, ticket issuance, visa submission, hotel inventory and payment processing need contracts, API access and operational approval. Do not advertise these integrations until they are tested with the relevant provider.</p>

<h3>Hotel and guesthouse operations: MehmanOS, OtaqFlow or StaySuite</h3>
<p><strong>Potential users:</strong> independent hotels, guesthouses and small hotel groups. Regional competitors exist, so validate a specific advantage and recruit a property willing to pilot before investing in a broad product.</p>
<p><strong>Possible first release:</strong> room types and availability; reservation calendar; guest and booking records; check-in/check-out; room charges and payments; housekeeping status; daily occupancy and cash reports; and user permissions. Begin with one property and a reliable end-of-day workflow.</p>
<p><strong>Validate locally:</strong> language and printed document needs, walk-in versus advance bookings, deposits, restaurant charges, low-connectivity operation, backup process and any reporting obligations confirmed by the hotel. Do not assume external booking-channel integrations are available.</p>

<h2>Afghanistan-ready design questions for every pilot</h2>
<ul>
<li><strong>Language and direction:</strong> ask staff which screens and printed documents they need in English, Dari and Pashto; test right-to-left forms with real users.</li>
<li><strong>Devices and connectivity:</strong> observe the actual work area before choosing desktop, tablet or mobile-first screens. Define exactly which actions must work offline and how conflicts sync.</li>
<li><strong>Money and dates:</strong> confirm transaction currencies, exchange-rate source, rounding, receipts and whether Gregorian and Solar Hijri dates are both needed. Preserve the original transaction amount and rate where multi-currency records are required.</li>
<li><strong>Data migration:</strong> inspect sample notebooks, spreadsheets and existing databases with permission. Agree who cleans the data and how opening balances or historical records will be checked.</li>
<li><strong>Access and accountability:</strong> define staff roles, approvals, audit history, backup ownership and the process for correcting mistakes.</li>
<li><strong>Reports and printing:</strong> collect examples of the daily, monthly and tax or management reports the buyer actually uses. Confirm paper size, language and currency display.</li>
</ul>

<h2>Build decision: evidence to collect before selecting a system</h2>
<p>For each category, speak with at least five operators and record the current method, repeated errors, time-consuming tasks, who controls the budget, and the last time the problem caused a measurable loss or delay. Ask for a sample blank form or anonymized record. Then secure one pilot partner, write a one-page scope, estimate implementation and support costs, and agree on a success measure before coding. These interviews are a validation plan; they are not a claim that five interviews prove market size.</p>
<p><strong>Product status:</strong> these remain research candidates. Names, scope, pricing, schedule and availability are unconfirmed. No item should be described as a Fida product until it is built, tested and accurately presented.</p>
</section>
HTML,
            'fa' => <<<'HTML'
<section data-opportunity-enrichment="v1">
<h2>محدوده محصول، مشتریان احتمالی و نام‌های پیشنهادی</h2>
<p>نام‌های زیر فقط پیشنهادهای اولیه هستند. فیدا موجودیت علامت تجارتی، نام شرکت یا دامنه را بررسی نکرده است. شرح بخش‌ها نمونه‌ای از نسخه احتمالی نخست است؛ نیاز قطعی مشتری یا محصول آماده فیدا نیست.</p>

<h3>نرم‌افزار مرغداری: FlockFlow، ParwarPro یا Fida PoultryOS</h3>
<p><strong>کاربران احتمالی:</strong> فارم‌های گوشتی و تخم‌گذار، هچری‌ها، فارم‌های مادر، فابریکه‌های خوراک و شبکه‌های تولید مرغ. نیاز هر گروه را جدا بررسی کنید؛ ثبت یک فارم با سیستم چند فارم و قراردادی یکسان نیست.</p>
<p><strong>نسخه نخست احتمالی:</strong> تعریف فارم و سالن؛ ثبت دوره و ورود جوجه؛ ثبت روزانه خوراک، آب، وزن و تلفات؛ ثبت واکسین و دوا توسط کارمند فارم؛ خرید خوراک و جوجه؛ تولید تخم، مرغ یا جوجه؛ فروش؛ تخصیص مصارف؛ بستن دوره و گزارش هزینه. مدیر بتواند دوره‌ها را مقایسه کند و کارمند از موبایل یا کمپیوتر مشترک معلومات ثبت کند.</p>
<p><strong>موارد بررسی در محل:</strong> دفترهای فعلی، واحدهای اندازه‌گیری، تحویل دوره، قرض عرضه‌کننده، محاسبه مصرف خوراک، اینترنت سالن، چاپ و شخص مسئول تأیید دستورهای صحی. سیستم برنامه دامپزشک را ثبت کند، اما بیماری را تشخیص ندهد و تداوی تجویز نکند.</p>
<p><strong>برای مرحله بعد:</strong> اتصال ترازو، تولید فابریکه خوراک، حسگرهای خودکار و تسویه چندشرکتی فارم‌های قراردادی را بعداً اضافه کنید، مگر مشتری آزمایشی از آغاز به آن نیاز داشته باشد.</p>

<h3>جمع‌آوری شیر و حسابداری لبنیات: ShirPro، MilkLedger یا LactoFlow</h3>
<p><strong>کاربران احتمالی:</strong> نقاط جمع‌آوری شیر، اتحادیه‌ها، مراکز سردخانه، پروسس‌کنندگان لبنیات و گروه‌های منظم فارم‌داران. مشخص کنید مشتری نخست هنگام تحویل پرداخت می‌کند یا در تسویه دوره‌ای.</p>
<p><strong>نسخه نخست احتمالی:</strong> ثبت فارم‌دار و نقطه جمع‌آوری؛ شروع شیفت یا مسیر؛ مقدار هر تحویل؛ نتیجه کیفیت و دلیل رد؛ نرخ‌های قابل تنظیم؛ کسرهای تأییدشده یا پیش‌پرداخت؛ مجموع روزانه؛ صورت‌حساب و تصفیه فارم‌دار؛ ثبت پرداخت نقدی یا بانکی؛ و موجودی و ارسال ابتدایی مرکز سردخانه. حد کیفیت و فورمول قیمت باید زیر کنترل اداره‌کننده باشد.</p>
<p><strong>موارد بررسی در محل:</strong> ترازو و واحدها، شیفت صبح و عصر، نمونه‌گیری، آزمایش چربی یا کیفیتی که واقعاً استفاده می‌شود، زمان پرداخت، شیر ردشده، نرخ فصلی، شناخت فارم‌دار و موجودیت اینترنت. ورود آفلاین و همگام‌سازی بعدی را با شریک آزمایشی بررسی کنید.</p>
<p><strong>برای مرحله بعد:</strong> بهینه‌سازی مسیر، اتصال دستگاه لابراتوار، نسخه‌های تولید، حسگر زنجیره سرد و برنامه‌ریزی کامل کارخانه را تا زمانی که روند جمع‌آوری و تصفیه ثابت نشده به تأخیر اندازید.</p>

<h3>نرم‌افزار ورکشاپ و پرزه‌جات موتر: GarageFlow، UstadAuto یا MekanikPro</h3>
<p><strong>کاربران احتمالی:</strong> میخانیک‌های مستقل، گراج‌های چندباکسه، تیم‌های مراقبت ناوگان و فروشندگان پرزه. ورکشاپ ترمیمی و عمده‌فروش پرزه ممکن است به پکیج و سطح دسترسی جدا نیاز داشته باشند.</p>
<p><strong>نسخه نخست احتمالی:</strong> دوسیه مشتری و موتر؛ کیلومتر و شکایت هنگام پذیرش؛ چک‌لیست و عکس؛ تخمین هزینه و تأیید مشتری؛ کارت شماره‌دار کار؛ تقسیم کار به میخانیک؛ ثبت مزد و پرزه مصرف‌شده؛ خرید و موجودی پرزه؛ بل، پرداخت قسطی و باقی‌داری؛ وضعیت کار؛ یادداشت تضمین؛ و یادآوری سرویس بعدی. نمای ناوگان را فقط در صورت نیاز مشتری آزمایشی اضافه کنید.</p>
<p><strong>موارد بررسی در محل:</strong> مشخصات موترهای رایج، کارت کار دو زبانه، نام محلی و کودهای معادل پرزه، فروش نقدی و قرضی، قالب چاپی، اجازه پیام به مشتری و ثبات اینترنت. اگر کارمندان در پیشخوان کار می‌کنند، نخست چیدمان کمپیوتر را بررسی کنید و سپس روندهای موبایل را با مشاهده واقعی تعیین کنید.</p>
<p><strong>برای مرحله بعد:</strong> بازار عرضه‌کنندگان، تبادل سابقه موتر، ادعای بیمه و تطبیق خودکار کاتالوگ پرزه را بدون شریک مشخص و دسترسی به معلومات اضافه نکنید.</p>

<h3>عملیات قرضه و مایکروفایننس: QarzPro، QardFlow یا AmanatCore</h3>
<p><strong>کاربران احتمالی:</strong> مؤسسات مایکروفایننس مجاز، سازمان‌های مالی اجتماعی و قرض‌دهندگان تأییدشده تجارت کوچک. یک مؤسسه واجد صلاحیت باید نیازمندی و مسئولیت مطابقت را تعیین کند.</p>
<p><strong>نسخه نخست احتمالی:</strong> شعبه و نقش کارمند؛ معلومات قرض‌گیرنده و خانواده؛ محصولات مالی قابل تنظیم؛ چک‌لیست درخواست؛ سابقه بررسی و تأیید؛ ساخت جدول قسط طبق قواعد مصوب مؤسسه؛ ثبت پرداخت قرضه؛ وصول اقساط؛ فهرست معوقات و پیگیری؛ رسید؛ گزارش پرتفوی و شعبه؛ سابقه حسابرسی؛ و تصحیح کنترل‌شده. معلومات آزمایشی را هنگام توسعه از معلومات واقعی قرض‌گیرندگان جدا نگه دارید.</p>
<p><strong>موارد بررسی در محل:</strong> مجوزهای لازم، قرارداد محصولات، شرایط هویت و رضایت، نگهداری معلومات، حدود تأیید، اتصال حسابداری، نیازهای میزبانی و امنیت، و موجودیت واقعی کانال دیجیتال پرداخت. مؤسسه باید قواعد را تأیید کند. سیستم نباید خودش واجد شرایط بودن را تعیین کند یا به‌تنهایی ادعای مطابقت قانونی، مقرراتی یا شرعی نماید.</p>
<p><strong>برای مرحله بعد:</strong> امتیاز اعتباری، جستجوی هویت ملی، اتصال موبایل‌مانی یا بانک، تصمیم‌گیری خودکار و اشتراک معلومات بین مؤسسات نیازمند بررسی قانونی، امنیتی و شریک مربوط هستند.</p>

<h3>سیستم اداری آژانس سفر: SafarDesk، SafarPro یا TicketFlow</h3>
<p><strong>کاربران احتمالی:</strong> آژانس‌های تکت هواپیما، خدمات ویزه، سفر گروهی یا بسته‌های زیارتی. چون نرم‌افزار سفر برای افغانستان از قبل عرضه می‌شود، فقط با آژانس‌هایی آغاز کنید که مشکل حل‌نشده با ابزار فعلی خود را مشخص کنند.</p>
<p><strong>نسخه نخست احتمالی:</strong> دوسیه مسافر و مشتری؛ ثبت سفر و رزرو؛ چک‌لیست اسناد با یادآوری انقضا؛ مشخصات عرضه‌کننده و مرجع رزرو؛ محاسبه هزینه بسته؛ قسط و رسید؛ پیگیری برگشت پول؛ گزارش کمیسیون و حاشیه سود؛ و برنامه سفر قابل چاپ. ثبت دستی رزرو را از صدور زنده تکت جدا نشان دهید.</p>
<p><strong>مرز اتصال‌ها:</strong> موجودیت زنده خطوط هوایی، صدور تکت، درخواست ویزه، موجودیت هتل و پروسس پرداخت به قرارداد، دسترسی API و تأیید عملیاتی نیاز دارند. تا پیش از آزمایش با ارائه‌کننده مربوط، این اتصال‌ها را تبلیغ نکنید.</p>

<h3>عملیات هتل و مهمانخانه: MehmanOS، OtaqFlow یا StaySuite</h3>
<p><strong>کاربران احتمالی:</strong> هتل‌های مستقل، مهمانخانه‌ها و گروه‌های کوچک هتل. رقیبان منطقه‌ای وجود دارند؛ پیش از سرمایه‌گذاری روی محصول کامل، مزیت مشخص و یک محل آزمایشی پیدا کنید.</p>
<p><strong>نسخه نخست احتمالی:</strong> انواع اتاق و موجودیت؛ تقویم ریزرف؛ معلومات مهمان و رزرو؛ ورود و خروج؛ هزینه اتاق و پرداخت؛ وضعیت نظافت؛ گزارش روزانه اشغال و نقدینه؛ و دسترسی کارمندان. با یک ملک و روند مطمئن پایان روز شروع کنید.</p>
<p><strong>موارد بررسی در محل:</strong> زبان و چاپ اسناد، رزرو حضوری یا قبلی، پیش‌پرداخت، مصارف رستورانت، کار در اینترنت ضعیف، پشتیبان‌گیری و هرگونه گزارش‌دهی که هتل تأیید می‌کند. موجودیت اتصال به کانال‌های بیرونی رزرو را فرض نکنید.</p>

<h2>پرسش‌های طراحی برای هر آزمایش در افغانستان</h2>
<ul>
<li><strong>زبان و جهت:</strong> از کارمندان بپرسید کدام صفحه‌ها و اسناد چاپی به انگلیسی، دری و پشتو لازم دارند؛ راست‌به‌چپ بودن فرم‌ها را با کاربران واقعی آزمایش کنید.</li>
<li><strong>دستگاه و اتصال:</strong> محیط واقعی کار را ببینید و بعد درباره کمپیوتر، تبلت یا موبایل تصمیم بگیرید. دقیقاً مشخص کنید چه کاری آفلاین باشد و همگام‌سازی تعارض‌ها چگونه انجام شود.</li>
<li><strong>پول و تاریخ:</strong> ارز معامله، منبع نرخ تبدیل، گردکردن، رسید و نیاز به تاریخ میلادی و هجری شمسی را تأیید کنید. در سوابق چندارزی، مبلغ اصلی و نرخ تبدیل را نگه دارید.</li>
<li><strong>انتقال معلومات:</strong> با اجازه، نمونه دفتر، فایل اکسل یا دیتابیس فعلی را بررسی کنید. مشخص کنید چه کسی معلومات را پاک‌سازی می‌کند و مانده‌های ابتدایی چگونه تأیید می‌شوند.</li>
<li><strong>دسترسی و پاسخگویی:</strong> نقش‌ها، تأییدها، سابقه تغییر، مسئولیت پشتیبان‌گیری و روش اصلاح اشتباه را تعریف کنید.</li>
<li><strong>گزارش و چاپ:</strong> نمونه گزارش روزانه، ماهانه، مالیاتی یا مدیریتی واقعی مشتری را بگیرید. اندازه کاغذ، زبان و نمایش ارز را تأیید کنید.</li>
</ul>

<h2>تصمیم ساخت: شواهدی که پیش از انتخاب سیستم جمع شود</h2>
<p>برای هر حوزه با حداقل پنج فعال صحبت کنید و روش فعلی، اشتباهات تکراری، کارهای وقت‌گیر، مسئول بودجه و آخرین موردی را ثبت کنید که مشکل باعث زیان یا تأخیر قابل اندازه‌گیری شد. یک فورم سفید یا نمونه ناشناس بخواهید. سپس یک شریک آزمایشی پیدا کنید، محدوده یک‌صفحه‌ای بنویسید، هزینه تطبیق و پشتیبانی را برآورد کنید و پیش از کدنویسی معیار موفقیت را توافق کنید. این گفتگوها برنامه اعتبارسنجی است؛ پنج مصاحبه اندازه بازار را ثابت نمی‌کند.</p>
<p><strong>وضعیت محصول:</strong> این موارد هنوز گزینه‌های تحقیق بازار هستند. نام، محدوده، قیمت، زمان‌بندی و موجودیت تأیید نشده‌اند. تا زمانی که محصول ساخته، آزمایش و دقیق معرفی نشده، هیچ موردی نباید محصول فیدا خوانده شود.</p>
</section>
HTML,
            'ps' => <<<'HTML'
<section data-opportunity-enrichment="v1">
<h2>د محصول محدوده، احتمالي پېرودونکي او د نوم وړاندیزونه</h2>
<p>لاندې نومونه یوازې لومړني نظرونه دي. فیدا د سوداګریزې نښې، شرکت نوم یا ډومېن موجودیت نه دی پلټلی. د هرې برخې د لومړۍ نسخې یادونه ممکنه ساحه ده، د تایید شوې مشتری اړتیا یا د فیدا چمتو محصول نه دی.</p>

<h3>د چرګانو فارم سافټویر: FlockFlow، ParwarPro یا Fida PoultryOS</h3>
<p><strong>احتمالي کاروونکي:</strong> د غوښې او هګیو فارمونه، هچري، د نسل فارمونه، د خوراک کارخانې او د چرګانو تولیدي شبکې. د هر ډول اړتیا جلا وڅېړئ؛ د یوه فارم کتابچه او د څو فارمونو قراردادي شبکه یو شان محدوده نه لري.</p>
<p><strong>ممکنه لومړۍ نسخه:</strong> د فارم او سالون تنظیم؛ د رمې یا دورې ثبت؛ د خوراک، اوبو، وزن او تلفاتو ورځني معلومات؛ د واکسین او درملو ثبت د فارم د کارکوونکو له خوا؛ د خوراک او چرګوړو پېرود؛ د هګیو، چرګانو یا چرګوړو تولید؛ پلور؛ د لګښت وېش؛ د دورې پای او د لګښت راپورونه. مدیر دې دورې پرتله کړي او کارکوونکي دې د موبایل یا ګډ کمپیوټر له لارې معلومات داخل کړي.</p>
<p><strong>په ځای کې یې وارزوئ:</strong> اوسني کتابونه، د اندازه کولو واحدونه، د دورې سپارل، د عرضه کوونکي پور، د خوراک د مصرف محاسبه، په سالون کې انټرنېټ، چاپ او هغه څوک چې روغتیايي لارښوونې تاییدوي. سیستم دې د وترنر پلانونه ثبت کړي؛ ناروغي دې نه تشخیصوي او درملنه دې نه تجویزوي.</p>
<p><strong>وروستي پړاو ته یې پرېږدئ:</strong> د ترازو، خوراک کارخانې، اتومات حسګرونو او د څو شرکتونو د قراردادي فارمونو تصفیه تر هغه وروسته کړئ چې ازمایښتي پېرودونکی یې د لومړۍ ورځې لپاره ضروري ونه بولي.</p>

<h3>د شیدو راټولولو او حساب سافټویر: ShirPro، MilkLedger یا LactoFlow</h3>
<p><strong>احتمالي کاروونکي:</strong> د شیدو راټولولو نقطې، کوپراتیفونه، د سړولو مرکزونه، د لبنیاتو پروسس کوونکي او د فارم‌لرونکو ډلې. معلومه کړئ چې لومړی پېرودونکی د راټولولو پر مهال پیسې ورکوي او که په دوره‌یي تصفیه کې.</p>
<p><strong>ممکنه لومړۍ نسخه:</strong> د فارم‌لرونکي او راټولولو مرکز معلومات؛ د شېفټ یا لارې پیل؛ د هر تحویل اندازه؛ د کیفیت لوستل او د رد دلیل؛ د بدلولو وړ نرخونه؛ تایید شوي کسرونه یا پیشکي؛ د ورځې ټولګه؛ د فارم‌لرونکي حساب او تصفیه؛ د نغدو یا بانک تادیې ثبت؛ او د سړولو مرکز ساده موجودي او لېږد. د کیفیت حدونه او د بیې فورمول دې د ادارې له خوا تنظیمېږي.</p>
<p><strong>په ځای کې یې وارزوئ:</strong> ترازو او واحدونه، د سهار او ماښام شېفټونه، د نمونې اخیستل، د غوړ یا کیفیت هغه ازموینې چې رښتیا کارېږي، د تادیې موده، رد شوې شیدې، موسمي نرخ، د فارم‌لرونکي پېژندنه او د انټرنېټ شتون. آفلاین داخلول او وروسته همغږي له ازمایښتي شریک سره تایید کړئ.</p>
<p><strong>وروستي پړاو ته یې پرېږدئ:</strong> د لارې اصلاح، د لابراتوار وسایلو نښلول، د تولید فورمولونه، د سړې ځنځیر حسګرونه او د ټولې فابریکې پلان تر هغه وروسته کړئ چې د راټولولو او تصفیې بهیر ثابت شي.</p>

<h3>د موټرو ورکشاپ او پرزو سافټویر: GarageFlow، UstadAuto یا MekanikPro</h3>
<p><strong>احتمالي کاروونکي:</strong> خپلواک میخانیکان، څو ځایه لرونکي ګراجونه، د موټرو د بیړیو د ساتنې ټیمونه او د پرزو پلورنځي. د ترمیم ورکشاپ او د پرزو عمده پلورونکی ښايي جلا پلانونه او اجازې وغواړي.</p>
<p><strong>ممکنه لومړۍ نسخه:</strong> د پېرودونکي او موټر دوسیه؛ د منلو پر وخت مزل او شکایت؛ د کتنې چک‌لېست او عکسونه؛ د لګښت اټکل او د پېرودونکي اجازه؛ شمېره لرونکې کاري پاڼه؛ میخانیک ته دنده؛ د مزدورۍ او کارول شوو پرزو ثبت؛ د پرزو پېرود او موجودي؛ بل، قسطي تادیه او پاتې حساب؛ د کار حالت؛ د ضمانت یادښت؛ او د راتلونکي سرویس یادونه. د بیړیو برخه یوازې هغه وخت ورزیاته کړئ چې ازمایښتي ورکشاپ د سوداګریزو مشتریانو موټرونه ساتي.</p>
<p><strong>په ځای کې یې وارزوئ:</strong> عام موټرونه، دوه‌ژبې کاري پاڼې، د پرزو سیمه‌ییز نومونه او بدیل کوډونه، نغدي او پور پلور، چاپي فورمې، پېرودونکو ته د پیغام اجازه او د انټرنېټ ثبات. که کارکوونکي پر کاونټر کار کوي، لومړی د ډېسکټاپ چیدمان وګورئ، بیا د موبایل بهیرونه د کار له لیدلو وروسته وټاکئ.</p>
<p><strong>وروستي پړاو ته یې پرېږدئ:</strong> د عرضه کوونکو بازار، د موټر د تاریخ تبادله، د بیمې دعوې او اتومات د پرزو کتالوګ یوازې هغه وخت اضافه کړئ چې مشخص شریک او معلوماتو ته د لاسرسي اجازه وي.</p>

<h3>د مایکروفایننس او پور ورکولو عملیات: QarzPro، QardFlow یا AmanatCore</h3>
<p><strong>احتمالي کاروونکي:</strong> جواز لرونکي د مایکروفایننس ادارې، ټولنیز مالي سازمانونه او د وړو کاروبارونو تایید شوي پور ورکوونکي. وړ اداره باید اړتیاوې او د مطابقت مسؤلیت وټاکي.</p>
<p><strong>ممکنه لومړۍ نسخه:</strong> څانګه او د کارکوونکو رولونه؛ د پور اخیستونکي او کورنۍ معلومات؛ د تنظیم وړ تایید شوي مالي محصولات؛ د غوښتنلیک چک‌لېست؛ د ارزونې او تایید تاریخچه؛ د ادارې د تایید شوو اصولو له مخې د قسطونو مهال‌وېش؛ د پور ورکړې ثبت؛ د قسطونو راټولول؛ د ځنډ او تعقیب لېست؛ رسیدونه؛ د پورونو او څانګو راپورونه؛ د پلټنې تاریخچه؛ او کنټرول شوی سمون. د پرمختګ پر مهال ازمایښتي معلومات د پور اخیستونکو له واقعي معلوماتو جلا وساتئ.</p>
<p><strong>په ځای کې یې وارزوئ:</strong> اړین جوازونه، د محصول قراردادونه، د هویت او رضایت اړتیاوې، د معلوماتو ساتنه، د تایید حدود، د حسابدارۍ نښلونې، د کوربه‌توب او امنیت اړتیاوې، او د ډیجیټلي تادیې د کانال واقعي شتون. پور ورکوونکی باید قواعد تایید کړي. سافټویر دې پخپله د وړتیا پرېکړه نه کوي او د قانوني، مقرراتي یا شرعي مطابقت ادعا دې نه کوي.</p>
<p><strong>وروستي پړاو ته یې پرېږدئ:</strong> د پور نمره ورکول، د ملي هویت پلټنه، موبایل‌مني یا بانک نښلونې، اتومات پرېکړې او د ادارو ترمنځ د معلوماتو شریکول قانوني، امنیتي او د شریک بیاکتنې ته اړتیا لري.</p>

<h3>د سفر ادارې دفتر سافټویر: SafarDesk، SafarPro یا TicketFlow</h3>
<p><strong>احتمالي کاروونکي:</strong> د هوايي ټکټ، ویزې مرستې، ډلې سفر یا د زیارت د پکیج ادارې. ځکه چې د افغانستان لپاره د سفر سافټویر لا بازار ته وړاندې کېږي، یوازې له هغو ادارو پیل وکړئ چې د اوسنیو وسایلو یوه مشخصه نه‌حل شوې ستونزه بیانوي.</p>
<p><strong>ممکنه لومړۍ نسخه:</strong> د پېرودونکي او مسافر دوسیه؛ د سفر او بکینګ ثبت؛ د ختمېدو د یادونې سره د اسنادو چک‌لېست؛ د عرضه کوونکي او بکینګ شمېره؛ د پکیج لګښت؛ قسطونه او رسیدونه؛ د بېرته ورکړې تعقیب؛ د کمېشن او ګټې راپور؛ او د چاپ وړ د سفر پلان. لاسي بکینګ له ژوندۍ ټکټ صادرونې جلا وښایئ.</p>
<p><strong>د نښلونې حدود:</strong> د هوايي شرکت ژوندۍ موجودي، د ټکټ صادرول، د ویزې سپارل، د هوټل موجودي او د تادیې پروسس قرارداد، API لاسرسي او کاري تایید ته اړتیا لري. تر اړوند عرضه کوونکي سره تر ازموینې مخکې دا نښلونې مه اعلانوی.</p>

<h3>د هوټل او مېلمستون عملیات: MehmanOS، OtaqFlow یا StaySuite</h3>
<p><strong>احتمالي کاروونکي:</strong> خپلواک هوټلونه، مېلمستونونه او د کوچنیو هوټلونو ډلې. سیمه‌ییز سیالان شته؛ له پراخ محصول جوړولو مخکې مشخص توپیر او ازمایښتي هوټل پیدا کړئ.</p>
<p><strong>ممکنه لومړۍ نسخه:</strong> د خونو ډولونه او موجودي؛ د ریزرف تقویم؛ د مېلمه او بکینګ معلومات؛ راتګ او وتل؛ د خونې لګښتونه او تادیې؛ د نظافت حالت؛ د ورځني اشغال او نغدو راپورونه؛ او د کارکوونکو اجازې. له یوه هوټل او باوري ورځني پای بهیر څخه پیل وکړئ.</p>
<p><strong>په ځای کې یې وارزوئ:</strong> ژبه او چاپي اسناد، حضوري او مخکېني بکینګونه، پیشکي، د رستورانت لګښتونه، په کمزوري انټرنېټ کې کار، بیک اپ او د هوټل له خوا تایید شوي راپورونه. د بهرنیو بکینګ چینلونو نښلونې موجودې مه فرضوئ.</p>

<h2>په افغانستان کې د هر ازمایښتي سیستم لپاره ډیزاین پوښتنې</h2>
<ul>
<li><strong>ژبه او لوری:</strong> له کارکوونکو وپوښتئ چې کومې پاڼې او چاپي اسناد په انګلیسي، دري او پښتو غواړي؛ RTL فورمونه له واقعي کاروونکو سره وازمویئ.</li>
<li><strong>وسایل او نښلون:</strong> د کار حقیقي ځای وګورئ، بیا د ډېسکټاپ، ټابلیټ یا موبایل په اړه پرېکړه وکړئ. مشخص کړئ کوم کار باید آفلاین وي او د همغږۍ اختلافونه څنګه حلېږي.</li>
<li><strong>پیسې او نېټې:</strong> د معاملې اسعار، د تبادلې نرخ سرچینه، ګردول، رسید او د میلادي او لمریز هجري نېټې اړتیا تایید کړئ. په څو اسعارو ریکارډونو کې اصلي مبلغ او نرخ وساتئ.</li>
<li><strong>د معلوماتو انتقال:</strong> په اجازه کتابچې، اکسل او اوسني ډیټابېس وګورئ. معلومه کړئ څوک معلومات پاکوي او ابتدايي بیلانسونه څنګه تاییدېږي.</li>
<li><strong>لاسرسی او مسؤلیت:</strong> رولونه، تاییدونه، د بدلون تاریخچه، د بیک اپ مسؤلیت او د تېروتنې د اصلاح طریقه تعریف کړئ.</li>
<li><strong>راپور او چاپ:</strong> د پېرودونکي له اصلي ورځني، میاشتني، مالیاتي یا مدیریتي راپورونو بېلګې واخلئ. د کاغذ اندازه، ژبه او د پیسو ښودل تایید کړئ.</li>
</ul>

<h2>د جوړولو پرېکړه: تر انتخاب مخکې شواهد راټول کړئ</h2>
<p>په هره برخه کې لږ تر لږه له پنځو فعالانو سره خبرې وکړئ او اوسنی طریقه، تکراري تېروتنې، وخت‌خوړونکي کارونه، د بودجې واک لرونکی کس او وروستی هغه مثال ثبت کړئ چې ستونزې اندازه کېدونکی زیان یا ځنډ جوړ کړی وي. د تش فورم یا بې‌نومه ریکارډ نمونه وغواړئ. بیا یو ازمایښتي شریک پیدا کړئ، د یوې پاڼې محدوده ولیکئ، د تطبیق او ملاتړ لګښت اټکل کړئ او له کوډ لیکلو مخکې د بریا معیار ومنئ. دا مرکې د اعتبارسنجۍ پلان دی؛ پنځه مرکې د بازار اندازه نه ثابتوي.</p>
<p><strong>د محصول حالت:</strong> دا لا هم د بازار د څېړنې نوماندان دي. نوم، محدوده، بیه، مهالوېش او موجودیت نه دي تایید شوي. تر جوړولو، ازموینې او دقیقې معرفۍ مخکې هېڅ مورد د فیدا محصول مه بولئ.</p>
</section>
HTML,
        ];

        foreach ($sections as $locale => $section) {
            $current = (string) ($body[$locale] ?? '');

            if (! str_contains($current, self::MARKER)) {
                $body[$locale] = rtrim($current)."\n\n".$section;
            }
        }

        $page->body = $body;
        $page->sitemap_last_modified_at = now();
        $page->save();
    }

    public function down(): void
    {
        $page = ContentPage::query()
            ->where('slug', 'industry-software-opportunities-afghanistan')
            ->first();

        if (! $page) {
            return;
        }

        $body = (array) $page->body;

        foreach ($body as $locale => $html) {
            $html = (string) $html;
            $position = strpos($html, self::MARKER);

            if ($position !== false) {
                $body[$locale] = rtrim(substr($html, 0, $position));
            }
        }

        $page->body = $body;
        $page->save();
    }
};
