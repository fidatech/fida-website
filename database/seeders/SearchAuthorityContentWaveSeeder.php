<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class SearchAuthorityContentWaveSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = ArticleCategory::query()->where('slug', 'business-software-planning')->value('id');

        foreach ($this->articles($categoryId) as $article) {
            ContentPage::query()->firstOrCreate(['slug' => $article['slug']], $article);
        }
    }

    private function articles(?int $categoryId): array
    {
        return [
            $this->article(
                $categoryId,
                'erp-cost-afghanistan',
                ['en' => 'How Much Does an ERP System Cost in Afghanistan?', 'fa' => 'قیمت سیستم ERP در افغانستان چقدر است؟', 'ps' => 'په افغانستان کې د ERP سیسټم بیه څومره ده؟'],
                ['en' => 'ERP pricing depends on scope, users, modules, migration, integrations, deployment and support—not one universal price.', 'fa' => 'قیمت ERP به محدوده، کاربران، ماژول‌ها، انتقال معلومات، یکپارچه‌سازی، نصب و پشتیبانی وابسته است.', 'ps' => 'د ERP بیه په حدودو، کاروونکو، ماډیولونو، معلوماتو لېږد، ادغام، نصب او ملاتړ پورې تړلې ده.'],
                [
                    'en' => '<h2>There is no single ERP price for every Afghan business</h2><p>An ERP quotation should reflect the actual operation. A small trading company with finance and stock has a different scope from a multi-branch manufacturer, NGO or institution with approvals, payroll, procurement, projects and integrations.</p><h2>Main cost drivers</h2><ul><li>Number of modules, branches and user roles</li><li>Custom workflows, approvals and reports</li><li>Data migration from Excel or older systems</li><li>Mobile apps, APIs and third-party integrations</li><li>Cloud, private hosting, on-premise or offline requirements</li><li>Training, warranty, maintenance and support</li></ul><h2>Compare scope before price</h2><p>Ask each vendor to state what is included, excluded, configured, customized and billed separately. A lower headline price can become more expensive if migration, reports, training or support are omitted.</p><h2>How Fida estimates ERP work</h2><p>Fida Technologies starts with users, workflows, approvals, reports, integrations, data and deployment. The result should be a written scope with milestones and commercial assumptions instead of an unexplained lump-sum figure.</p>',
                    'fa' => '<h2>برای هر تجارت افغان یک قیمت ثابت ERP وجود ندارد</h2><p>قیمت باید مطابق عملیات واقعی باشد. یک شرکت تجارتی کوچک با مالی و گدام با یک تولیدی چندشعبه، NGO یا نهاد دارای تأییدی، معاش، تدارکات، پروژه و یکپارچه‌سازی یکسان نیست.</p><h2>عوامل اصلی قیمت</h2><ul><li>تعداد ماژول، شعبه و نقش کاربر</li><li>روند اختصاصی، تأییدی و گزارش</li><li>انتقال معلومات از Excel یا سیستم قدیمی</li><li>اپلیکیشن موبایل، API و یکپارچه‌سازی</li><li>کلود، سرور خصوصی، on-premise یا آفلاین</li><li>آموزش، تضمین، نگهداری و پشتیبانی</li></ul><h2>پیش از قیمت، محدوده را مقایسه کنید</h2><p>از هر شرکت بخواهید موارد شامل، خارج، تنظیم‌شده، اختصاصی و هزینه جداگانه را واضح سازد.</p><h2>فیدا چگونه ERP را برآورد می‌کند</h2><p>Fida Technologies از کاربران، روندها، تأییدی‌ها، گزارش‌ها، یکپارچه‌سازی، معلومات و محیط نصب آغاز می‌کند تا محدوده و مراحل روشن باشد.</p>',
                    'ps' => '<h2>د هر افغان کاروبار لپاره یوه ثابته ERP بیه نشته</h2><p>بیه باید د واقعي عملیاتو مطابق وي. یو کوچنی سوداګریز شرکت چې مالي او ګدام غواړي له څو څانګو تولیدي، NGO یا ادارې سره چې تاییدونه، معاش، تدارکات، پروژې او ادغامونه لري یو شان نه دی.</p><h2>د بیې مهم عوامل</h2><ul><li>د ماډیولونو، څانګو او کاروونکو رولونو شمېر</li><li>ځانګړي بهیرونه، تاییدونه او راپورونه</li><li>له Excel یا زاړه سیسټم څخه د معلوماتو لېږد</li><li>موبایل اپونه، API او ادغامونه</li><li>کلاوډ، شخصي سرور، on-premise یا آفلاین اړتیاوې</li><li>روزنه، تضمین، ساتنه او ملاتړ</li></ul><h2>تر بیې مخکې حدود پرتله کړئ</h2><p>له هر شرکت څخه وغواړئ چې شامل، خارج، تنظیم شوي، ځانګړي او جلا لګښت لرونکي موارد واضح کړي.</p><h2>فیدا ERP څنګه اټکلوي</h2><p>Fida Technologies له کاروونکو، بهیرونو، تاییدونو، راپورونو، ادغامونو، معلوماتو او نصب څخه پیل کوي څو حدود او پړاوونه روښانه شي.</p>',
                ],
                ['en' => 'ERP Cost Afghanistan | Pricing Guide', 'fa' => 'قیمت ERP افغانستان | راهنمای هزینه', 'ps' => 'د ERP بیه افغانستان | د قیمت لارښود'],
                ['en' => 'Understand ERP cost in Afghanistan by modules, users, migration, integrations, hosting, training and support before comparing quotations.', 'fa' => 'قیمت ERP افغانستان را براساس ماژول، کاربر، انتقال معلومات، یکپارچه‌سازی، میزبانی، آموزش و پشتیبانی ارزیابی کنید.', 'ps' => 'په افغانستان کې د ERP بیه د ماډیول، کاروونکو، معلوماتو لېږد، ادغام، کوربه‌توب، روزنې او ملاتړ له مخې وپېژنئ.'],
                ['en' => 'ERP cost Afghanistan', 'fa' => 'قیمت ERP افغانستان', 'ps' => 'د ERP بیه افغانستان'],
                ['erp-systems-afghanistan', 'erp-implementation-services-afghanistan', 'how-to-choose-erp-system-afghanistan']
            ),
            $this->article(
                $categoryId,
                'database-for-business-afghanistan',
                ['en' => 'When Does a Business in Afghanistan Need a Database System?', 'fa' => 'یک تجارت در افغانستان چه زمانی به سیستم دیتابیس نیاز دارد؟', 'ps' => 'په افغانستان کې یو کاروبار کله ډیټابیس سیسټم ته اړتیا لري؟'],
                ['en' => 'Learn when Excel, paper records or disconnected apps should be replaced by a controlled business database and management system.', 'fa' => 'بدانید چه زمانی Excel، کاغذ یا برنامه‌های جداگانه باید با دیتابیس و سیستم مدیریت کنترول‌شده جایگزین شود.', 'ps' => 'پوه شئ چې کله Excel، کاغذي اسناد یا جلا اپونه باید په کنټرول شوي سوداګریز ډیټابیس بدل شي.'],
                [
                    'en' => '<h2>A database becomes useful when records need shared control</h2><p>Many Afghan businesses use the word database for the complete system that stores customers, products, accounts, invoices, stock or staff records. The need usually appears when paper or spreadsheets become difficult to control.</p><h2>Warning signs</h2><ul><li>The same information is entered in several files</li><li>Different staff keep different versions of the truth</li><li>Search, reporting and balances take too long</li><li>Unauthorized edits are difficult to trace</li><li>Branches cannot share approved records reliably</li><li>Backups depend on one laptop or one person</li></ul><h2>Database plus application</h2><p>A professional solution normally includes forms, permissions, validation, workflow, reports and backups around the database. Users should not work directly with raw tables.</p>',
                    'fa' => '<h2>دیتابیس زمانی ارزش دارد که اسناد به کنترول مشترک نیاز داشته باشد</h2><p>در افغانستان بسیاری از تجارت‌ها واژه دیتابیس را برای کل سیستم ثبت مشتری، محصول، حساب، فاکتور، گدام یا کارمند استفاده می‌کنند. نیاز معمولاً زمانی ایجاد می‌شود که کاغذ یا Excel سخت قابل کنترول باشد.</p><h2>نشانه‌ها</h2><ul><li>یک معلومات در چند فایل دوباره ثبت می‌شود</li><li>کارمندان نسخه‌های متفاوت معلومات دارند</li><li>جستجو، گزارش و بیلانس زمان زیاد می‌گیرد</li><li>تغییر غیرمجاز قابل پیگیری نیست</li><li>شعبات اسناد مشترک را درست شریک نمی‌کنند</li><li>بکاپ به یک لپ‌تاپ یا یک شخص وابسته است</li></ul><h2>دیتابیس همراه با برنامه</h2><p>راهکار حرفه‌ای معمولاً فورم، صلاحیت، validation، روند، گزارش و بکاپ را روی دیتابیس فراهم می‌کند.</p>',
                    'ps' => '<h2>ډیټابیس هغه وخت مهمېږي چې اسناد ګډ کنټرول غواړي</h2><p>په افغانستان کې ډېر کاروبارونه د مشتریانو، محصولاتو، حسابونو، انوایسونو، ګدام یا کارکوونکو د ثبت بشپړ سیسټم ته ډیټابیس وايي. اړتیا هغه وخت راځي چې کاغذ یا Excel کنټرولول سخت شي.</p><h2>نښې</h2><ul><li>هماغه معلومات په څو فایلونو کې بیا ثبتېږي</li><li>کارکوونکي د معلوماتو بېلابېلې نسخې لري</li><li>لټون، راپور او بیلانس ډېر وخت نیسي</li><li>غیرمجاز بدلون تعقیبول سخت وي</li><li>څانګې تایید شوي اسناد په سمه توګه نه شریکوي</li><li>بیک‌اپ په یوه لپ‌ټاپ یا شخص پورې تړلی وي</li></ul><h2>ډیټابیس له اپلېکېشن سره</h2><p>مسلکي حل عموماً فورمې، صلاحیتونه، validation، کاري بهیر، راپورونه او بیک‌اپ د ډیټابیس شاوخوا برابروي.</p>',
                ],
                ['en' => 'Business Database Afghanistan | When You Need One', 'fa' => 'دیتابیس تجارتی افغانستان | چه زمانی لازم است؟', 'ps' => 'سوداګریز ډیټابیس افغانستان | کله ورته اړتیا ده؟'],
                ['en' => 'Signs an Afghan business needs a database system instead of paper or Excel, including permissions, reports, backups and multi-user records.', 'fa' => 'نشانه‌های نیاز تجارت افغانستان به سیستم دیتابیس به‌جای کاغذ یا Excel؛ صلاحیت، گزارش، بکاپ و ثبت چندکاربره.', 'ps' => 'هغه نښې چې افغان کاروبار د کاغذ یا Excel پر ځای ډیټابیس ته اړتیا لري؛ صلاحیتونه، راپورونه، بیک‌اپ او ګډ ثبت.'],
                ['en' => 'business database Afghanistan', 'fa' => 'دیتابیس تجارتی افغانستان', 'ps' => 'سوداګریز ډیټابیس افغانستان'],
                ['database-systems-afghanistan', 'software-company-afghanistan', 'custom-software-development-afghanistan']
            ),
            $this->article(
                $categoryId,
                'supermarket-pos-software-afghanistan-guide',
                ['en' => 'Supermarket & POS Software Guide for Afghanistan', 'fa' => 'راهنمای نرم‌افزار سوپرمارکت و POS در افغانستان', 'ps' => 'په افغانستان کې د سوپرمارکېټ او POS سافټویر لارښود'],
                ['en' => 'What shops and supermarkets should check before choosing POS, barcode, inventory, purchasing and cash software.', 'fa' => 'موارد مهم برای انتخاب POS، بارکد، موجودی، خرید و صندوق برای دکان و سوپرمارکت.', 'ps' => 'د دوکان او سوپرمارکېټ لپاره د POS، بارکوډ، موجودي، پېرود او نغدو سیسټم د انتخاب مهم موارد.'],
                [
                    'en' => '<h2>POS should connect the sale to stock and money</h2><p>A supermarket system is not only a billing screen. Sales should update inventory, returns should reverse the correct movement, purchases should build cost history and daily cash should reconcile with receipts.</p><h2>Important capabilities</h2><ul><li>Barcode scanning and fast product search</li><li>Units, packs, categories and price levels</li><li>Purchasing, suppliers and returns</li><li>Inventory, stock count and branch transfers</li><li>Cash, expenses, credit customers and closing</li><li>User permissions and activity history</li></ul><h2>Afghanistan-specific questions</h2><p>Ask whether the system can work with weak internet, local desktop devices, Dari/Pashto, multiple currencies, barcode hardware and local support requirements.</p>',
                    'fa' => '<h2>POS باید فروش را با موجودی و پول وصل کند</h2><p>سیستم سوپرمارکت تنها صفحه بل نیست. فروش باید موجودی را تغییر دهد، برگشت باید حرکت درست را معکوس کند، خرید تاریخچه قیمت بسازد و صندوق روزانه با رسیدها تطبیق شود.</p><h2>امکانات مهم</h2><ul><li>بارکد و جستجوی سریع محصول</li><li>واحد، بسته، کتگوری و سطح قیمت</li><li>خرید، تأمین‌کننده و برگشت</li><li>گدام، شمارش موجودی و انتقال شعبه</li><li>صندوق، مصرف، مشتری قرضی و بستن روز</li><li>صلاحیت کاربران و تاریخچه فعالیت</li></ul><h2>پرسش‌های مخصوص افغانستان</h2><p>کار در اینترنت ضعیف، دستگاه دسکتاپ، دری/پشتو، چندارزی، سخت‌افزار بارکد و پشتیبانی محلی را بررسی کنید.</p>',
                    'ps' => '<h2>POS باید خرڅلاو له موجودي او پیسو سره ونښلوي</h2><p>د سوپرمارکېټ سیسټم یوازې د بل سکرین نه دی. خرڅلاو باید موجودي بدله کړي، return باید سم حرکت بېرته وګرځوي، پېرود د لګښت تاریخ جوړ کړي او ورځنۍ نغدې له رسیدونو سره برابرې شي.</p><h2>مهم امکانات</h2><ul><li>بارکوډ او چټک محصول لټون</li><li>واحدونه، بسته، کتګوري او بیې</li><li>پېرود، عرضه کوونکي او return</li><li>ګدام، stock count او د څانګو انتقال</li><li>نغدې، مصارف، پور مشتریان او ورځنی closing</li><li>د کاروونکو صلاحیتونه او فعالیت تاریخ</li></ul><h2>د افغانستان ځانګړې پوښتنې</h2><p>کمزوری انټرنېټ، desktop وسایل، دري/پښتو، څو اسعار، بارکوډ hardware او محلي ملاتړ وازموئ.</p>',
                ],
                ['en' => 'Supermarket POS Software Afghanistan | Buyer Guide', 'fa' => 'نرم‌افزار سوپرمارکت و POS افغانستان | راهنما', 'ps' => 'سوپرمارکېټ POS سافټویر افغانستان | لارښود'],
                ['en' => 'Buyer guide for supermarket and POS software in Afghanistan covering barcode, inventory, purchasing, cash, credit, offline use and support.', 'fa' => 'راهنمای انتخاب نرم‌افزار سوپرمارکت و POS افغانستان؛ بارکد، گدام، خرید، صندوق، قرض، آفلاین و پشتیبانی.', 'ps' => 'د افغانستان د سوپرمارکېټ او POS د انتخاب لارښود؛ بارکوډ، ګدام، پېرود، نغدې، پور، آفلاین او ملاتړ.'],
                ['en' => 'supermarket software Afghanistan', 'fa' => 'نرم افزار سوپرمارکت افغانستان', 'ps' => 'سوپرمارکېټ سافټویر افغانستان'],
                ['pos-software-afghanistan', 'wholesale-retail-software-afghanistan', 'procurement-inventory-management-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'warehouse-inventory-software-afghanistan-guide',
                ['en' => 'Warehouse & Inventory Software Guide for Afghanistan', 'fa' => 'راهنمای سیستم گدام و موجودی در افغانستان', 'ps' => 'په افغانستان کې د ګدام او موجودي سافټویر لارښود'],
                ['en' => 'How to evaluate warehouse, stock, purchasing, transfers and reporting software for Afghan businesses.', 'fa' => 'روش ارزیابی نرم‌افزار گدام، موجودی، خرید، انتقال و گزارش‌دهی برای تجارت‌های افغانستان.', 'ps' => 'د افغان کاروبارونو لپاره د ګدام، موجودي، پېرود، انتقال او راپور سافټویر د ارزونې لارښود.'],
                [
                    'en' => '<h2>Inventory software should explain every stock movement</h2><p>Good warehouse software records where stock came from, where it went, who moved it and which document authorized the movement.</p><h2>Core workflows</h2><ul><li>Purchase receipt and supplier return</li><li>Warehouse and branch transfer</li><li>Sales issue and customer return</li><li>Stock count, adjustment and damaged stock</li><li>Reorder information and movement history</li><li>Cost and value reporting where accounting requires it</li></ul><h2>Use local terms too</h2><p>In Afghanistan buyers may search for warehouse, stock, inventory, گدام, موجودی, ګدام or موجودي. The underlying requirement is the same: controlled stock records that management can trust.</p>',
                    'fa' => '<h2>سیستم موجودی باید هر حرکت گدام را توضیح دهد</h2><p>نرم‌افزار خوب ثبت می‌کند stock از کجا آمد، کجا رفت، چه کسی انتقال داد و کدام سند اجازه حرکت را داد.</p><h2>روندهای اصلی</h2><ul><li>رسید خرید و برگشت به تأمین‌کننده</li><li>انتقال گدام و شعبه</li><li>صدور فروش و برگشت مشتری</li><li>شمارش، adjustment و stock آسیب‌دیده</li><li>reorder و تاریخچه حرکت</li><li>گزارش قیمت و ارزش در صورت نیاز حسابداری</li></ul><h2>اصطلاحات محلی مهم است</h2><p>در افغانستان کاربران warehouse، stock، inventory، گدام و موجودی را جستجو می‌کنند؛ نیاز اصلی ثبت کنترول‌شده و قابل اعتماد است.</p>',
                    'ps' => '<h2>د موجودي سیسټم باید هر stock movement روښانه کړي</h2><p>ښه ګدام سافټویر ثبتوي چې stock له کومه راغی، چېرته لاړ، چا انتقال کړ او کوم سند اجازه ورکړه.</p><h2>اصلي بهیرونه</h2><ul><li>د پېرود رسید او عرضه کوونکي ته return</li><li>د ګدام او څانګې انتقال</li><li>د خرڅلاو issue او د مشتری return</li><li>stock count، adjustment او خراب stock</li><li>reorder او movement history</li><li>د اړتیا په صورت کې cost او value راپور</li></ul><h2>محلي اصطلاحات هم مهم دي</h2><p>په افغانستان کې خلک warehouse، stock، inventory، ګدام او موجودي لټوي؛ اصلي اړتیا د باور وړ او کنټرول شوی ثبت دی.</p>',
                ],
                ['en' => 'Warehouse & Inventory Software Afghanistan | Guide', 'fa' => 'سیستم گدام و موجودی افغانستان | راهنما', 'ps' => 'د ګدام او موجودي سافټویر افغانستان | لارښود'],
                ['en' => 'Guide to warehouse and inventory software in Afghanistan: purchasing, stock movements, transfers, counts, reporting and branch control.', 'fa' => 'راهنمای سیستم گدام افغانستان؛ خرید، حرکت موجودی، انتقال، شمارش، گزارش و کنترول شعبه.', 'ps' => 'د افغانستان د ګدام سافټویر لارښود؛ پېرود، stock movement، انتقال، شمېرنه، راپور او څانګې کنټرول.'],
                ['en' => 'warehouse software Afghanistan', 'fa' => 'سیستم گدام افغانستان', 'ps' => 'د ګدام سیستم افغانستان'],
                ['procurement-inventory-management-software-afghanistan', 'pos-software-afghanistan', 'erp-systems-afghanistan']
            ),
            $this->article(
                $categoryId,
                'accounting-software-afghanistan-buyers-guide',
                ['en' => 'Accounting Software Buyer Guide for Afghanistan', 'fa' => 'راهنمای انتخاب نرم‌افزار حسابداری در افغانستان', 'ps' => 'په افغانستان کې د حسابدارۍ سافټویر د انتخاب لارښود'],
                ['en' => 'Compare accounting systems by ledgers, cash, bank, receivables, payables, currencies, approvals, audit history and reporting.', 'fa' => 'سیستم حسابداری را براساس ledger، صندوق، بانک، بدهکار، طلبکار، اسعار، تأییدی، audit و گزارش مقایسه کنید.', 'ps' => 'حسابداري سیسټم د ledger، نغدو، بانک، ترلاسه کېدونکو، تادیه کېدونکو، اسعارو، تاییدونو او راپورونو له مخې پرتله کړئ.'],
                [
                    'en' => '<h2>Accounting software should protect the financial record</h2><p>At minimum, the system should maintain a clear chart of accounts, journals, receipts, payments, cash, bank, customer and supplier balances and financial reports.</p><h2>Questions to ask</h2><ul><li>Can posted entries be edited, or are corrections controlled?</li><li>Does it support AFN and other currencies with historical rates?</li><li>Can payments require approval before posting?</li><li>Are receivables and payables linked to parties?</li><li>Can reports reconcile back to transactions?</li><li>Are audit history and backups available?</li></ul><h2>Accounting vs ERP</h2><p>If finance depends heavily on procurement, inventory, payroll, projects or multiple branches, a connected ERP may be more appropriate than a finance-only system.</p>',
                    'fa' => '<h2>نرم‌افزار حسابداری باید ثبت مالی را محافظت کند</h2><p>حداقل باید چارت حساب، ژورنال، دریافت، پرداخت، صندوق، بانک، بیلانس مشتری و تأمین‌کننده و گزارش مالی روشن داشته باشد.</p><h2>پرسش‌های مهم</h2><ul><li>آیا سند posted قابل ویرایش است یا اصلاح کنترول می‌شود؟</li><li>آیا AFN و سایر اسعار با نرخ تاریخی پشتیبانی می‌شود؟</li><li>آیا پرداخت پیش از ثبت به تأیید نیاز دارد؟</li><li>آیا بدهکار و طلبکار به اشخاص وصل است؟</li><li>آیا گزارش با معامله اصلی تطبیق می‌شود؟</li><li>audit history و بکاپ وجود دارد؟</li></ul><h2>حسابداری یا ERP</h2><p>اگر مالی به تدارکات، گدام، معاش، پروژه یا شعبات وابسته است، ERP یکپارچه ممکن است مناسب‌تر باشد.</p>',
                    'ps' => '<h2>حسابداري سافټویر باید مالي ثبت خوندي کړي</h2><p>لږ تر لږه باید د حسابونو چارټ، ژورنال، رسید، تادیه، نغدې، بانک، د مشتری او عرضه کوونکي بیلانس او مالي راپورونه ولري.</p><h2>مهمې پوښتنې</h2><ul><li>ایا posted entry بدلېدای شي که اصلاح کنټرول شوې ده؟</li><li>ایا AFN او نور اسعار له تاریخي نرخ سره ملاتړ کېږي؟</li><li>ایا تادیه تر ثبت مخکې تایید غواړي؟</li><li>ایا receivable او payable له اشخاصو سره تړلي دي؟</li><li>ایا راپور اصلي معاملې ته بېرته reconcile کېږي؟</li><li>audit history او بیک‌اپ شته؟</li></ul><h2>حسابداري که ERP</h2><p>که مالي برخه له تدارکاتو، ګدام، معاش، پروژو یا څانګو سره کلکه تړلې وي، یوځای ERP ښايي غوره وي.</p>',
                ],
                ['en' => 'Accounting Software Afghanistan | Buyer Guide', 'fa' => 'نرم‌افزار حسابداری افغانستان | راهنمای انتخاب', 'ps' => 'حسابداري سافټویر افغانستان | د انتخاب لارښود'],
                ['en' => 'Buyer guide for accounting software in Afghanistan covering ledgers, cash, bank, currencies, approvals, receivables, payables, audit and reports.', 'fa' => 'راهنمای انتخاب نرم‌افزار حسابداری افغانستان؛ ledger، صندوق، بانک، اسعار، تأییدی، بدهکار، طلبکار، audit و گزارش.', 'ps' => 'د افغانستان د حسابدارۍ سافټویر لارښود؛ ledger، نغدې، بانک، اسعار، تاییدونه، receivable، payable، audit او راپورونه.'],
                ['en' => 'accounting software Afghanistan', 'fa' => 'نرم افزار حسابداری افغانستان', 'ps' => 'حسابدارۍ سافټویر افغانستان'],
                ['accounting-software-afghanistan', 'erp-vs-accounting-software-afghanistan', 'financial-management-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'ngo-erp-finance-software-afghanistan-guide',
                ['en' => 'ERP & Finance Software Guide for NGOs in Afghanistan', 'fa' => 'راهنمای ERP و سیستم مالی برای NGOها در افغانستان', 'ps' => 'په افغانستان کې د NGO لپاره د ERP او مالي سافټویر لارښود'],
                ['en' => 'Plan NGO software around grants, budgets, finance, procurement, HR, assets, projects, approvals and donor reporting.', 'fa' => 'نرم‌افزار NGO را براساس grant، بودجه، مالی، تدارکات، HR، دارایی، پروژه، تأییدی و گزارش تمویل‌کننده پلان کنید.', 'ps' => 'د NGO سافټویر د grant، بودجې، مالي، تدارکاتو، HR، شتمنیو، پروژو، تاییدونو او donor راپورونو مطابق پلان کړئ.'],
                [
                    'en' => '<h2>NGO software must connect programme and financial accountability</h2><p>An NGO may need to track funds by donor, grant, project, activity, location and cost category while procurement, HR, assets and payments follow approved controls.</p><h2>Common requirements</h2><ul><li>Grant and budget structure</li><li>Finance and multi-currency accounting</li><li>Procurement requests and approvals</li><li>HR, payroll and timesheet inputs where required</li><li>Assets, inventory and field locations</li><li>Project, activity and donor reporting</li><li>Audit history and document attachments</li></ul><h2>Do not build around a report alone</h2><p>Start with the transactions and approvals that produce the report. Donor and legal requirements should be confirmed by the organization’s authorized finance, compliance and programme teams.</p>',
                    'fa' => '<h2>سیستم NGO باید پاسخگویی برنامه و مالی را وصل کند</h2><p>NGO ممکن است بودجه و مصرف را براساس donor، grant، پروژه، فعالیت، موقعیت و کتگوری هزینه دنبال کند، در حالی که تدارکات، HR، دارایی و پرداخت تحت کنترول باشد.</p><h2>نیازهای معمول</h2><ul><li>ساختار grant و بودجه</li><li>مالی و حسابداری چندارزی</li><li>درخواست تدارکات و تأییدی</li><li>HR، معاش و timesheet در صورت نیاز</li><li>دارایی، موجودی و ساحات</li><li>گزارش پروژه، فعالیت و donor</li><li>audit history و ضمیمه اسناد</li></ul><h2>سیستم را فقط براساس گزارش نسازید</h2><p>از معاملات و تأییدی‌هایی آغاز کنید که گزارش را تولید می‌کند. قواعد donor و قانونی باید توسط تیم‌های مجاز نهاد تأیید شود.</p>',
                    'ps' => '<h2>د NGO سیسټم باید پروګرامي او مالي حساب ورکونه ونښلوي</h2><p>NGO ښايي بودجه او مصرف د donor، grant، پروژې، فعالیت، موقعیت او لګښت کتګورۍ له مخې تعقیب کړي، په داسې حال کې چې تدارکات، HR، شتمنۍ او تادیات کنټرول شوي وي.</p><h2>عامې اړتیاوې</h2><ul><li>grant او بودجې جوړښت</li><li>مالي او څو اسعارو حسابداري</li><li>د تدارکاتو غوښتنې او تاییدونه</li><li>HR، معاش او د اړتیا په صورت کې timesheet</li><li>شتمنۍ، موجودي او ساحوي موقعیتونه</li><li>د پروژې، فعالیت او donor راپورونه</li><li>audit history او اسناد</li></ul><h2>سیسټم یوازې د راپور پر بنسټ مه جوړوئ</h2><p>له هغو معاملو او تاییدونو پیل وکړئ چې راپور جوړوي. donor او قانوني قواعد باید د ادارې مجاز ټیمونه تایید کړي.</p>',
                ],
                ['en' => 'NGO ERP & Finance Software Afghanistan | Guide', 'fa' => 'ERP و سیستم مالی NGO افغانستان | راهنما', 'ps' => 'د NGO ERP او مالي سافټویر افغانستان | لارښود'],
                ['en' => 'Guide to NGO ERP and finance software in Afghanistan for grants, budgets, procurement, HR, assets, projects, approvals and donor reporting.', 'fa' => 'راهنمای ERP و سیستم مالی NGO افغانستان برای grant، بودجه، تدارکات، HR، دارایی، پروژه، تأییدی و donor report.', 'ps' => 'د افغانستان د NGO ERP او مالي سافټویر لارښود؛ grant، بودجه، تدارکات، HR، شتمنۍ، پروژې، تاییدونه او donor راپورونه.'],
                ['en' => 'NGO software Afghanistan', 'fa' => 'سیستم NGO افغانستان', 'ps' => 'د NGO سافټویر افغانستان'],
                ['ngo-ingo-software-afghanistan', 'grant-management-system-afghanistan', 'financial-management-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'sarafi-software-afghanistan-guide',
                ['en' => 'Sarafi, Exchange & Remittance Software Guide for Afghanistan', 'fa' => 'راهنمای نرم‌افزار صرافی، تبادله اسعار و حواله در افغانستان', 'ps' => 'په افغانستان کې د صرافۍ، اسعارو تبادلې او حوالې سافټویر لارښود'],
                ['en' => 'What to evaluate in Sarafi and remittance software: currencies, rates, cash, customer accounts, approvals, statements and audit trails.', 'fa' => 'موارد مهم در سیستم صرافی و حواله: اسعار، نرخ، صندوق، حساب مشتری، تأییدی، statement و audit.', 'ps' => 'د صرافۍ او حوالې سافټویر مهم موارد: اسعار، نرخونه، نغدې، د مشتری حسابونه، تاییدونه، statement او audit.'],
                [
                    'en' => '<h2>Sarafi software needs traceability around every financial movement</h2><p>Exchange and remittance operations combine currencies, cash locations, customer accounts, rates, fees and settlement. Every financial effect should link back to an authorized business transaction.</p><h2>Key capabilities</h2><ul><li>Multi-currency cash and account balances</li><li>Exchange rates with preserved transaction history</li><li>Incoming and outgoing remittance workflows</li><li>Customer and counterparty statements</li><li>Branch and cashier controls</li><li>Approvals, reversals and audit history</li></ul><h2>Compliance rules must be confirmed</h2><p>Identity, monitoring, reporting and regulatory requirements should be defined by the organization’s authorized compliance and legal advisers. Software can enforce approved rules but should not invent them.</p>',
                    'fa' => '<h2>نرم‌افزار صرافی باید هر حرکت مالی را قابل پیگیری سازد</h2><p>صرافی و حواله اسعار، صندوق، حساب مشتری، نرخ، فیس و تسویه را یکجا می‌کند. هر اثر مالی باید به معامله مجاز وصل باشد.</p><h2>امکانات مهم</h2><ul><li>بیلانس چندارزی صندوق و حساب</li><li>نرخ اسعار با تاریخچه معامله</li><li>حواله وارده و صادره</li><li>statement مشتری و طرف مقابل</li><li>کنترول شعبه و cashier</li><li>تأییدی، برگشت و audit history</li></ul><h2>قواعد compliance باید تأیید شود</h2><p>قواعد هویت، monitoring، reporting و regulatory باید توسط مسئولان مجاز compliance و legal نهاد تعیین شود.</p>',
                    'ps' => '<h2>د صرافۍ سافټویر باید هر مالي حرکت د تعقیب وړ کړي</h2><p>صرافي او حواله اسعار، نغدې، د مشتری حسابونه، نرخونه، فیس او settlement یوځای کوي. هر مالي اثر باید له مجازې معاملې سره تړلی وي.</p><h2>مهم امکانات</h2><ul><li>د څو اسعارو نغدي او حساب بیلانس</li><li>د اسعارو نرخ له معاملې تاریخ سره</li><li>داخلي او خارجي حوالې</li><li>د مشتری او مقابل لوري statement</li><li>د څانګې او cashier کنټرول</li><li>تاییدونه، reversals او audit history</li></ul><h2>Compliance قواعد باید تایید شي</h2><p>د هویت، monitoring، reporting او regulatory قواعد باید د ادارې مجاز compliance او legal مسؤلین وټاکي.</p>',
                ],
                ['en' => 'Sarafi & Remittance Software Afghanistan | Guide', 'fa' => 'نرم‌افزار صرافی و حواله افغانستان | راهنما', 'ps' => 'د صرافۍ او حوالې سافټویر افغانستان | لارښود'],
                ['en' => 'Guide to Sarafi, exchange and remittance software in Afghanistan covering currencies, rates, cash, accounts, branches, approvals and audit trails.', 'fa' => 'راهنمای سیستم صرافی و حواله افغانستان؛ اسعار، نرخ، صندوق، حساب، شعبه، تأییدی و audit trail.', 'ps' => 'د افغانستان د صرافۍ او حوالې سافټویر لارښود؛ اسعار، نرخونه، نغدې، حسابونه، څانګې، تاییدونه او audit trail.'],
                ['en' => 'Sarafi software Afghanistan', 'fa' => 'نرم افزار صرافی افغانستان', 'ps' => 'د صرافۍ سافټویر افغانستان'],
                ['sarafi-remittance-software-afghanistan', 'prime-sarafi-software', 'accounting-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'pharmacy-software-afghanistan-guide',
                ['en' => 'Pharmacy Software Guide for Afghanistan', 'fa' => 'راهنمای نرم‌افزار دواخانه در افغانستان', 'ps' => 'په افغانستان کې د درملتون سافټویر لارښود'],
                ['en' => 'How pharmacies and pharmaceutical businesses should evaluate medicine, batch, expiry, purchasing, sales, credit and finance software.', 'fa' => 'راهنمای ارزیابی سیستم دوا، batch، expiry، خرید، فروش، قرض و مالی برای دواخانه و شرکت دارویی.', 'ps' => 'د درملتون او درملو کاروبار لپاره د درملو، batch، expiry، پېرود، خرڅلاو، پور او مالي سیسټم لارښود.'],
                [
                    'en' => '<h2>Pharmacy software must understand medicine stock</h2><p>Medicine inventory often needs more than product and quantity. Batch, expiry, pack, unit, manufacturer, supplier, price and storage location may all matter.</p><h2>Useful workflows</h2><ul><li>Medicine catalogue and barcode</li><li>Supplier purchasing and receipt</li><li>Batch and expiry stock control</li><li>Retail or wholesale sales and returns</li><li>Cash, credit, receivables and payables</li><li>Expiry, low-stock and movement reports</li></ul><h2>Regulatory decisions stay with authorized professionals</h2><p>Software should apply approved rules but must not determine clinical or regulatory eligibility by itself.</p>',
                    'fa' => '<h2>نرم‌افزار دواخانه باید موجودی دوا را درست درک کند</h2><p>برای دوا تنها نام و تعداد کافی نیست. batch، expiry، بسته، واحد، manufacturer، supplier، قیمت و موقعیت گدام مهم است.</p><h2>روندهای مفید</h2><ul><li>catalogue دوا و بارکد</li><li>خرید و receipt تأمین‌کننده</li><li>کنترول batch و expiry</li><li>فروش retail یا wholesale و return</li><li>cash، credit، receivable و payable</li><li>گزارش expiry، low stock و movement</li></ul><h2>تصمیم regulatory با مسئول مجاز است</h2><p>سیستم باید قواعد تأییدشده را اجرا کند اما خود eligibility طبی یا قانونی را تعیین نکند.</p>',
                    'ps' => '<h2>د درملتون سافټویر باید د درملو stock سم مدیریت کړي</h2><p>د درملو لپاره یوازې نوم او شمېر کافي نه دی. batch، expiry، بسته، واحد، manufacturer، supplier، بیه او د ګدام موقعیت مهم وي.</p><h2>ګټور بهیرونه</h2><ul><li>د درملو catalogue او بارکوډ</li><li>د عرضه کوونکي پېرود او receipt</li><li>batch او expiry کنټرول</li><li>retail یا wholesale خرڅلاو او return</li><li>cash، credit، receivable او payable</li><li>expiry، low stock او movement راپورونه</li></ul><h2>Regulatory پرېکړې د مجاز مسؤل دي</h2><p>سیسټم باید تایید شوي قواعد پلي کړي، خو طبي یا قانوني eligibility پخپله ونه ټاکي.</p>',
                ],
                ['en' => 'Pharmacy Software Afghanistan | Buyer Guide', 'fa' => 'نرم‌افزار دواخانه افغانستان | راهنمای انتخاب', 'ps' => 'د درملتون سافټویر افغانستان | د انتخاب لارښود'],
                ['en' => 'Pharmacy software guide for Afghanistan covering medicine catalogue, barcode, batch, expiry, purchasing, sales, credit, stock and finance.', 'fa' => 'راهنمای نرم‌افزار دواخانه افغانستان؛ دوا، بارکد، batch، expiry، خرید، فروش، قرض، موجودی و مالی.', 'ps' => 'د افغانستان د درملتون سافټویر لارښود؛ درمل، بارکوډ، batch، expiry، پېرود، خرڅلاو، پور، موجودي او مالي.'],
                ['en' => 'pharmacy software Afghanistan', 'fa' => 'نرم افزار دواخانه افغانستان', 'ps' => 'د درملتون سافټویر افغانستان'],
                ['pharmacy-pharmaceutical-software-afghanistan', 'darmal-pharmacy-erp', 'procurement-inventory-management-software-afghanistan']
            ),
        ];
    }

    private function article(?int $categoryId, string $slug, array $title, array $summary, array $body, array $metaTitle, array $metaDescription, array $primaryQuery, array $related): array
    {
        return [
            'type' => 'article',
            'article_category_id' => $categoryId,
            'slug' => $slug,
            'title' => $title,
            'eyebrow' => ['en' => 'Fida Answers', 'fa' => 'پاسخ‌های فیدا', 'ps' => 'د فیدا ځوابونه'],
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
            'sitemap_last_modified_at' => now(),
            'metadata' => ['related_slugs' => $related],
            'status' => 'published',
            'featured' => false,
            'sort_order' => 1000,
            'published_at' => now(),
        ];
    }
}
