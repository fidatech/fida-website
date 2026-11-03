<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class SearchAuthorityContentWaveTwoSeeder extends Seeder
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
                'multi-currency-accounting-software-afghanistan',
                ['en'=>'Multi-Currency Accounting Software in Afghanistan','fa'=>'نرم‌افزار حسابداری چندارزی در افغانستان','ps'=>'په افغانستان کې د څو اسعارو حسابدارۍ سافټویر'],
                ['en'=>'How Afghan businesses should handle AFN, USD and other currencies with preserved exchange rates and clear reporting.','fa'=>'مدیریت AFN، USD و سایر اسعار با نرخ تاریخی، ثبت دقیق و گزارش روشن.','ps'=>'د AFN، USD او نورو اسعارو مدیریت له تاریخي نرخونو او روښانه راپورونو سره.'],
                [
                    'en'=>'<h2>Multi-currency accounting needs historical rates</h2><p>A reliable system stores the transaction currency, amount, exchange rate and base-currency equivalent at the time of posting. Later rate changes should not silently rewrite past transactions.</p><h2>Key controls</h2><ul><li>Configurable base currency</li><li>Manual or approved exchange rates</li><li>Cash and bank balances by currency</li><li>Receivables and payables by original currency</li><li>Exchange gain/loss treatment where required</li><li>Currency position and management reports</li></ul><p>For Afghan organizations operating in AFN, USD and other currencies, rate ownership and approval should be clearly assigned.</p>',
                    'fa'=>'<h2>حسابداری چندارزی به نرخ تاریخی نیاز دارد</h2><p>سیستم قابل اعتماد ارز معامله، مبلغ، نرخ تبدیل و معادل ارز پایه را در زمان ثبت حفظ می‌کند. تغییر نرخ آینده نباید معامله گذشته را تغییر دهد.</p><h2>کنترول‌های مهم</h2><ul><li>ارز پایه قابل تنظیم</li><li>نرخ دستی یا تأییدشده</li><li>بیلانس صندوق و بانک به تفکیک ارز</li><li>طلب و بدهی با ارز اصلی</li><li>سود/زیان تفاوت نرخ در صورت نیاز</li><li>گزارش موقعیت اسعار</li></ul>',
                    'ps'=>'<h2>د څو اسعارو حسابداري تاریخي نرخ ته اړتیا لري</h2><p>باوري سیسټم د معاملې اسعار، مبلغ، د تبادلې نرخ او د base currency معادل د ثبت پر وخت ساتي. راتلونکی نرخ باید پخوانۍ معامله بدله نه کړي.</p><h2>مهم کنټرولونه</h2><ul><li>د تنظیم وړ base currency</li><li>لاسي یا تایید شوی نرخ</li><li>د نغدو او بانک بیلانس د اسعارو له مخې</li><li>receivable او payable په اصلي اسعارو</li><li>د اړتیا په صورت کې exchange gain/loss</li><li>د اسعارو موقعیت راپور</li></ul>'
                ],
                ['en'=>'Multi-Currency Accounting Afghanistan | Fida','fa'=>'حسابداری چندارزی افغانستان | فدا','ps'=>'څو اسعارو حسابداري افغانستان | فدا'],
                ['en'=>'Guide to multi-currency accounting software in Afghanistan for AFN, USD and other currencies with historical rates, balances and reporting.','fa'=>'راهنمای حسابداری چندارزی افغانستان برای AFN، USD و سایر اسعار با نرخ تاریخی و گزارش دقیق.','ps'=>'د افغانستان د څو اسعارو حسابدارۍ لارښود د AFN، USD او نورو اسعارو لپاره.'],
                ['en'=>'multi currency accounting software Afghanistan','fa'=>'حسابداری چندارزی افغانستان','ps'=>'څو اسعارو حسابداري افغانستان'],
                ['accounting-software-afghanistan','financial-management-software-afghanistan','erp-systems-afghanistan']
            ),
            $this->article(
                $categoryId,
                'cash-bank-management-software-afghanistan',
                ['en'=>'Cash & Bank Management Software in Afghanistan','fa'=>'سیستم مدیریت صندوق و بانک در افغانستان','ps'=>'په افغانستان کې د نغدو او بانک مدیریت سافټویر'],
                ['en'=>'Control cash accounts, bank accounts, transfers, deposits, withdrawals, reconciliation and approvals in one system.','fa'=>'مدیریت صندوق، بانک، انتقال، واریز، برداشت، reconciliation و تأییدی در یک سیستم.','ps'=>'نغدې، بانک، انتقال، deposit، withdrawal، reconciliation او تاییدونه په یوه سیسټم کې.'],
                [
                    'en'=>'<h2>Cash and bank records should reconcile to the ledger</h2><p>Every receipt, payment, transfer, deposit and withdrawal should identify the account, currency, date, user and supporting transaction.</p><h2>Useful capabilities</h2><ul><li>Multiple cash and bank accounts</li><li>Cash-to-bank and bank-to-bank transfers</li><li>Opening and current balances</li><li>Payment approvals and proof attachments</li><li>Bank reconciliation</li><li>Daily closing and account statements</li></ul>',
                    'fa'=>'<h2>صندوق و بانک باید با ledger تطبیق شود</h2><p>هر دریافت، پرداخت، انتقال، واریز و برداشت باید حساب، ارز، تاریخ، کاربر و سند اصلی را مشخص کند.</p><h2>امکانات مهم</h2><ul><li>چند صندوق و حساب بانکی</li><li>انتقال صندوق به بانک و بانک به بانک</li><li>بیلانس افتتاحیه و جاری</li><li>تأییدی پرداخت و ضمیمه سند</li><li>bank reconciliation</li><li>بستن روزانه و statement</li></ul>',
                    'ps'=>'<h2>د نغدو او بانک ثبت باید له ledger سره برابر وي</h2><p>هر receipt، payment، transfer، deposit او withdrawal باید حساب، اسعار، نېټه، کاروونکی او اصلي سند وښيي.</p><h2>مهم امکانات</h2><ul><li>څو نغدي او بانکي حسابونه</li><li>cash-to-bank او bank-to-bank انتقال</li><li>افتتاحي او اوسنی بیلانس</li><li>د تادیاتو تایید او اسناد</li><li>bank reconciliation</li><li>ورځنی closing او statement</li></ul>'
                ],
                ['en'=>'Cash & Bank Management Software Afghanistan','fa'=>'سیستم صندوق و بانک افغانستان','ps'=>'د نغدو او بانک سیستم افغانستان'],
                ['en'=>'Cash and bank management software in Afghanistan with transfers, approvals, statements and reconciliation.','fa'=>'سیستم صندوق و بانک افغانستان با انتقال، تأییدی، statement و reconciliation.','ps'=>'په افغانستان کې د نغدو او بانک سیسټم له انتقال، تایید، statement او reconciliation سره.'],
                ['en'=>'cash bank management software Afghanistan','fa'=>'سیستم صندوق و بانک افغانستان','ps'=>'د نغدو او بانک سیستم افغانستان'],
                ['financial-management-software-afghanistan','accounting-software-afghanistan','erp-systems-afghanistan']
            ),
            $this->article(
                $categoryId,
                'payroll-software-afghanistan-guide',
                ['en'=>'Payroll Software Guide for Afghanistan','fa'=>'راهنمای نرم‌افزار معاش در افغانستان','ps'=>'په افغانستان کې د معاش سافټویر لارښود'],
                ['en'=>'Evaluate payroll software by employees, contracts, attendance inputs, allowances, deductions, approvals, currencies and payroll posting.','fa'=>'ارزیابی سیستم معاش براساس کارمند، قرارداد، حاضری، امتیاز، کسر، تأییدی، اسعار و ثبت مالی.','ps'=>'د معاش سیسټم د کارکوونکو، قرارداد، حاضري، امتیاز، کسر، تایید، اسعارو او مالي ثبت له مخې وازموئ.'],
                [
                    'en'=>'<h2>Payroll starts with approved employee and attendance data</h2><p>A payroll system should connect employee records, contract terms, attendance or approved inputs, allowances, deductions and payment status without allowing silent changes after approval.</p><h2>Questions to check</h2><ul><li>Who can change salary components?</li><li>How are attendance and leave inputs approved?</li><li>Can payroll be reviewed before posting?</li><li>How are advances and deductions handled?</li><li>Can payroll post to finance by department or cost center?</li></ul>',
                    'fa'=>'<h2>معاش با معلومات تأییدشده کارمند و حاضری آغاز می‌شود</h2><p>سیستم معاش باید کارمند، قرارداد، حاضری یا input تأییدشده، امتیاز، کسر و وضعیت پرداخت را وصل کند و پس از تأیید تغییر خاموش نداشته باشد.</p><h2>پرسش‌های مهم</h2><ul><li>چه کسی اجزای معاش را تغییر می‌دهد؟</li><li>حاضری و رخصتی چگونه تأیید می‌شود؟</li><li>آیا payroll پیش از posting review می‌شود؟</li><li>advance و deduction چگونه اداره می‌شود؟</li><li>آیا ثبت مالی بر اساس department/cost center انجام می‌شود؟</li></ul>',
                    'ps'=>'<h2>معاش د تایید شوو کارکوونکو او حاضري معلوماتو څخه پیلېږي</h2><p>د معاش سیسټم باید کارکوونکی، قرارداد، حاضري، تایید شوي input، امتیاز، کسر او د تادیې حالت سره ونښلوي.</p><h2>مهمې پوښتنې</h2><ul><li>څوک د معاش اجزا بدلولی شي؟</li><li>حاضري او رخصتي څنګه تاییدېږي؟</li><li>ایا payroll تر posting مخکې review کېږي؟</li><li>advance او deduction څنګه اداره کېږي؟</li><li>ایا مالي ثبت د department/cost center له مخې کېږي؟</li></ul>'
                ],
                ['en'=>'Payroll Software Afghanistan | Buyer Guide','fa'=>'نرم‌افزار معاش افغانستان | راهنما','ps'=>'د معاش سافټویر افغانستان | لارښود'],
                ['en'=>'Payroll software guide for Afghanistan covering HR records, attendance, allowances, deductions, approvals and finance posting.','fa'=>'راهنمای نرم‌افزار معاش افغانستان؛ HR، حاضری، امتیاز، کسر، تأییدی و posting مالی.','ps'=>'د افغانستان د معاش سافټویر لارښود؛ HR، حاضري، امتیاز، کسر، تایید او مالي posting.'],
                ['en'=>'payroll software Afghanistan','fa'=>'نرم افزار معاش افغانستان','ps'=>'د معاش سافټویر افغانستان'],
                ['hrmis-payroll-software-afghanistan','accounting-software-afghanistan','erp-systems-afghanistan']
            ),
            $this->article(
                $categoryId,
                'restaurant-pos-software-afghanistan',
                ['en'=>'Restaurant POS Software in Afghanistan: Buyer Guide','fa'=>'راهنمای سیستم POS رستورانت در افغانستان','ps'=>'په افغانستان کې د رستورانت POS سافټویر لارښود'],
                ['en'=>'What restaurants should evaluate in POS, order, kitchen, table, cash, inventory and reporting software.','fa'=>'موارد مهم POS رستورانت؛ سفارش، آشپزخانه، میز، صندوق، موجودی و گزارش.','ps'=>'د رستورانت POS مهم موارد؛ فرمایش، پخلنځی، مېز، نغدې، موجودي او راپور.'],
                [
                    'en'=>'<h2>Restaurant POS is an operational workflow</h2><p>Orders move from waiter or counter to kitchen, billing, payment and management reporting. The system should keep those stages connected.</p><h2>Useful features</h2><ul><li>Table, takeaway and delivery orders</li><li>Kitchen tickets or kitchen display</li><li>Menu items, modifiers and pricing</li><li>Cashier permissions and shift closing</li><li>Ingredient or item stock where required</li><li>Sales, discount and profitability reports</li></ul>',
                    'fa'=>'<h2>POS رستورانت یک روند عملیاتی است</h2><p>سفارش از waiter یا counter به kitchen، بل، پرداخت و گزارش مدیریت می‌رود و باید مراحل به هم وصل باشد.</p><h2>امکانات مهم</h2><ul><li>میز، takeaway و delivery</li><li>kitchen ticket یا display</li><li>menu، modifier و قیمت</li><li>صلاحیت cashier و shift closing</li><li>موجودی مواد یا اقلام در صورت نیاز</li><li>گزارش فروش، تخفیف و profitability</li></ul>',
                    'ps'=>'<h2>د رستورانت POS یو عملیاتي بهیر دی</h2><p>فرمایش له waiter یا counter څخه kitchen، بل، تادیې او مدیریتي راپور ته ځي او باید ټول پړاوونه سره ونښلول شي.</p><h2>مهم امکانات</h2><ul><li>مېز، takeaway او delivery</li><li>kitchen ticket یا display</li><li>menu، modifier او بیې</li><li>cashier صلاحیت او shift closing</li><li>د اړتیا په صورت کې موادو stock</li><li>د خرڅلاو او profitability راپورونه</li></ul>'
                ],
                ['en'=>'Restaurant POS Software Afghanistan | Guide','fa'=>'POS رستورانت افغانستان | راهنما','ps'=>'د رستورانت POS افغانستان | لارښود'],
                ['en'=>'Restaurant POS software guide for Afghanistan covering orders, kitchen, tables, cash, inventory and reports.','fa'=>'راهنمای POS رستورانت افغانستان؛ سفارش، kitchen، میز، صندوق، موجودی و گزارش.','ps'=>'د افغانستان د رستورانت POS لارښود؛ فرمایش، kitchen، مېز، نغدې، موجودي او راپور.'],
                ['en'=>'restaurant POS software Afghanistan','fa'=>'سیستم POS رستورانت افغانستان','ps'=>'د رستورانت POS افغانستان'],
                ['pos-software-afghanistan','accounting-software-afghanistan','procurement-inventory-management-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'wholesale-distribution-software-afghanistan',
                ['en'=>'Wholesale & Distribution Software in Afghanistan','fa'=>'نرم‌افزار عمده‌فروشی و توزیع در افغانستان','ps'=>'په افغانستان کې د عمده پلور او توزیع سافټویر'],
                ['en'=>'Connect purchasing, warehouses, price levels, sales, customer credit, delivery and finance for wholesale operations.','fa'=>'اتصال خرید، گدام، سطح قیمت، فروش، قرض مشتری، توزیع و مالی برای عمده‌فروشی.','ps'=>'د عمده پلور لپاره پېرود، ګدام، بیې، خرڅلاو، د مشتری پور، delivery او مالي چارې سره ونښلوئ.'],
                [
                    'en'=>'<h2>Wholesale software should connect stock, credit and delivery</h2><p>Distributors often manage large catalogues, multiple warehouses, customer-specific prices, credit limits, sales orders and delivery routes.</p><h2>Core capabilities</h2><ul><li>Purchasing and supplier balances</li><li>Warehouse and branch stock</li><li>Retail/wholesale price levels</li><li>Customer credit and statements</li><li>Sales orders, invoices and returns</li><li>Delivery status and finance integration</li></ul>',
                    'fa'=>'<h2>سیستم عمده‌فروشی باید stock، قرض و delivery را وصل کند</h2><p>توزیع‌کننده معمولاً catalogue بزرگ، چند گدام، قیمت مخصوص مشتری، credit limit، سفارش فروش و delivery را مدیریت می‌کند.</p><h2>امکانات اصلی</h2><ul><li>خرید و بیلانس supplier</li><li>گدام و stock شعبه</li><li>سطح قیمت retail/wholesale</li><li>قرض مشتری و statement</li><li>sales order، invoice و return</li><li>وضعیت delivery و اتصال مالی</li></ul>',
                    'ps'=>'<h2>د عمده پلور سیسټم باید stock، پور او delivery سره ونښلوي</h2><p>توزیع کوونکي عموماً لوی catalogue، څو ګدامونه، د مشتری ځانګړې بیې، credit limit، sales order او delivery مدیریت کوي.</p><h2>اصلي امکانات</h2><ul><li>پېرود او supplier بیلانس</li><li>ګدام او د څانګې stock</li><li>retail/wholesale بیې</li><li>د مشتری پور او statement</li><li>sales order، invoice او return</li><li>delivery status او مالي ادغام</li></ul>'
                ],
                ['en'=>'Wholesale Distribution Software Afghanistan','fa'=>'نرم‌افزار عمده‌فروشی افغانستان','ps'=>'د عمده پلور سافټویر افغانستان'],
                ['en'=>'Wholesale and distribution software in Afghanistan for purchasing, warehouses, pricing, credit, sales, delivery and finance.','fa'=>'نرم‌افزار عمده‌فروشی افغانستان برای خرید، گدام، قیمت، قرض، فروش، delivery و مالی.','ps'=>'په افغانستان کې د عمده پلور سافټویر د پېرود، ګدام، بیې، پور، خرڅلاو، delivery او مالي لپاره.'],
                ['en'=>'wholesale software Afghanistan','fa'=>'نرم افزار عمده فروشی افغانستان','ps'=>'د عمده پلور سافټویر افغانستان'],
                ['wholesale-retail-software-afghanistan','pos-software-afghanistan','procurement-inventory-management-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'fmcg-distribution-software-afghanistan',
                ['en'=>'FMCG Distribution Software in Afghanistan','fa'=>'نرم‌افزار توزیع FMCG در افغانستان','ps'=>'په افغانستان کې د FMCG توزیع سافټویر'],
                ['en'=>'Plan FMCG distribution around fast-moving stock, routes, sales teams, customer credit, returns and warehouse replenishment.','fa'=>'سیستم FMCG برای stock سریع، route، تیم فروش، قرض مشتری، return و replenishment گدام.','ps'=>'د FMCG سیسټم د چټک stock، route، sales team، د مشتری پور، return او ګدام replenishment لپاره.'],
                [
                    'en'=>'<h2>FMCG distribution needs speed and stock visibility</h2><p>Fast-moving goods require accurate stock, quick order capture, route or territory control, customer balances and frequent replenishment.</p><h2>Important workflows</h2><ul><li>Product and pack management</li><li>Warehouse and van stock where applicable</li><li>Sales orders and route delivery</li><li>Customer credit limits and collections</li><li>Returns, damaged goods and promotions</li><li>Daily sales and stock reports</li></ul>',
                    'fa'=>'<h2>توزیع FMCG به سرعت و دید موجودی نیاز دارد</h2><p>کالاهای سریع‌فروش به stock دقیق، ثبت سریع order، کنترول route/territory، بیلانس مشتری و replenishment مکرر نیاز دارد.</p><h2>روندهای مهم</h2><ul><li>product و pack</li><li>گدام و van stock در صورت نیاز</li><li>sales order و route delivery</li><li>credit limit و collection مشتری</li><li>return، damaged goods و promotion</li><li>گزارش روزانه فروش و stock</li></ul>',
                    'ps'=>'<h2>FMCG توزیع چټکتیا او د stock روڼتیا غواړي</h2><p>چټک پلورل کېدونکي توکي دقیق stock، چټک order، route/territory کنټرول، د مشتری بیلانس او مکرر replenishment غواړي.</p><h2>مهم بهیرونه</h2><ul><li>product او pack مدیریت</li><li>د اړتیا په صورت کې ګدام او van stock</li><li>sales order او route delivery</li><li>د مشتری credit limit او collection</li><li>return، damaged goods او promotion</li><li>ورځنی sales او stock راپور</li></ul>'
                ],
                ['en'=>'FMCG Distribution Software Afghanistan','fa'=>'نرم‌افزار توزیع FMCG افغانستان','ps'=>'د FMCG توزیع سافټویر افغانستان'],
                ['en'=>'FMCG distribution software in Afghanistan for stock, routes, sales teams, customer credit, returns and replenishment.','fa'=>'نرم‌افزار توزیع FMCG افغانستان برای stock، route، فروش، قرض مشتری، return و replenishment.','ps'=>'په افغانستان کې د FMCG توزیع سافټویر د stock، route، sales team، پور، return او replenishment لپاره.'],
                ['en'=>'FMCG distribution software Afghanistan','fa'=>'نرم افزار توزیع FMCG افغانستان','ps'=>'د FMCG توزیع سافټویر افغانستان'],
                ['wholesale-retail-software-afghanistan','transport-logistics-software-afghanistan','procurement-inventory-management-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'cargo-logistics-software-afghanistan-guide',
                ['en'=>'Cargo & Logistics Software Guide for Afghanistan','fa'=>'راهنمای نرم‌افزار کارگو و لوژستیک در افغانستان','ps'=>'په افغانستان کې د کارګو او لوژستیک سافټویر لارښود'],
                ['en'=>'Evaluate cargo software for bookings, shipments, vehicles, drivers, routes, charges, customer balances and proof of delivery.','fa'=>'ارزیابی سیستم کارگو برای booking، shipment، موتر، driver، route، charge، بیلانس مشتری و proof of delivery.','ps'=>'د cargo سیسټم د booking، shipment، موټر، driver، route، charge، د مشتری بیلانس او proof of delivery له مخې وازموئ.'],
                [
                    'en'=>'<h2>Cargo software should track the shipment lifecycle</h2><p>A shipment moves from booking and pickup through dispatch, transit, delivery and financial settlement. The system should preserve status changes and responsible users.</p><h2>Useful capabilities</h2><ul><li>Booking and shipment numbers</li><li>Sender, receiver and customer accounts</li><li>Vehicle, driver and route records</li><li>Charges, payments and outstanding balances</li><li>Status updates and proof of delivery</li><li>Branch and operational reporting</li></ul>',
                    'fa'=>'<h2>سیستم کارگو باید چرخه shipment را دنبال کند</h2><p>shipment از booking و pickup تا dispatch، transit، delivery و settlement مالی پیش می‌رود و status و مسئول باید حفظ شود.</p><h2>امکانات مهم</h2><ul><li>booking و shipment number</li><li>sender، receiver و customer account</li><li>موتر، driver و route</li><li>charge، payment و outstanding</li><li>status و proof of delivery</li><li>گزارش شعبه و عملیات</li></ul>',
                    'ps'=>'<h2>د cargo سیسټم باید د shipment ژوند دوره تعقیب کړي</h2><p>shipment له booking او pickup څخه dispatch، transit، delivery او مالي settlement ته ځي او status او مسؤل باید ثبت وي.</p><h2>مهم امکانات</h2><ul><li>booking او shipment number</li><li>sender، receiver او customer account</li><li>موټر، driver او route</li><li>charge، payment او outstanding</li><li>status او proof of delivery</li><li>د څانګې او عملیاتو راپورونه</li></ul>'
                ],
                ['en'=>'Cargo Logistics Software Afghanistan | Guide','fa'=>'سیستم کارگو و لوژستیک افغانستان | راهنما','ps'=>'د کارګو او لوژستیک سافټویر افغانستان | لارښود'],
                ['en'=>'Cargo and logistics software guide for Afghanistan covering shipments, vehicles, routes, charges, balances and delivery proof.','fa'=>'راهنمای سیستم کارگو افغانستان؛ shipment، موتر، route، charge، بیلانس و proof of delivery.','ps'=>'د افغانستان د cargo سافټویر لارښود؛ shipment، موټر، route، charge، بیلانس او proof of delivery.'],
                ['en'=>'cargo software Afghanistan','fa'=>'نرم افزار کارگو افغانستان','ps'=>'د کارګو سافټویر افغانستان'],
                ['transport-logistics-software-afghanistan','accounting-software-afghanistan','crm-customer-service-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'mining-erp-afghanistan-guide',
                ['en'=>'Mining ERP Software Guide for Afghanistan','fa'=>'راهنمای سیستم ERP معدن در افغانستان','ps'=>'په افغانستان کې د کانونو ERP سافټویر لارښود'],
                ['en'=>'Plan mining ERP around extraction, production, warehouses, sales, finance, HR, equipment, approvals and shareholder reporting.','fa'=>'ERP معدن برای استخراج، تولید، گدام، فروش، مالی، HR، تجهیزات، تأییدی و گزارش سهامداران.','ps'=>'د کانونو ERP د استخراج، تولید، ګدام، خرڅلاو، مالي، HR، تجهیزاتو، تاییدونو او شریکانو راپورونو لپاره.'],
                [
                    'en'=>'<h2>Mining ERP connects extraction to finance</h2><p>Mining operations can involve sites, extracted material, processing, warehouses, equipment, workers, transport, sales and shareholder funding. A useful ERP connects those records without losing operational detail.</p><h2>Common modules</h2><ul><li>Extraction and production records</li><li>Multiple warehouses and stock movement</li><li>Equipment, fuel and maintenance</li><li>Customers, suppliers and sales</li><li>Finance, cash, bank and approvals</li><li>HR, payroll and worker records</li><li>Shareholder deposits, withdrawals and reports where applicable</li></ul>',
                    'fa'=>'<h2>ERP معدن استخراج را به مالی وصل می‌کند</h2><p>عملیات معدن شامل ساحه، مواد استخراج‌شده، پروسس، گدام، تجهیزات، کارگران، انتقال، فروش و سرمایه سهامداران می‌شود. ERP باید این اسناد را به هم وصل کند.</p><h2>ماژول‌های معمول</h2><ul><li>ثبت استخراج و تولید</li><li>چند گدام و حرکت stock</li><li>تجهیزات، سوخت و maintenance</li><li>مشتری، supplier و فروش</li><li>مالی، صندوق، بانک و تأییدی</li><li>HR، معاش و کارگران</li><li>deposit، withdrawal و گزارش سهامداران در صورت نیاز</li></ul>',
                    'ps'=>'<h2>د کانونو ERP استخراج له مالي سره نښلوي</h2><p>د کان عملیات ساحې، استخراج شوي مواد، پروسس، ګدام، تجهیزات، کارکوونکي، ترانسپورت، خرڅلاو او د شریکانو پانګه لري. ERP باید دا اسناد سره ونښلوي.</p><h2>عام ماډیولونه</h2><ul><li>د استخراج او تولید ثبت</li><li>څو ګدامونه او stock movement</li><li>تجهیزات، تېل او maintenance</li><li>مشتریان، supplier او خرڅلاو</li><li>مالي، نغدې، بانک او تاییدونه</li><li>HR، معاش او کارکوونکي</li><li>د اړتیا په صورت کې د شریکانو deposit، withdrawal او راپورونه</li></ul>'
                ],
                ['en'=>'Mining ERP Software Afghanistan | Guide','fa'=>'ERP معدن افغانستان | راهنما','ps'=>'د کانونو ERP افغانستان | لارښود'],
                ['en'=>'Mining ERP guide for Afghanistan covering extraction, production, warehouses, equipment, sales, finance, HR and shareholder reporting.','fa'=>'راهنمای ERP معدن افغانستان؛ استخراج، تولید، گدام، تجهیزات، فروش، مالی، HR و گزارش سهامداران.','ps'=>'د افغانستان د کانونو ERP لارښود؛ استخراج، تولید، ګدام، تجهیزات، خرڅلاو، مالي، HR او شریکانو راپورونه.'],
                ['en'=>'mining ERP Afghanistan','fa'=>'سیستم ERP معدن افغانستان','ps'=>'د کانونو ERP افغانستان'],
                ['mining-extractives-software-afghanistan','manufacturing-erp-software-afghanistan','financial-management-software-afghanistan']
            ),
        ];
    }

    private function article(?int $categoryId, string $slug, array $title, array $summary, array $body, array $metaTitle, array $metaDescription, array $primaryQuery, array $related): array
    {
        return [
            'type'=>'article',
            'article_category_id'=>$categoryId,
            'slug'=>$slug,
            'title'=>$title,
            'eyebrow'=>['en'=>'Fida Answers','fa'=>'پاسخ‌های فدا','ps'=>'د فدا ځوابونه'],
            'summary'=>$summary,
            'body'=>$body,
            'meta_title'=>$metaTitle,
            'meta_description'=>$metaDescription,
            'primary_query'=>$primaryQuery,
            'search_intent'=>'informational',
            'robots_directive'=>'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
            'sitemap_included'=>true,
            'sitemap_priority'=>0.7,
            'sitemap_change_frequency'=>'monthly',
            'sitemap_last_modified_at'=>now(),
            'metadata'=>['related_slugs'=>$related],
            'status'=>'published',
            'featured'=>false,
            'sort_order'=>1100,
            'published_at'=>now(),
        ];
    }
}
