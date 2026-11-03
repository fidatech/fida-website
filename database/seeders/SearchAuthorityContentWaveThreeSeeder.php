<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class SearchAuthorityContentWaveThreeSeeder extends Seeder
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
                'receivables-payables-software-afghanistan',
                ['en'=>'Receivables & Payables Software in Afghanistan','fa'=>'نرم‌افزار بدهکاران و طلبکاران در افغانستان','ps'=>'په افغانستان کې د ترلاسه کېدونکو او تادیه کېدونکو حسابونو سافټویر'],
                ['en'=>'Track customer receivables, supplier payables, due dates, settlements, aging, statements and approvals with finance integration.','fa'=>'مدیریت طلب مشتری، بدهی تأمین‌کننده، سررسید، تسویه، aging، statement و تأییدی با اتصال مالی.','ps'=>'د مشتری receivable، supplier payable، due date، settlement، aging، statement او تاییدونه له مالي سره وصل کړئ.'],
                [
                    'en'=>'<h2>Receivables and payables need clear ownership</h2><p>A good system should show who owes the business, whom the business owes, why the balance exists, when it is due and which transaction created it.</p><h2>Useful controls</h2><ul><li>Customer and supplier statements</li><li>Partial and full settlements</li><li>Due dates and aging buckets</li><li>Opening balances with documented sources</li><li>Payment approvals for supplier liabilities</li><li>Links to invoices, receipts, payments and journals</li></ul><p>Management reports should reconcile to the accounting ledger rather than maintain an independent balance.</p>',
                    'fa'=>'<h2>بدهکار و طلبکار به مسئولیت روشن نیاز دارد</h2><p>سیستم باید نشان دهد چه کسی به شرکت بدهکار است، شرکت به چه کسی بدهکار است، بیلانس چرا ایجاد شده، چه زمانی سررسید است و از کدام معامله آمده است.</p><h2>کنترول‌های مهم</h2><ul><li>statement مشتری و تأمین‌کننده</li><li>تسویه کامل و جزئی</li><li>due date و aging</li><li>opening balance با منبع مستند</li><li>تأییدی پرداخت بدهی supplier</li><li>اتصال به invoice، receipt، payment و journal</li></ul>',
                    'ps'=>'<h2>Receivable او payable روښانه مسؤلیت غواړي</h2><p>سیسټم باید وښيي چې څوک شرکت ته پوروړی دی، شرکت چا ته پوروړی دی، بیلانس ولې جوړ شوی، کله due دی او کومه معامله یې سرچینه ده.</p><h2>مهم کنټرولونه</h2><ul><li>د مشتری او supplier statement</li><li>partial او full settlement</li><li>due date او aging</li><li>opening balance له مستند source سره</li><li>د supplier liability د payment approval</li><li>له invoice، receipt، payment او journal سره لینک</li></ul>'
                ],
                ['en'=>'Receivables & Payables Software Afghanistan','fa'=>'سیستم بدهکار و طلبکار افغانستان','ps'=>'Receivable او Payable سافټویر افغانستان'],
                ['en'=>'Receivables and payables software in Afghanistan for customer balances, supplier liabilities, aging, statements, settlements and approvals.','fa'=>'سیستم بدهکار و طلبکار افغانستان برای بیلانس مشتری، بدهی supplier، aging، statement، settlement و تأییدی.','ps'=>'په افغانستان کې receivable او payable سافټویر د مشتری بیلانس، supplier liability، aging، statement او settlement لپاره.'],
                ['en'=>'receivables payables software Afghanistan','fa'=>'سیستم بدهکار و طلبکار افغانستان','ps'=>'receivable payable سافټویر افغانستان'],
                ['accounting-software-afghanistan','financial-management-software-afghanistan','erp-systems-afghanistan']
            ),
            $this->article(
                $categoryId,
                'auto-parts-shop-software-afghanistan',
                ['en'=>'Auto Parts Shop Software in Afghanistan','fa'=>'نرم‌افزار فروشگاه پرزه‌جات موتر در افغانستان','ps'=>'په افغانستان کې د موټرو پرزو دوکان سافټویر'],
                ['en'=>'Manage part numbers, brands, compatibility, purchases, stock, sales, customer balances and supplier accounts for auto-parts shops.','fa'=>'مدیریت part number، brand، compatibility، خرید، موجودی، فروش، مشتری و supplier برای فروشگاه پرزه‌جات.','ps'=>'د part number، brand، compatibility، پېرود، stock، خرڅلاو، مشتری او supplier مدیریت د موټرو پرزو دوکان لپاره.'],
                [
                    'en'=>'<h2>Auto-parts inventory needs better product identification</h2><p>Parts may be searched by part number, brand, vehicle model, engine or compatible alternative. A shop system should make that lookup fast while keeping purchasing and stock accurate.</p><h2>Important features</h2><ul><li>Part number and alternate-code search</li><li>Brand, vehicle and compatibility notes</li><li>Purchasing and supplier balances</li><li>Stock by shop or warehouse</li><li>Retail and wholesale pricing</li><li>Customer credit and sales history</li><li>Barcode support where practical</li></ul>',
                    'fa'=>'<h2>موجودی پرزه‌جات به شناسایی بهتر محصول نیاز دارد</h2><p>پرزه با part number، brand، مدل موتر، engine یا بدیل compatible جستجو می‌شود. سیستم باید search سریع و stock دقیق داشته باشد.</p><h2>امکانات مهم</h2><ul><li>جستجوی part number و alternate code</li><li>brand، vehicle و compatibility</li><li>خرید و بیلانس supplier</li><li>stock دکان و گدام</li><li>قیمت retail و wholesale</li><li>قرض مشتری و sales history</li><li>بارکد در صورت نیاز</li></ul>',
                    'ps'=>'<h2>د موټرو پرزو stock ښه product identification غواړي</h2><p>پرزې د part number، brand، د موټر model، engine یا compatible بدیل له مخې لټول کېږي. سیسټم باید چټک search او دقیق stock ولري.</p><h2>مهم امکانات</h2><ul><li>part number او alternate code لټون</li><li>brand، vehicle او compatibility</li><li>پېرود او supplier بیلانس</li><li>د دوکان او ګدام stock</li><li>retail او wholesale بیې</li><li>د مشتری پور او sales history</li><li>د اړتیا په صورت کې بارکوډ</li></ul>'
                ],
                ['en'=>'Auto Parts Shop Software Afghanistan','fa'=>'نرم‌افزار پرزه‌جات موتر افغانستان','ps'=>'د موټرو پرزو سافټویر افغانستان'],
                ['en'=>'Auto parts shop software in Afghanistan for part search, compatibility, purchasing, inventory, sales, customer credit and suppliers.','fa'=>'نرم‌افزار پرزه‌جات موتر افغانستان برای part search، compatibility، خرید، گدام، فروش، قرض مشتری و supplier.','ps'=>'په افغانستان کې د موټرو پرزو دوکان سافټویر د part search، stock، پېرود، خرڅلاو او پور لپاره.'],
                ['en'=>'auto parts shop software Afghanistan','fa'=>'نرم افزار پرزه جات موتر افغانستان','ps'=>'د موټرو پرزو دوکان سافټویر افغانستان'],
                ['pos-software-afghanistan','wholesale-retail-software-afghanistan','procurement-inventory-management-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'agriculture-software-afghanistan-guide',
                ['en'=>'Agriculture & Agribusiness Software Guide for Afghanistan','fa'=>'راهنمای نرم‌افزار زراعت و تجارت زراعتی در افغانستان','ps'=>'په افغانستان کې د کرنې او زراعتي سوداګرۍ سافټویر لارښود'],
                ['en'=>'Plan agribusiness software around farms, seasons, inputs, purchases, harvest, warehouses, sales, finance and traceable records.','fa'=>'سیستم زراعت را براساس farm، season، input، خرید، harvest، گدام، فروش، مالی و ثبت قابل پیگیری پلان کنید.','ps'=>'زراعتي سافټویر د farm، season، input، پېرود، harvest، ګدام، خرڅلاو، مالي او traceable records له مخې پلان کړئ.'],
                [
                    'en'=>'<h2>Agriculture software should follow the chain from input to sale</h2><p>Depending on the business, records may begin with farms, growers, plots, seasons, seed or fertilizer and continue through harvest, procurement, storage, processing and sales.</p><h2>Common modules</h2><ul><li>Farm, producer and seasonal records</li><li>Inputs, purchasing and supplier accounts</li><li>Harvest and collection records</li><li>Warehouse, quality and batch information</li><li>Sales, customer balances and payments</li><li>Costs, finance and management reporting</li></ul>',
                    'fa'=>'<h2>نرم‌افزار زراعت باید زنجیره input تا sale را دنبال کند</h2><p>بسته به تجارت، ثبت از farm، producer، plot، season، seed یا fertilizer آغاز و به harvest، procurement، storage، processing و sale می‌رسد.</p><h2>ماژول‌های معمول</h2><ul><li>farm، producer و season</li><li>input، purchase و supplier account</li><li>harvest و collection</li><li>گدام، quality و batch</li><li>فروش، customer balance و payment</li><li>cost، finance و management report</li></ul>',
                    'ps'=>'<h2>د کرنې سافټویر باید له input څخه تر sale پورې زنځیر تعقیب کړي</h2><p>د کاروبار له ډول سره سم ثبت له farm، producer، plot، season، seed یا fertilizer څخه پیلېږي او harvest، procurement، storage، processing او sale ته رسېږي.</p><h2>عام ماډیولونه</h2><ul><li>farm، producer او season records</li><li>input، purchase او supplier account</li><li>harvest او collection</li><li>ګدام، quality او batch</li><li>خرڅلاو، customer balance او payment</li><li>cost، finance او management report</li></ul>'
                ],
                ['en'=>'Agriculture Software Afghanistan | Buyer Guide','fa'=>'نرم‌افزار زراعت افغانستان | راهنما','ps'=>'د کرنې سافټویر افغانستان | لارښود'],
                ['en'=>'Agriculture and agribusiness software guide for Afghanistan covering farms, seasons, inputs, harvest, warehouse, sales and finance.','fa'=>'راهنمای نرم‌افزار زراعت افغانستان؛ farm، season، input، harvest، گدام، فروش و مالی.','ps'=>'د افغانستان د کرنې سافټویر لارښود؛ farm، season، input، harvest، ګدام، خرڅلاو او مالي.'],
                ['en'=>'how to choose agribusiness software Afghanistan','fa'=>'راهنمای انتخاب نرم افزار زراعت افغانستان','ps'=>'په افغانستان کې د کرنې سافټویر د انتخاب لارښود'],
                ['agriculture-agribusiness-software-afghanistan','procurement-inventory-management-software-afghanistan','accounting-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'document-approval-workflow-afghanistan-guide',
                ['en'=>'Document & Approval Workflow Software in Afghanistan','fa'=>'سیستم اسناد و روند تأییدی در افغانستان','ps'=>'په افغانستان کې د اسنادو او تایید کاري بهیر سافټویر'],
                ['en'=>'Control document versions, routing, approvals, comments, deadlines, access and audit history instead of relying on email and paper.','fa'=>'کنترول نسخه سند، routing، approval، comment، deadline، access و audit history به‌جای ایمیل و کاغذ.','ps'=>'د document version، routing، approval، comment، deadline، access او audit history کنټرول د ایمیل او کاغذ پر ځای.'],
                [
                    'en'=>'<h2>Approval workflow is more than file storage</h2><p>A document system should preserve the current approved version, who reviewed it, who approved or rejected it and what changed between versions.</p><h2>Useful capabilities</h2><ul><li>Document numbering and categories</li><li>Version history and controlled replacement</li><li>Multi-step approval routing</li><li>Comments, due dates and reminders</li><li>Role-based access and secure attachments</li><li>Search, archive and audit history</li></ul>',
                    'fa'=>'<h2>روند تأییدی بیشتر از ذخیره فایل است</h2><p>سیستم سند باید نسخه approved، reviewer، approver/rejector و تغییرات میان نسخه‌ها را حفظ کند.</p><h2>امکانات مهم</h2><ul><li>document number و category</li><li>version history و replacement کنترول‌شده</li><li>approval چندمرحله‌ای</li><li>comment، due date و reminder</li><li>role-based access و attachment امن</li><li>search، archive و audit history</li></ul>',
                    'ps'=>'<h2>Approval workflow یوازې د فایل ساتنه نه ده</h2><p>د اسنادو سیسټم باید approved version، reviewer، approver/rejector او د نسخو ترمنځ بدلونونه وساتي.</p><h2>مهم امکانات</h2><ul><li>document number او category</li><li>version history او کنټرول شوی replacement</li><li>څو پړاوه approval</li><li>comment، due date او reminder</li><li>role-based access او خوندي attachment</li><li>search، archive او audit history</li></ul>'
                ],
                ['en'=>'Document Approval Workflow Afghanistan','fa'=>'سیستم اسناد و تأییدی افغانستان','ps'=>'د اسنادو او تایید سیستم افغانستان'],
                ['en'=>'Document and approval workflow software in Afghanistan for versions, routing, approvals, access, reminders, search and audit history.','fa'=>'سیستم اسناد و تأییدی افغانستان برای version، routing، approval، access، reminder، search و audit history.','ps'=>'په افغانستان کې د اسنادو او تایید workflow د version، routing، approval، access، reminder او audit لپاره.'],
                ['en'=>'document approval workflow Afghanistan','fa'=>'سیستم اسناد و تأییدی افغانستان','ps'=>'د اسنادو او تایید workflow افغانستان'],
                ['document-management-workflow-system-afghanistan','business-process-analysis-afghanistan','software-company-afghanistan']
            ),
            $this->article(
                $categoryId,
                'ngo-project-management-software-afghanistan',
                ['en'=>'NGO Project Management Software in Afghanistan','fa'=>'نرم‌افزار مدیریت پروژه NGO در افغانستان','ps'=>'په افغانستان کې د NGO د پروژې مدیریت سافټویر'],
                ['en'=>'Connect projects, activities, budgets, locations, staff, documents, approvals, indicators and donor reporting in one governed workflow.','fa'=>'اتصال پروژه، فعالیت، بودجه، موقعیت، staff، document، approval، indicator و donor reporting در یک روند.','ps'=>'پروژې، فعالیتونه، بودجه، موقعیت، staff، document، approval، indicator او donor reporting په یوه بهیر کې ونښلوئ.'],
                [
                    'en'=>'<h2>NGO project software should connect plans to evidence</h2><p>Projects normally move from approved objectives and budgets into activities, locations, assignments, procurement, field evidence and reporting.</p><h2>Useful workflows</h2><ul><li>Project, activity and workplan structure</li><li>Locations, teams and assignments</li><li>Budgets and cost tracking</li><li>Documents, approvals and deliverables</li><li>Indicators and reporting inputs</li><li>Donor or management reporting with controlled definitions</li></ul>',
                    'fa'=>'<h2>سیستم پروژه NGO باید پلان را به evidence وصل کند</h2><p>پروژه از objective و budget approved به activity، location، assignment، procurement، field evidence و reporting می‌رود.</p><h2>روندهای مهم</h2><ul><li>project، activity و workplan</li><li>location، team و assignment</li><li>budget و cost tracking</li><li>document، approval و deliverable</li><li>indicator و reporting input</li><li>donor/management reporting با definition کنترول‌شده</li></ul>',
                    'ps'=>'<h2>د NGO project software باید plan له evidence سره ونښلوي</h2><p>پروژه له approved objective او budget څخه activity، location، assignment، procurement، field evidence او reporting ته ځي.</p><h2>مهم بهیرونه</h2><ul><li>project، activity او workplan</li><li>location، team او assignment</li><li>budget او cost tracking</li><li>document، approval او deliverable</li><li>indicator او reporting input</li><li>donor/management reporting له کنټرول شوو تعریفونو سره</li></ul>'
                ],
                ['en'=>'NGO Project Management Software Afghanistan','fa'=>'سیستم مدیریت پروژه NGO افغانستان','ps'=>'د NGO project management افغانستان'],
                ['en'=>'NGO project management software in Afghanistan for workplans, budgets, teams, documents, indicators, approvals and donor reporting.','fa'=>'سیستم مدیریت پروژه NGO افغانستان برای workplan، budget، team، document، indicator، approval و donor report.','ps'=>'په افغانستان کې د NGO project management د workplan، budget، team، document، indicator او donor report لپاره.'],
                ['en'=>'NGO project management software Afghanistan','fa'=>'سیستم مدیریت پروژه NGO افغانستان','ps'=>'د NGO project management software افغانستان'],
                ['ngo-ingo-software-afghanistan','project-management-software-afghanistan','grant-management-system-afghanistan']
            ),
            $this->article(
                $categoryId,
                'asset-management-software-afghanistan-guide',
                ['en'=>'Asset Management Software Guide for Afghanistan','fa'=>'راهنمای نرم‌افزار مدیریت دارایی در افغانستان','ps'=>'په افغانستان کې د شتمنیو مدیریت سافټویر لارښود'],
                ['en'=>'Track assets, custodians, locations, transfers, maintenance, warranties, documents and disposal with an auditable lifecycle.','fa'=>'مدیریت asset، custodian، location، transfer، maintenance، warranty، document و disposal با lifecycle قابل audit.','ps'=>'asset، custodian، location، transfer، maintenance، warranty، document او disposal د audit وړ lifecycle سره تعقیب کړئ.'],
                [
                    'en'=>'<h2>Asset management follows the full lifecycle</h2><p>A useful register should begin with acquisition and acceptance, then track assignment, location, condition, maintenance, transfer and final disposal.</p><h2>Important controls</h2><ul><li>Unique asset IDs and categories</li><li>Custodian and location history</li><li>Transfer and handover records</li><li>Warranty and service dates</li><li>Maintenance work and parts</li><li>Disposal approvals and evidence</li></ul>',
                    'fa'=>'<h2>مدیریت دارایی کل lifecycle را دنبال می‌کند</h2><p>register از acquisition و acceptance آغاز و assignment، location، condition، maintenance، transfer و disposal را ثبت می‌کند.</p><h2>کنترول‌های مهم</h2><ul><li>asset ID و category</li><li>تاریخچه custodian و location</li><li>transfer و handover</li><li>warranty و service date</li><li>maintenance و parts</li><li>disposal approval و evidence</li></ul>',
                    'ps'=>'<h2>Asset management بشپړ lifecycle تعقیبوي</h2><p>register باید له acquisition او acceptance څخه پیل او assignment، location، condition، maintenance، transfer او disposal ثبت کړي.</p><h2>مهم کنټرولونه</h2><ul><li>asset ID او category</li><li>د custodian او location history</li><li>transfer او handover</li><li>warranty او service date</li><li>maintenance او parts</li><li>disposal approval او evidence</li></ul>'
                ],
                ['en'=>'Asset Management Software Afghanistan | Guide','fa'=>'نرم‌افزار مدیریت دارایی افغانستان | راهنما','ps'=>'د شتمنیو مدیریت سافټویر افغانستان | لارښود'],
                ['en'=>'Asset management software guide for Afghanistan covering IDs, custodians, locations, transfers, maintenance, warranties and disposal.','fa'=>'راهنمای مدیریت دارایی افغانستان؛ asset ID، custodian، location، transfer، maintenance، warranty و disposal.','ps'=>'د افغانستان د asset management لارښود؛ ID، custodian، location، transfer، maintenance، warranty او disposal.'],
                ['en'=>'asset lifecycle management software guide Afghanistan','fa'=>'راهنمای سیستم چرخه عمر دارایی افغانستان','ps'=>'په افغانستان کې د شتمنۍ د ژوند دورې سیسټم لارښود'],
                ['asset-maintenance-management-software-afghanistan','procurement-inventory-management-software-afghanistan','accounting-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'clinic-management-software-afghanistan',
                ['en'=>'Clinic Management Software in Afghanistan','fa'=>'نرم‌افزار مدیریت کلینیک در افغانستان','ps'=>'په افغانستان کې د کلینیک مدیریت سافټویر'],
                ['en'=>'Plan clinic software around registration, appointments, encounters, billing, pharmacy, laboratory, inventory and finance with controlled access.','fa'=>'سیستم کلینیک برای registration، appointment، encounter، billing، pharmacy، laboratory، inventory و finance با access کنترول‌شده.','ps'=>'د clinic software د registration، appointment، encounter، billing، pharmacy، laboratory، inventory او finance لپاره.'],
                [
                    'en'=>'<h2>Clinic software should support the patient journey without replacing clinical judgment</h2><p>A clinic may need registration, appointments, encounters, services, billing and follow-up, with laboratory or pharmacy modules where relevant.</p><h2>Common capabilities</h2><ul><li>Patient registration and identifiers</li><li>Appointments and queues</li><li>Controlled encounter documentation</li><li>Billing, receipts and outstanding balances</li><li>Pharmacy or laboratory integration where scoped</li><li>Inventory, finance and operational reports</li></ul><p>Clinical rules, terminology, retention and access must be approved by authorized healthcare professionals and the organization.</p>',
                    'fa'=>'<h2>سیستم کلینیک باید patient journey را پشتیبانی کند، نه این‌که جای judgment طبی را بگیرد</h2><p>کلینیک ممکن است registration، appointment، encounter، service، billing و follow-up نیاز داشته باشد و در صورت ضرورت laboratory یا pharmacy وصل شود.</p><h2>امکانات معمول</h2><ul><li>patient registration و identifier</li><li>appointment و queue</li><li>encounter documentation کنترول‌شده</li><li>billing، receipt و outstanding</li><li>pharmacy/laboratory integration</li><li>inventory، finance و operation report</li></ul>',
                    'ps'=>'<h2>Clinic software باید patient journey ملاتړ کړي، نه دا چې د طبي judgment ځای ونیسي</h2><p>کلینیک registration، appointment، encounter، service، billing او follow-up ته اړتیا لرلی شي او د اړتیا په صورت کې laboratory یا pharmacy ورسره وصلېږي.</p><h2>عام امکانات</h2><ul><li>patient registration او identifier</li><li>appointment او queue</li><li>کنټرول شوی encounter documentation</li><li>billing، receipt او outstanding</li><li>pharmacy/laboratory integration</li><li>inventory، finance او operational reports</li></ul>'
                ],
                ['en'=>'Clinic Management Software Afghanistan','fa'=>'نرم‌افزار کلینیک افغانستان','ps'=>'د کلینیک مدیریت سافټویر افغانستان'],
                ['en'=>'Clinic management software in Afghanistan for registration, appointments, encounters, billing, pharmacy, laboratory, inventory and finance.','fa'=>'نرم‌افزار مدیریت کلینیک افغانستان برای registration، appointment، encounter، billing، pharmacy، laboratory، inventory و finance.','ps'=>'په افغانستان کې د clinic management software د registration، appointment، encounter، billing، pharmacy او finance لپاره.'],
                ['en'=>'clinic management software Afghanistan','fa'=>'نرم افزار کلینیک افغانستان','ps'=>'د کلینیک مدیریت سافټویر افغانستان'],
                ['hospital-management-system-afghanistan','laboratory-information-system-afghanistan','pharmacy-pharmaceutical-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'school-fee-accounting-software-afghanistan',
                ['en'=>'School Fee & Accounting Software in Afghanistan','fa'=>'نرم‌افزار فیس و حسابداری مکتب در افغانستان','ps'=>'په افغانستان کې د ښوونځي فیس او حسابدارۍ سافټویر'],
                ['en'=>'Connect student fees, invoices, receipts, discounts, installments, outstanding balances and finance reporting with school records.','fa'=>'اتصال fee شاگرد، invoice، receipt، discount، installment، outstanding و finance reporting با student record.','ps'=>'د زده‌کوونکي fee، invoice، receipt، discount، installment، outstanding او مالي راپور له student record سره ونښلوئ.'],
                [
                    'en'=>'<h2>School fee software should connect finance to the student record</h2><p>Charges, discounts, installments, receipts and balances should be linked to the correct learner and academic period without allowing silent changes after payment.</p><h2>Useful controls</h2><ul><li>Fee structures by grade or programme</li><li>Invoices, receipts and refunds</li><li>Discounts and scholarships with approval</li><li>Installment schedules and outstanding balances</li><li>Student statements</li><li>Finance reconciliation and reporting</li></ul>',
                    'fa'=>'<h2>سیستم فیس مکتب باید مالی را به student record وصل کند</h2><p>charge، discount، installment، receipt و balance باید به شاگرد و academic period درست وصل باشد و بعد از پرداخت تغییر خاموش نداشته باشد.</p><h2>کنترول‌های مهم</h2><ul><li>fee structure بر اساس grade/programme</li><li>invoice، receipt و refund</li><li>discount و scholarship با approval</li><li>installment و outstanding</li><li>student statement</li><li>finance reconciliation و reporting</li></ul>',
                    'ps'=>'<h2>د ښوونځي fee software باید مالي له student record سره ونښلوي</h2><p>charge، discount، installment، receipt او balance باید د سم زده‌کوونکي او academic period سره تړلي وي او تر payment وروسته خاموش بدلون ونه کړي.</p><h2>مهم کنټرولونه</h2><ul><li>fee structure د grade/programme له مخې</li><li>invoice، receipt او refund</li><li>discount او scholarship له approval سره</li><li>installment او outstanding</li><li>student statement</li><li>finance reconciliation او reporting</li></ul>'
                ],
                ['en'=>'School Fee Accounting Software Afghanistan','fa'=>'سیستم فیس و حسابداری مکتب افغانستان','ps'=>'د ښوونځي فیس او حسابداري افغانستان'],
                ['en'=>'School fee and accounting software in Afghanistan for invoices, receipts, discounts, installments, student balances and finance reports.','fa'=>'سیستم فیس و حسابداری مکتب افغانستان برای invoice، receipt، discount، installment، balance و finance report.','ps'=>'په افغانستان کې د ښوونځي fee او accounting software د invoice، receipt، discount، installment او balance لپاره.'],
                ['en'=>'school fee accounting software Afghanistan','fa'=>'سیستم فیس مکتب افغانستان','ps'=>'د ښوونځي فیس سافټویر افغانستان'],
                ['school-management-erp-afghanistan','accounting-software-afghanistan','financial-management-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'construction-finance-software-afghanistan',
                ['en'=>'Construction Finance Software in Afghanistan','fa'=>'نرم‌افزار مالی پروژه‌های ساختمانی در افغانستان','ps'=>'په افغانستان کې د ساختماني پروژو مالي سافټویر'],
                ['en'=>'Track project budgets, supplier and subcontractor balances, advances, materials, payments, cash, bank and project profitability.','fa'=>'مدیریت budget پروژه، supplier/subcontractor balance، advance، material، payment، cash، bank و profitability پروژه.','ps'=>'د پروژې budget، supplier/subcontractor balance، advance، material، payment، cash، bank او profitability تعقیب کړئ.'],
                [
                    'en'=>'<h2>Construction finance must stay connected to the project</h2><p>Project expenses should identify the project, cost category, supplier or subcontractor, supporting document and approval path rather than appearing only as a general accounting entry.</p><h2>Important capabilities</h2><ul><li>Project and cost-code budgets</li><li>Supplier and subcontractor balances</li><li>Advances and settlements</li><li>Material purchases and project issues</li><li>Payment approvals</li><li>Cash, bank and project profitability reports</li></ul>',
                    'fa'=>'<h2>مالی ساختمان باید به پروژه وصل بماند</h2><p>مصرف باید project، cost category، supplier/subcontractor، supporting document و approval path را مشخص کند، نه این‌که فقط یک entry عمومی باشد.</p><h2>امکانات مهم</h2><ul><li>project و cost-code budget</li><li>supplier/subcontractor balance</li><li>advance و settlement</li><li>material purchase و project issue</li><li>payment approval</li><li>cash، bank و profitability report</li></ul>',
                    'ps'=>'<h2>د construction finance باید له پروژې سره تړلی پاتې شي</h2><p>مصرف باید project، cost category، supplier/subcontractor، supporting document او approval path وښيي، نه یوازې عمومي accounting entry.</p><h2>مهم امکانات</h2><ul><li>project او cost-code budget</li><li>supplier/subcontractor balance</li><li>advance او settlement</li><li>material purchase او project issue</li><li>payment approval</li><li>cash، bank او profitability report</li></ul>'
                ],
                ['en'=>'Construction Finance Software Afghanistan','fa'=>'سیستم مالی ساختمان افغانستان','ps'=>'د ساختماني پروژو مالي سافټویر افغانستان'],
                ['en'=>'Construction finance software in Afghanistan for project budgets, suppliers, subcontractors, advances, materials, payments and profitability.','fa'=>'سیستم مالی ساختمان افغانستان برای project budget، supplier، subcontractor، advance، material، payment و profitability.','ps'=>'په افغانستان کې construction finance software د project budget، supplier، subcontractor، advance، material او payment لپاره.'],
                ['en'=>'construction finance software Afghanistan','fa'=>'سیستم مالی ساختمان افغانستان','ps'=>'د ساختماني پروژو مالي سافټویر افغانستان'],
                ['construction-erp-software-afghanistan','accounting-software-afghanistan','financial-management-software-afghanistan']
            ),
            $this->article(
                $categoryId,
                'property-rental-management-software-afghanistan',
                ['en'=>'Property & Rental Management Software in Afghanistan','fa'=>'نرم‌افزار مدیریت ملکیت و کرایه در افغانستان','ps'=>'په افغانستان کې د ملکیت او کرایې مدیریت سافټویر'],
                ['en'=>'Manage properties, units, tenants, leases, rent schedules, collections, deposits, maintenance and owner reporting.','fa'=>'مدیریت property، unit، tenant، lease، rent schedule، collection، deposit، maintenance و owner reporting.','ps'=>'property، unit، tenant، lease، rent schedule، collection، deposit، maintenance او owner reporting مدیریت کړئ.'],
                [
                    'en'=>'<h2>Rental management is different from property sales</h2><p>Rental operations need tenants, leases, recurring charges, deposits, collections, maintenance requests and vacancy status over time.</p><h2>Useful capabilities</h2><ul><li>Property, building and unit hierarchy</li><li>Tenant and lease records</li><li>Rent schedules and recurring invoices</li><li>Deposits, receipts and outstanding balances</li><li>Maintenance requests and service history</li><li>Vacancy, occupancy and owner reports</li></ul>',
                    'fa'=>'<h2>مدیریت کرایه با فروش ملکیت فرق دارد</h2><p>عملیات rental به tenant، lease، charge تکراری، deposit، collection، maintenance request و vacancy status نیاز دارد.</p><h2>امکانات مهم</h2><ul><li>property، building و unit hierarchy</li><li>tenant و lease record</li><li>rent schedule و recurring invoice</li><li>deposit، receipt و outstanding</li><li>maintenance request و service history</li><li>vacancy، occupancy و owner report</li></ul>',
                    'ps'=>'<h2>Rental management د property sale څخه توپیر لري</h2><p>Rental operation د tenant، lease، recurring charge، deposit، collection، maintenance request او vacancy status ته اړتیا لري.</p><h2>مهم امکانات</h2><ul><li>property، building او unit hierarchy</li><li>tenant او lease record</li><li>rent schedule او recurring invoice</li><li>deposit، receipt او outstanding</li><li>maintenance request او service history</li><li>vacancy، occupancy او owner report</li></ul>'
                ],
                ['en'=>'Property Rental Management Software Afghanistan','fa'=>'سیستم مدیریت کرایه و ملکیت افغانستان','ps'=>'د ملکیت او کرایې مدیریت افغانستان'],
                ['en'=>'Property and rental management software in Afghanistan for units, tenants, leases, rent, deposits, collections, maintenance and owner reports.','fa'=>'سیستم مدیریت ملکیت و کرایه افغانستان برای unit، tenant، lease، rent، deposit، collection، maintenance و owner report.','ps'=>'په افغانستان کې property rental software د unit، tenant، lease، rent، deposit، collection او maintenance لپاره.'],
                ['en'=>'property rental management software Afghanistan','fa'=>'سیستم مدیریت کرایه افغانستان','ps'=>'د کرایې مدیریت سافټویر افغانستان'],
                ['real-estate-erp-software-afghanistan','realist-real-estate-erp','accounting-software-afghanistan']
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
            'sort_order'=>1200,
            'published_at'=>now(),
        ];
    }
}
