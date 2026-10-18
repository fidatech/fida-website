@extends('layouts.marketing')
@php
$locale = app()->getLocale();
$rtl = in_array($locale, ['fa','ps'], true);
$copy = [
'en' => ['eyebrow'=>'ERPNext services in Afghanistan','hero'=>'ERPNext for a more connected business.','intro'=>'Accounting, stock, sales and operations in one place. Implemented, hosted and supported in Afghanistan by Fida Technologies, with practical training for your team.','consult'=>'Book a consultation','prices'=>'Clear packages. Confident decisions.','pricesIntro'=>'One published starting price for each implementation package. We confirm the exact deliverables before work begins.','setup'=>'One-time implementation','year'=>'Annual hosting & maintenance from','popular'=>'MOST POPULAR','starter'=>'For small businesses taking the first step toward organized operations.','business'=>'For growing trading and distribution companies that need coordinated teams and stock.','enterprise'=>'For manufacturing, construction and multi-department implementations.','scope'=>'Prices are starting fees for the specified baseline scope, not a guarantee for every company. Data migration, custom development, travel, additional training, integrations and tax localization are quoted separately. Annual fees depend on capacity and support requirements.','modules'=>'Everything your team needs, working together','gallery'=>'Explore real ERPNext screens','gallerynote'=>'Screens shown are official ERPNext product examples from Frappe. Sample data is not from a Fida customer.','training'=>'We train your people, not only install your software.','trainingtext'=>'We walk your staff through real purchase, sales, stock and accounting workflows, test access permissions and plan the go-live with you.','independent'=>'Fida provides independent implementation services and is not presented as an official Frappe partner.','faq'=>'Questions before you get started','contact'=>'Get my quotation','feature'=>'FEATURED'],
'fa'=>['eyebrow'=>'خدمات ERPNext در افغانستان','hero'=>'ERPNext؛ مدیریت همه بخش‌های شرکت در یک سیستم','intro'=>'حسابداری، گدام، فروش، خریداری و عملیات را در یک سیستم مدیریت کنید. فیدا نصب، تنظیم، آموزش و میزبانی ERPNext را در افغانستان فراهم می‌کند.','consult'=>'درخواست مشوره','prices'=>'بسته‌های روشن و قیمت مشخص','pricesIntro'=>'برای هر بسته یک قیمت ابتدایی مشخص داریم. محدوده کار پیش از آغاز توافق می‌شود.','setup'=>'هزینه یک‌بار تطبیق','year'=>'میزبانی و پشتیبانی سالانه از','popular'=>'پیشنهاد ویژه','starter'=>'برای کسب‌وکارهای کوچک و تنظیم جریان‌های کاری اساسی.','business'=>'برای شرکت‌های تجارتی و توزیعی که نیاز به مدیریت هماهنگ دارند.','enterprise'=>'برای شرکت‌های تولیدی، ساختمانی و چندبخشی.','scope'=>'قیمت‌ها از مبلغ نشان داده شده آغاز می‌شوند و به محدوده مشخص خدمات وابسته اند. انتقال اطلاعات، توسعه اختصاصی، سفر، آموزش اضافی و یکپارچه‌سازی جداگانه محاسبه می‌شود.','modules'=>'بخش‌های مختلف در یک سیستم','gallery'=>'تصاویر واقعی سیستم ERPNext','gallerynote'=>'این تصاویر نمونه‌های رسمی ERPNext از Frappe اند و اطلاعات مشتریان فیدا نیستند.','training'=>'فقط نصب نمی‌کنیم؛ کارمندان شما را آموزش می‌دهیم.','trainingtext'=>'برای کارمندان شما خریداری، فروش، گدام و حسابداری را با مثال‌های عملی آموزش می‌دهیم.','independent'=>'فیدا خدمات مستقل ERPNext ارائه می‌کند و ادعای نمایندگی رسمی Frappe را ندارد.','faq'=>'پرسش‌های متداول','contact'=>'درخواست قیمت','feature'=>'پیشنهادی'],
'ps'=>['eyebrow'=>'په افغانستان کې د ERPNext خدمتونه','hero'=>'ERPNext؛ د شرکت ټولې چارې په یوه سیسټم کې','intro'=>'حسابداري، ګودام، پلور، پېرود او نورې چارې په یوه سیسټم کې اداره کړئ. فیدا د ERPNext نصب، تنظیم، روزنه او کوربه‌توب وړاندې کوي.','consult'=>'مشوره وغواړئ','prices'=>'روښانه بستې او څرګندې بیې','pricesIntro'=>'د هرې بستې لپاره یوه لومړنۍ بیه ټاکل شوې ده. د کار حدود تر پیل مخکې تاییدېږي.','setup'=>'د لومړني پلي کولو فیس','year'=>'کلنی کوربه‌توب او ملاتړ له','popular'=>'غوره انتخاب','starter'=>'د کوچنیو شرکتونو او لومړنیو کاري بهیرونو لپاره.','business'=>'د سوداګریزو او وېشونکو شرکتونو لپاره چې ګډ مدیریت ته اړتیا لري.','enterprise'=>'د تولیدي، ساختماني او څو څانګو شرکتونو لپاره.','scope'=>'ښودل شوې بیې د ټاکل شوو خدمتونو لومړنۍ بیې دي. د معلوماتو لېږد، ځانګړې پراختیا، سفر، اضافي روزنه او ادغام په جلا توګه محاسبه کېږي.','modules'=>'ستاسو ټولې څانګې په یوه سیسټم کې','gallery'=>'د ERPNext اصلي انځورونه','gallerynote'=>'دا د Frappe رسمي ERPNext بېلګې دي او د فیدا د پېرودونکو معلومات نه دي.','training'=>'موږ یوازې سیسټم نه نصبوو؛ ستاسو کارکوونکي هم روزو.','trainingtext'=>'ستاسو کارکوونکو ته د پېرود، پلور، ګودام او حسابدارۍ عملي روزنه ورکوو.','independent'=>'فیدا د ERPNext خپلواک خدمتونه وړاندې کوي او د Frappe د رسمي استازیتوب ادعا نه کوي.','faq'=>'عامې پوښتنې','contact'=>'د بیې غوښتنه','feature'=>'وړاندیز شوی']
][$locale] ?? null;
$copy ??= [];
$plans = [
 ['name'=>'Starter','price'=>'$600','annual'=>'$220','desc'=>$copy['starter'],'features'=>['Company & core user configuration','Accounting, purchasing and sales baseline','Up to 6 hours of workflow training','Go-live checklist'],'slug'=>'starter'],
 ['name'=>'Business','price'=>'$1,200','annual'=>'$360','desc'=>$copy['business'],'features'=>['Starter capabilities plus warehouse workflows','Stock, buying, selling and approvals','Up to 12 hours of training','Acceptance testing and handover'],'slug'=>'business'],
 ['name'=>'Enterprise','price'=>'$2,500','annual'=>'$700','desc'=>$copy['enterprise'],'features'=>['Requirements workshop and implementation plan','Manufacturing or project process configuration','Role-based staff training plan','Integration and migration assessment'],'slug'=>'enterprise']
];
$capabilities=['Accounting & finance','Inventory & warehouses','Sales & CRM','Purchasing & suppliers','Manufacturing','Projects & operations'];
@endphp
@section('content')
<style>
/* ERPNext landing: the same navy, orange and warm ivory as Fida Corporate Clean. */
.erp-landing{
  --erp-navy:#102a3a;--erp-ink:#19394a;--erp-orange:#e97828;
  --erp-orange-deep:#a7440a;--erp-ivory:#fff8f2;--erp-border:#e8ded5;
  --erp-muted:#5d7180;--erp-white:#fff;color:var(--erp-ink);background:#fffdfb;
  overflow-x:clip;isolation:isolate;
}
.erp-landing *{box-sizing:border-box}
.erp-landing .erp-wrap{width:min(1160px,calc(100% - 40px));margin-inline:auto;min-width:0}
.erp-landing .erp-hero{
  background:linear-gradient(125deg,#fffdfb 0%,#fff8f2 57%,#ffecdb 100%);
  border-bottom:1px solid #eedbd0;padding:76px 0 78px
}
.site-template-technology .erp-landing .erp-hero{padding-top:155px}
.erp-landing .erp-hero-grid{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);align-items:center;gap:clamp(26px,5vw,64px)}
.erp-landing .erp-hero-copy,.erp-landing .erp-hero-visual{min-width:0}
.erp-landing .erp-kicker{
  display:inline-flex;align-items:center;max-width:100%;padding:8px 13px;
  border:1px solid #efc9aa;border-radius:999px;background:#fff3e7;color:var(--erp-orange-deep);
  font-size:11px;letter-spacing:.055em;font-weight:800;line-height:1.45;white-space:normal
}
.erp-landing h1{font-size:clamp(37px,4.5vw,60px);line-height:1.10;letter-spacing:-.045em;font-weight:820;color:var(--erp-navy);margin:21px 0}
.erp-landing .erp-hero p{color:#51687a;line-height:1.78;font-size:16px;margin:0;max-width:585px}
.erp-landing .erp-hero .erp-actions{display:flex;gap:11px;align-items:center;flex-wrap:wrap;margin-top:27px}
.erp-landing .erp-button{
  display:inline-flex;align-items:center;justify-content:center;gap:9px;
  min-height:46px;padding:12px 19px;border-radius:10px;font-weight:800;
  font-size:13px;text-decoration:none!important;line-height:1.4;
  background:var(--erp-navy);color:#fff!important;
  border:1px solid var(--erp-navy);transition:background .16s,border-color .16s,transform .16s
}
.erp-landing .erp-button:hover{background:#244b61;border-color:#244b61;color:#fff!important;transform:translateY(-2px)}
.erp-landing .erp-button.ghost{background:#fff;border-color:var(--erp-navy);color:var(--erp-navy)!important}
.erp-landing .erp-button.ghost:hover{background:#e9f0f4;border-color:var(--erp-navy);color:var(--erp-navy)!important}
.erp-landing .erp-shot{
  position:relative;background:#fff;border-radius:17px;
  padding:11px;border:1px solid #e2e6eb;box-shadow:0 30px 65px rgba(26,57,76,.15);
  overflow:hidden;transform:none
}
.erp-landing .erp-browser{height:26px;display:flex;align-items:center;gap:5px;direction:ltr;padding:0 8px 9px;color:#596b78}
.erp-landing .erp-browser span{width:7px;height:7px;background:#ff6d64;border-radius:50%}
.erp-landing .erp-browser span:nth-child(2){background:#f8bf45}
.erp-landing .erp-browser span:nth-child(3){background:#48bd7a}
.erp-landing .erp-browser strong{margin-inline-start:9px;font-size:9px;letter-spacing:.02em}
.erp-landing .erp-shot img{display:block;max-width:100%;width:100%;height:auto;aspect-ratio:auto;object-fit:contain;border:1px solid #eef0f2;border-radius:8px}
.erp-landing .erp-visual-caption{margin:12px 0 0;color:#718392;font-size:11px;line-height:1.6}
.erp-landing .erp-section{padding:clamp(54px,7vw,90px) 0}
.erp-landing .erp-section.erp-pricing-section{background:#fffdfb}
.erp-landing .erp-section.erp-capabilities-section{background:#fff6ed;border-block:1px solid #f0e0d2}
.erp-landing .erp-section.erp-gallery-section{background:#fff}
.erp-landing .erp-section.erp-faq-section{background:#fff7ef;border-top:1px solid #eadace}
.erp-landing .erp-heading{max-width:745px;margin:0 auto 35px;text-align:center}
.erp-landing .erp-heading .erp-kicker{margin-bottom:13px}
.erp-landing .erp-heading h2{margin:0 0 13px;font-size:clamp(29px,3.35vw,43px);line-height:1.18;letter-spacing:-.037em;color:var(--erp-navy);font-weight:800}
.erp-landing .erp-heading p{margin:0;color:#607487;line-height:1.75;font-size:14px}
.erp-landing .erp-prices{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;align-items:stretch}
.erp-landing .erp-plan{
  display:flex;flex-direction:column;position:relative;min-width:0;padding:27px;
  border:1px solid #e8dbcf;border-radius:18px;background:#fff;
  box-shadow:0 14px 36px rgba(31,54,69,.06);
  color:var(--erp-ink)
}
.erp-landing .erp-plan.featured{border:2px solid var(--erp-orange);padding:26px;box-shadow:0 20px 50px rgba(177,94,38,.12)}
.erp-landing .erp-plan:before{position:absolute;inset:0 0 auto;height:5px;content:"";border-radius:17px 17px 0 0;background:#d2dce2}
.erp-landing .erp-plan.featured:before{background:var(--erp-orange)}
.erp-landing .erp-pill{font-size:10px;letter-spacing:.08em;font-weight:900;color:#a14d16;text-transform:uppercase}
.erp-landing .erp-plan.featured .erp-pill{display:inline-flex;align-self:flex-start;padding:7px 10px;background:#fff0e4;border-radius:6px}
.erp-landing .erp-plan h3{margin:16px 0 13px;font-size:26px;line-height:1.2;color:var(--erp-navy);font-weight:800}
.erp-landing .erp-plan .erp-price-row{display:flex;align-items:baseline;gap:9px;flex-wrap:wrap}
.erp-landing .erp-plan .price{font-weight:900;color:var(--erp-navy);font-size:clamp(39px,3.8vw,53px);letter-spacing:-.055em;line-height:1}
.erp-landing .erp-plan .erp-setup-label{margin:7px 0 0;color:#617284;font-size:12px}
.erp-landing .erp-plan .year{
  display:flex;align-items:center;justify-content:space-between;gap:10px;
  margin-top:21px;padding:13px 15px;border:1px solid #f0dfd1;
  border-radius:11px;background:#fff7f0;color:#516879;font-size:11px;line-height:1.45
}
.erp-landing .erp-plan .year strong{color:#9b470e;font-size:20px;white-space:nowrap}
.erp-landing .erp-plan .erp-desc{color:#526879;font-size:13px;line-height:1.75;margin:20px 0 14px;min-height:68px}
.erp-landing .erp-plan ul{padding:0;margin:0 0 23px;list-style:none;flex:1}
.erp-landing .erp-plan li{
  display:grid;grid-template-columns:17px minmax(0,1fr);align-items:start;
  gap:9px;margin:12px 0;color:#425b6c;font-size:12px;line-height:1.6
}
.erp-landing .erp-plan li:before{content:"✓";display:grid;place-items:center;width:17px;height:17px;border-radius:50%;font-size:11px;font-weight:900;color:#93420a;background:#ffe6d2;line-height:1}
.erp-landing .erp-plan .erp-button{width:100%;margin-top:auto}
.erp-landing .erp-fineprint{max-width:900px;margin:26px auto 0;color:#627586;font-size:12px;line-height:1.8;text-align:center}
.erp-landing .erp-fineprint span{display:block;margin-top:11px}
.erp-landing .erp-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:13px}
.erp-landing .erp-tile{display:flex;flex-direction:column;gap:20px;min-width:0;min-height:124px;padding:21px;border:1px solid #ecd8c7;background:#fffdfb;border-radius:13px;color:var(--erp-navy);font-size:15px;font-weight:780;line-height:1.5}
.erp-landing .erp-tile span{color:var(--erp-orange-deep);font-weight:900;font-size:11px;letter-spacing:.08em}
.erp-landing .erp-gallery{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}
.erp-landing .erp-gallery figure{margin:0;min-width:0;background:#fff;border:1px solid #e3e9ed;padding:10px;border-radius:16px;box-shadow:0 10px 28px #1830400a;overflow:hidden}
.erp-landing .erp-gallery-media{background:#f5f8fa;overflow:hidden;border-radius:10px}
.erp-landing .erp-gallery-media img{width:100%;max-width:100%;height:auto;object-fit:contain;display:block}
.erp-landing .erp-gallery figcaption{padding:12px 6px 6px;display:flex;gap:9px;justify-content:space-between;flex-wrap:wrap;color:var(--erp-navy)}
.erp-landing .erp-gallery figcaption strong{font-size:13px}
.erp-landing .erp-gallery figcaption small{font-size:11px;color:#728491}
.erp-landing .erp-gallery figcaption a{color:#9a4813;text-decoration:underline}
.erp-landing .erp-training{display:flex;align-items:center;justify-content:space-between;gap:25px;padding:clamp(25px,4vw,38px);margin-top:27px;background:var(--erp-navy);border-radius:17px}
.erp-landing .erp-training h2{font-size:clamp(23px,2.6vw,32px);margin:0 0 10px;color:#fff;line-height:1.2}
.erp-landing .erp-training p{max-width:720px;color:#d1dfe7;font-size:13px;line-height:1.75;margin:0}
.erp-landing .erp-training .erp-button{flex:none}
.erp-landing .erp-faq{max-width:865px;margin:auto;background:#fff;border:1px solid #e9d8ca;border-radius:15px;padding:0 25px}
.erp-landing .erp-faq details{padding:19px 0;border-bottom:1px solid #e8e0d9}
.erp-landing .erp-faq details:last-child{border-bottom:0}
.erp-landing .erp-faq summary{color:var(--erp-navy);cursor:pointer;font-size:15px;font-weight:750;line-height:1.5}
.erp-landing .erp-faq p{color:#627588;font-size:13px;line-height:1.8;margin:12px 0 0}
.erp-landing #pricing{scroll-margin-top:95px}
.site-template-technology .erp-landing #pricing{scroll-margin-top:110px}
@media(max-width:980px){
 .erp-landing .erp-hero-grid{grid-template-columns:1fr;gap:29px}
 .erp-landing .erp-prices{gap:12px}
 .erp-landing .erp-plan{padding:21px}
 .erp-landing .erp-plan.featured{padding:20px}
 .erp-landing .erp-plan .year{display:block}
 .erp-landing .erp-plan .year strong{display:block;margin-top:5px}
 .erp-landing .erp-plan .erp-desc{min-height:0}
}
@media(max-width:760px){
 .erp-landing .erp-prices{grid-template-columns:1fr;gap:15px}
 .erp-landing .erp-plan,.erp-landing .erp-plan.featured{padding:25px}
 .erp-landing .erp-plan .year{display:flex}
 .erp-landing .erp-plan .year strong{display:inline;margin-top:0}
 .erp-landing .erp-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
 .erp-landing .erp-gallery{grid-template-columns:1fr}
 .erp-landing .erp-training{display:block}
 .erp-landing .erp-training .erp-button{margin-top:21px}
 .erp-landing .erp-plan .erp-desc{margin-top:16px}
}
@media(max-width:540px){
 .erp-landing .erp-wrap{width:min(calc(100% - 28px),1160px)}
 .erp-landing .erp-hero{padding:43px 0 42px}
 .site-template-technology .erp-landing .erp-hero{padding-top:143px}
 .erp-landing h1{font-size:clamp(33px,9vw,42px);margin:17px 0}
 .erp-landing .erp-hero p{font-size:14px}
 .erp-landing .erp-hero .erp-actions{display:grid;grid-template-columns:1fr;gap:8px;margin-top:22px}
 .erp-landing .erp-hero .erp-button{width:100%}
 .erp-landing .erp-shot{padding:6px;border-radius:11px}
 .erp-landing .erp-browser{height:24px}
 .erp-landing .erp-section{padding:50px 0}
 .erp-landing .erp-heading{margin-bottom:27px}
 .erp-landing .erp-plan,.erp-landing .erp-plan.featured{padding:22px}
 .erp-landing .erp-plan h3{font-size:23px}
 .erp-landing .erp-plan .price{font-size:43px}
 .erp-landing .erp-tile{padding:16px;min-height:108px;font-size:13px}
 .erp-landing .erp-faq{padding:0 17px}
 .erp-landing .erp-gallery figcaption{display:block}
 .erp-landing .erp-gallery figcaption small{display:block;margin-top:5px}
}
</style>
<div class="erp-landing">
<section class="erp-hero"><div class="erp-wrap erp-hero-grid">
<div class="erp-hero-copy"><span class="erp-kicker">{{ $copy['eyebrow'] }}</span><h1>{{ $copy['hero'] }}</h1><p>{{ $copy['intro'] }}</p><div class="erp-actions"><a class="erp-button" href="{{ \App\Support\LocalizedUrl::path('/contact') }}?interest=erpnext-afghanistan#contact">{{ $copy['consult'] }} ↗</a><a class="erp-button ghost" href="#pricing">{{ $locale === 'fa' ? 'دیدن قیمت‌ها' : ($locale === 'ps' ? 'بیې وګورئ' : 'See pricing') }} ↓</a></div></div>
<div class="erp-hero-visual"><div class="erp-shot"><div class="erp-browser"><span></span><span></span><span></span><strong>ERPNext · Company dashboard</strong></div><img src="https://frappe.io/files/image6f308b.png" loading="eager" fetchpriority="high" alt="ERPNext company dashboard with sales, stock, purchasing and business analytics from Frappe" width="1000" height="625"></div><p class="erp-visual-caption">{{ $copy['gallerynote'] }}</p></div>
</div></section>
<section class="erp-section erp-pricing-section" id="pricing"><div class="erp-wrap"><div class="erp-heading"><span class="erp-kicker">{{ $locale === 'fa' ? 'بسته‌های تطبیق' : ($locale === 'ps' ? 'د پلي کولو بستې' : 'IMPLEMENTATION PACKAGES') }}</span><h2>{{ $copy['prices'] }}</h2><p>{{ $copy['pricesIntro'] }}</p></div><div class="erp-prices">
@foreach($plans as $plan)
<article @class(['erp-plan','featured'=>$plan['slug']==='business'])>
<span class="erp-pill">{{ $plan['slug']==='business' ? $copy['popular'] : 'FIDA ERPNext' }}</span>
<h3>{{ $plan['name'] }}</h3>
<div class="erp-price-row"><strong class="price">{{ $plan['price'] }}</strong></div>
<div class="erp-setup-label">{{ $copy['setup'] }}</div>
<div class="year"><span>{{ $copy['year'] }}</span><strong>{{ $plan['annual'] }} <small>/ {{ $locale === 'fa' ? 'سال' : ($locale === 'ps' ? 'کال' : 'year') }}</small></strong></div>
<p class="erp-desc">{{ $plan['desc'] }}</p><ul>@foreach($plan['features'] as $feature)<li><span>{{ $feature }}</span></li>@endforeach</ul>
<a class="erp-button" href="{{ \App\Support\LocalizedUrl::path('/contact') }}?interest=erpnext-afghanistan&amp;plan={{ $plan['slug'] }}#contact">{{ $copy['contact'] }} ↗</a>
</article>
@endforeach
</div><p class="erp-fineprint">{{ $copy['scope'] }}<span style="display:block;margin-top:12px">{{ $copy['independent'] }}</span></p></div></section>
<section class="erp-section erp-capabilities-section"><div class="erp-wrap"><div class="erp-heading"><h2>{{ $copy['modules'] }}</h2></div><div class="erp-grid">@foreach($capabilities as $capability)<div class="erp-tile"><span>0{{ $loop->iteration }}</span>{{ $capability }}</div>@endforeach</div></div></section>
<section class="erp-section erp-gallery-section"><div class="erp-wrap"><div class="erp-heading"><h2>{{ $copy['gallery'] }}</h2><p>{{ $copy['gallerynote'] }}</p></div><div class="erp-gallery"><figure><div class="erp-gallery-media"><img loading="lazy" src="https://frappe.io/files/sales.png" alt="ERPNext Selling Dashboard, including sales order trends and customer summary" width="1000" height="507"></div><figcaption><strong>Sales and customer overview</strong><small>ERPNext Selling · <a href="https://frappe.io/erpnext/usa" rel="noopener noreferrer" target="_blank">Frappe</a></small></figcaption></figure><figure><div class="erp-gallery-media"><img loading="lazy" src="https://docs.frappe.io/files/production-analytics.png" alt="ERPNext manufacturing production analytics with status chart and work orders" width="1000" height="562"></div><figcaption><strong>Production analytics</strong><small>ERPNext Manufacturing · <a href="https://docs.frappe.io/erpnext/manufacturing-dashboard" rel="noopener noreferrer" target="_blank">Frappe documentation</a></small></figcaption></figure></div><div class="erp-training"><div><h2>{{ $copy['training'] }}</h2><p>{{ $copy['trainingtext'] }}</p></div><a class="erp-button" href="{{ \App\Support\LocalizedUrl::path('/contact') }}?interest=erpnext-afghanistan#contact">{{ $copy['consult'] }} ↗</a></div></div></section>
@if($faqs !== [])
<section class="erp-section erp-faq-section"><div class="erp-wrap"><div class="erp-heading"><h2>{{ $copy['faq'] }}</h2></div><div class="erp-faq">@foreach($faqs as $faq)<details @if($loop->first) open @endif><summary>{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>@endforeach</div></div></section>
@endif
</div>
@endsection
