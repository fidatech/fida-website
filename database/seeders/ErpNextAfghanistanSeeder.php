<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class ErpNextAfghanistanSeeder extends Seeder
{
    public function run(): void
    {
        ContentPage::query()->updateOrCreate(
            ['slug' => 'erpnext-afghanistan'],
            [
                'type' => 'solution',
                'title' => ['en' => 'ERPNext Implementation, Hosting & Training in Afghanistan', 'fa' => 'نصب، میزبانی و آموزش ERPNext در افغانستان', 'ps' => 'په افغانستان کې د ERPNext نصب، کوربه‌توب او روزنه'],
                'eyebrow' => ['en' => 'Fida Technologies · Independent ERPNext implementation services'],
                'summary' => ['en' => 'Deploy ERPNext for accounting, sales, purchasing, inventory, manufacturing and projects with local configuration, employee training and ongoing support. See transparent implementation pricing below.', 'fa' => 'خدمات نصب و تنظیم ERPNext برای حسابداری، فروش، خریداری، گدام، تولید و پروژه‌ها همراه با آموزش و پشتیبانی در افغانستان. قیمت‌ها را در همین صفحه ببینید.', 'ps' => 'په افغانستان کې د حسابدارۍ، پلور، پېرود، ګودام، تولید او پروژو لپاره د ERPNext نصب، تنظیم، روزنه او ملاتړ. بیې په همدې پاڼه کې وګورئ.'],
                'body' => ['en' => <<<'HTML'
<section class="erp-intro">
<h2>ERPNext services for Afghan businesses</h2>
<p>ERPNext is an open-source enterprise resource planning system developed by Frappe. Fida Technologies independently provides discovery, deployment, company setup, workflow configuration, staff training, migration planning, hosting and technical support in Afghanistan. Fida is not claiming official partnership with Frappe.</p>
<p><strong>Ideal use cases:</strong> manufacturing, construction, trading, wholesale and distribution, and organizations seeking connected finance and operations.</p>
</section>
<section id="erpnext-features">
<h2>What can ERPNext manage?</h2>
<div class="erp-cards">
<div><h3>Accounting and finance</h3><p>Accounts, receivables, payables, invoices, payments and financial reporting.</p></div>
<div><h3>Sales and CRM</h3><p>Leads, quotations, customers, orders and invoicing.</p></div>
<div><h3>Stock and purchasing</h3><p>Suppliers, purchase orders, stock transfers and warehouse controls.</p></div>
<div><h3>Manufacturing</h3><p>Bills of materials, work orders and production tracking.</p></div>
<div><h3>Projects</h3><p>Tasks, project costs, procurement and progress tracking.</p></div>
<div><h3>HR and payroll</h3><p>Employee records and applicable HR workflows. Country-specific payroll and tax rules require validation.</p></div>
</div>
</section>
<section id="erpnext-pricing">
<h2>ERPNext implementation prices in Afghanistan</h2>
<p>Fida publishes indicative service prices upfront. ERPNext's open-source software is separate from the professional services and infrastructure shown below. Final quotations depend on agreed workflows, data quality, integration, location and user training.</p>
<div class="erp-prices">
<div class="erp-price"><span>STARTER</span><h3>$600</h3><p>One-time implementation</p><strong>$220 / year</strong><p>Hosting and maintenance</p><ul><li>Basic company and user setup</li><li>Core accounting, purchasing and sales workflows</li><li>Up to 6 hours of standard training</li><li>Basic handover</li></ul><a href="/contact?interest=erpnext-afghanistan&plan=starter#contact">Request Starter quotation ↗</a></div>
<div class="erp-price featured"><span>BUSINESS · POPULAR</span><h3>$1,200</h3><p>One-time implementation</p><strong>$360 / year</strong><p>Hosting and maintenance</p><ul><li>Expanded purchasing and inventory setup</li><li>Multiple roles and warehouses as scoped</li><li>Up to 12 hours of staff training</li><li>Workflows and acceptance testing</li></ul><a href="/contact?interest=erpnext-afghanistan&plan=business#contact">Request Business quotation ↗</a></div>
<div class="erp-price"><span>ENTERPRISE</span><h3>$2,500</h3><p>One-time implementation</p><strong>$700 / year</strong><p>Hosting and maintenance</p><ul><li>Manufacturing or construction processes</li><li>Complex approvals and permissions</li><li>Training plan agreed in proposal</li><li>Advanced integrations separately scoped</li></ul><a href="/request-for-quotation">Request enterprise RFQ ↗</a></div>
</div>
<p><small>All prices are in US dollars and are indicative Fida service fees. Data migration, custom development, third-party subscriptions, travel and additional training are charged separately where needed. Hosting capacity, backup retention, response times and renewal terms are set out in the written quotation. Prices are subject to confirmation.</small></p>
</section>
<section id="erpnext-process"><h2>Our implementation process</h2><ol><li><strong>Discovery:</strong> assess departments, workflows and records.</li><li><strong>Configuration:</strong> company, chart of accounts, roles, warehouses and modules.</li><li><strong>Training:</strong> guided sessions using realistic sample transactions.</li><li><strong>Acceptance:</strong> test purchases, sales, inventory and financial reports with nominated staff.</li><li><strong>Go-live:</strong> controlled data migration, backup verification and support handover.</li></ol></section>
<section><h2>Local setup and training matter</h2><p>We assess AFN and foreign-currency operations, required document formats, reporting practices and the preferred training language. Dari and Pashto translation or document customization is quoted against an agreed scope; availability of a fully translated interface should not be assumed.</p><p>ERPNext is open source. You pay Fida for implementation, training, managed hosting and agreed maintenance, not for ownership of the ERPNext product.</p><p><a href="/erp-systems-afghanistan">Compare other ERP solutions in Afghanistan</a> or <a href="/contact?interest=erpnext-afghanistan#contact">book an ERPNext consultation</a>.</p></section>
<style>
.erp-cards,.erp-prices{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin:24px 0 32px}.erp-cards>div,.erp-price{padding:24px;border:1px solid rgba(180,210,230,.24);border-radius:20px;background:rgba(120,140,160,.07)}.erp-price.featured{border-color:#bcf251;background:rgba(188,242,81,.07)}.erp-price>span{display:block;font-size:.7rem;letter-spacing:.13em;font-weight:800}.erp-price h3{font-size:clamp(1.55rem,2.7vw,2.3rem);margin:14px 0 2px}.erp-price strong{display:block;margin-top:16px}.erp-price a{display:block;text-align:center;background:#c9ff4a;color:#102017!important;border-radius:12px;padding:12px 9px;text-decoration:none!important;font-weight:700;margin-top:22px}.erp-price ul{padding-left:19px}.erp-price li{margin:10px 0}.erp-cards h3{font-size:1.05rem}@media(max-width:850px){.erp-prices{grid-template-columns:1fr}.erp-cards{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:540px){.erp-cards{grid-template-columns:1fr}.erp-price{padding:20px}}
</style>
HTML,
                    'fa' => '<h2>خدمات ERPNext در افغانستان</h2><p>فدا تکنالوژی خدمات مستقل نصب، تنظیم، آموزش کارمندان، میزبانی و پشتیبانی ERPNext را برای شرکت‌های افغانستان ارائه می‌کند. ERPNext یک سیستم متن‌باز برای مدیریت مالی، فروش، خریداری، گدام، تولید و پروژه‌ها است. فدا ادعای نمایندگی رسمی Frappe را ندارد.</p><h2>قیمت نصب و آموزش ERPNext</h2><p>قیمت‌های زیر تخمینی اند و پس از بررسی نیازهای شرکت نهایی می‌شوند. هزینه یک‌بار تطبیق از هزینه سالانه میزبانی و حفظ و مراقبت جدا است.</p><div class="erp-prices"><div class="erp-price"><h3>Starter — $600</h3><p>هزینه یک‌بار تطبیق؛ میزبانی و حفظ و مراقبت سالانه $220. شامل تنظیم ابتدایی شرکت و کاربران، جریان‌های کاری اساسی و تا ۶ ساعت آموزش.</p></div><div class="erp-price"><h3>Business — $1,200</h3><p>هزینه یک‌بار تطبیق؛ میزبانی و حفظ و مراقبت سالانه $360. شامل تنظیم گسترده خریداری و گدام‌ها، نقش‌های کاربران و تا ۱۲ ساعت آموزش.</p></div><div class="erp-price"><h3>Enterprise — $2,500</h3><p>هزینه یک‌بار تطبیق؛ میزبانی و حفظ و مراقبت سالانه $700. برای شرکت‌های تولیدی، ساختمانی و جریان‌های کاری پیچیده؛ آموزش طبق قرارداد تعیین می‌شود.</p></div></div><h2>ماژول‌ها و مراحل تطبیق</h2><p>حسابداری و مالی، فروش و CRM، خریداری و گدام، تولید، پروژه‌ها و منابع بشری از بخش‌های قابل بررسی اند. مراحل کار شامل شناخت نیازها، تنظیم سیستم، آموزش عملی، آزمایش و آغاز استفاده است. محاسبات مالیاتی، چاپ اسناد و نیازهای محلی باید جداگانه بررسی شوند.</p><p>انتقال اطلاعات، توسعه اختصاصی، رفت‌وآمد و آموزش اضافی در صورت نیاز جداگانه قیمت‌گذاری می‌شود. <a href="/fa/contact?interest=erpnext-afghanistan#contact">درخواست مشوره و قیمت</a> یا <a href="/fa/erp-systems-afghanistan">مشاهده سایر راهکارهای ERP</a>.</p>',
                    'ps' => '<h2>په افغانستان کې د ERPNext خدمتونه</h2><p>فدا ټکنالوژي په افغانستان کې د ERPNext د نصب، تنظیم، کارکوونکو د روزنې، کوربه‌توب او تخنیکي ملاتړ خپلواک خدمتونه وړاندې کوي. ERPNext د حسابدارۍ، پلور، پېرود، ګودام، تولید او پروژو د مدیریت لپاره د پرانیستې سرچینې سیسټم دی. فدا د Frappe رسمي استازیتوب نه ادعا کوي.</p><h2>د ERPNext د نصب او روزنې بیې</h2><p>دا اټکلي بیې دي او وروستۍ بیه د شرکت د اړتیاوو تر ارزونې وروسته ټاکل کېږي. د لومړني پلي کولو فیس له کلني کوربه‌توب او ساتنې جلا دی.</p><div class="erp-prices"><div class="erp-price"><h3>Starter — $600</h3><p>د لومړني پلي کولو فیس؛ کلنی کوربه‌توب او ساتنه $220. د شرکت او کاروونکو لومړنی تنظیم، بنسټیزې چارې او تر ۶ ساعتونو روزنه.</p></div><div class="erp-price"><h3>Business — $1,200</h3><p>د لومړني پلي کولو فیس؛ کلنی کوربه‌توب او ساتنه $360. د پېرود او ګودام پراخ تنظیم، د کاروونکو رولونه او تر ۱۲ ساعتونو روزنه.</p></div><div class="erp-price"><h3>Enterprise — $2,500</h3><p>د لومړني پلي کولو فیس؛ کلنی کوربه‌توب او ساتنه $700. د تولیدي او ساختماني شرکتونو او پېچلو کاري بهیرونو لپاره؛ د روزنې اندازه په قرارداد کې ټاکل کېږي.</p></div></div><h2>برخې او د پلي کولو پړاوونه</h2><p>حسابداري او مالي چارې، پلور او CRM، پېرود او ګودام، تولید، پروژې او بشري سرچینې د ارزونې وړ برخې دي. د پلي کولو پړاوونه د اړتیاوو ارزونه، تنظیم، عملي روزنه، ازموینه او د کار پیل دي. د مالیاتو محاسبه، چاپي اسناد او سیمه‌ییزې اړتیاوې جلا ارزونې ته اړتیا لري.</p><p>د معلوماتو لېږد، ځانګړې پراختیا، سفر او اضافي روزنه د اړتیا پر مهال په جلا بیه محاسبه کېږي. <a href="/ps/contact?interest=erpnext-afghanistan#contact">مشوره او بیه وغواړئ</a> یا <a href="/ps/erp-systems-afghanistan">نور ERP حللارې وګورئ</a>.</p>',
                ],
                'meta_title' => ['en' => 'ERPNext Afghanistan | Pricing, Setup, Training & Hosting | Fida', 'fa' => 'ERPNext در افغانستان | قیمت، نصب و آموزش | فدا', 'ps' => 'ERPNext افغانستان | بیې، نصب او روزنه | فدا'],
                'meta_description' => ['en' => 'ERPNext implementation in Afghanistan by Fida Technologies. Transparent setup pricing from $600, managed hosting, employee training, accounting, inventory and manufacturing.', 'fa' => 'نصب و تطبیق ERPNext در افغانستان توسط فدا تکنالوژی. قیمت از ۶۰۰ دالر، میزبانی، آموزش، حسابداری، گدام و تولید.', 'ps' => 'په افغانستان کې د فدا ټکنالوژۍ له خوا د ERPNext نصب او پلي کول. بیې له ۶۰۰ ډالرو، کوربه‌توب، روزنه، حسابداري او ګودام.'],
                'primary_query' => ['en' => 'ERPNext Afghanistan', 'fa' => 'ERPNext افغانستان قیمت و نصب', 'ps' => 'ERPNext افغانستان بیه او نصب'],
                'search_intent' => 'commercial',
                'robots_directive' => 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
                'metadata' => [
                    'related_slugs' => ['erp-systems-afghanistan', 'manufacturing-erp-software-afghanistan'],
                    'faqs' => [
                        ['question' => ['en' => 'How much does ERPNext implementation cost in Afghanistan?'], 'answer' => ['en' => 'Fida advertises starting implementation fees of $600 for Starter, $1,200 for Business and $2,500 for Enterprise, each for an agreed baseline scope. Annual hosting and maintenance start at $220, $360 and $700 respectively. Additional requirements are quoted separately.']],
                        ['question' => ['en' => 'Is ERPNext free software?'], 'answer' => ['en' => 'ERPNext is open-source software. Fida charges separately for managed hosting, configuration, data work, training, customizations and support.']],
                        ['question' => ['en' => 'Does the price include ERPNext training?'], 'answer' => ['en' => 'Starter includes up to six hours of standard workflow training and Business up to twelve hours. Enterprise training and additional sessions are specified in the quotation.']],
                        ['question' => ['en' => 'Can ERPNext support manufacturing or construction businesses?'], 'answer' => ['en' => 'ERPNext includes manufacturing, project, inventory and accounting functionality. Fida assesses the actual processes, required integrations and reporting before confirming fit or scope.']],
                        ['question' => ['en' => 'Is Fida an official Frappe partner?'], 'answer' => ['en' => 'Fida offers independent ERPNext implementation services and does not claim official Frappe partnership.']],
                    ],
                ],
                'status' => 'published',
                'featured' => true,
                'sort_order' => 2,
                'sitemap_included' => true,
                'sitemap_priority' => 0.9,
                'sitemap_change_frequency' => 'monthly',
                'published_at' => now(),
            ]
        );
    }
}
