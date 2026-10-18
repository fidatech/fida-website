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
.erp-landing{--e-accent:#c9ff4a;color:#f1f5f9}.erp-landing .erp-wrap{width:min(1180px,calc(100% - 40px));margin:auto}.erp-landing .erp-hero{padding:100px 0 85px;background:radial-gradient(ellipse at 83% 10%,rgba(153,255,95,.15),transparent 50%),linear-gradient(160deg,#0c1721,#101f29 65%,#0c161f)}.erp-landing .erp-hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:55px;align-items:center}.erp-landing .erp-kicker{display:inline-flex;border:1px solid rgba(201,255,74,.35);border-radius:40px;padding:9px 16px;color:#c9ff4a;font-size:12px;font-weight:800;letter-spacing:.07em}.erp-landing h1{font-size:clamp(2.5rem,4.7vw,5rem);line-height:1.08;letter-spacing:-.04em;margin:25px 0}.erp-landing .erp-hero p{font-size:1.1rem;color:#bdc9d3;line-height:1.8;max-width:610px}.erp-landing .erp-button{display:inline-flex;justify-content:center;align-items:center;padding:14px 22px;text-decoration:none!important;background:var(--e-accent);border-radius:12px;color:#102017!important;font-weight:800;margin-top:20px}.erp-landing .erp-button.ghost{background:transparent;color:#f3f7fa!important;border:1px solid #526572;margin-inline-start:10px}.erp-landing .erp-shot{background:#f8fafc;padding:12px;border-radius:20px;box-shadow:0 28px 85px #0008;transform:rotate(-2deg)}.erp-landing .erp-shot img{display:block;width:100%;aspect-ratio:1.4;object-fit:cover;object-position:top;border-radius:10px}.erp-landing .erp-credit{font-size:12px;color:#b0bcc7;margin-top:22px}.erp-landing .erp-section{padding:82px 0}.erp-landing .erp-heading{text-align:center;max-width:760px;margin:0 auto 42px}.erp-landing .erp-heading h2{font-size:clamp(2rem,3.4vw,3rem);letter-spacing:-.025em;line-height:1.16;margin:0 0 14px}.erp-landing .erp-heading p{color:#aebfc9;line-height:1.7}.erp-landing .erp-prices{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px;align-items:stretch}.erp-landing .erp-plan{position:relative;background:linear-gradient(150deg,#1a2c36,#101f2a);border:1px solid #344954;border-radius:22px;padding:32px;display:flex;flex-direction:column;box-shadow:0 12px 35px #0002}.erp-landing .erp-plan.featured{border:2px solid #c9ff4a;background:linear-gradient(155deg,#22382d,#152a2b)}.erp-landing .erp-pill{font-size:11px;font-weight:800;color:#c9ff4a;letter-spacing:.11em}.erp-landing .erp-plan h3{font-size:24px;margin:14px 0}.erp-landing .erp-plan .price{font-size:clamp(2.5rem,4vw,3.4rem);font-weight:850;letter-spacing:-.05em;line-height:1.05;color:#fff}.erp-landing .erp-plan .year{border-top:1px solid #3d5359;margin-top:19px;padding-top:17px;font-size:15px}.erp-landing .erp-plan .year strong{color:#c9ff4a;font-size:21px}.erp-landing .erp-plan p,.erp-landing .erp-plan li{color:#c2ced3;line-height:1.65}.erp-landing .erp-plan ul{margin:15px 0 22px;padding-inline-start:18px;flex:1}.erp-landing .erp-plan li{margin:10px 0}.erp-landing .erp-plan .erp-button{width:100%}.erp-landing .erp-fineprint{text-align:center;color:#afbdc7;font-size:13px;line-height:1.8;margin:26px auto;max-width:850px}.erp-landing .erp-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.erp-landing .erp-tile{padding:28px;background:#182a35;border:1px solid #334851;border-radius:18px;font-size:17px;font-weight:700}.erp-landing .erp-tile span{display:block;color:#c9ff4a;margin-bottom:20px;font-size:12px}.erp-landing .erp-gallery{display:grid;grid-template-columns:1fr 1fr;gap:24px}.erp-landing figure{margin:0;background:#f8fafc;padding:12px;border-radius:20px;color:#304254}.erp-landing figure img{width:100%;aspect-ratio:1.6;object-fit:cover;object-position:top;border-radius:12px;display:block}.erp-landing figcaption{font-size:13px;padding:10px 6px 2px}.erp-landing .erp-training{background:linear-gradient(120deg,#213c32,#10292c);border:1px solid #386b4b;border-radius:26px;padding:42px;margin-top:20px}.erp-landing .erp-training h2{font-size:2.1rem;margin:0 0 12px}.erp-landing .erp-training p{max-width:770px;color:#d3ddd8;line-height:1.8}.erp-landing .erp-faq{max-width:840px;margin:auto}.erp-landing .erp-faq details{border-bottom:1px solid #3a4b54;padding:18px 0}.erp-landing .erp-faq summary{cursor:pointer;font-weight:700;font-size:17px}.erp-landing .erp-faq p{color:#bdcbd2;line-height:1.8}.erp-landing .erp-muted{color:#b0bdc5;text-align:center;margin-top:18px;font-size:13px}@media(max-width:900px){.erp-landing .erp-hero-grid,.erp-landing .erp-gallery{grid-template-columns:1fr}.erp-landing .erp-prices{grid-template-columns:1fr}.erp-landing .erp-grid{grid-template-columns:repeat(2,1fr)}.erp-landing .erp-hero{padding:65px 0}.erp-landing .erp-shot{transform:none}}@media(max-width:540px){.erp-landing .erp-grid{grid-template-columns:1fr}.erp-landing .erp-wrap{width:min(100% - 28px,1180px)}.erp-landing .erp-plan{padding:25px}.erp-landing .erp-section{padding:58px 0}.erp-landing .erp-button.ghost{margin-inline-start:0}}

/* ERPNext mobile header clearance, unclipped product imagery and denser editorial layout */
.erp-landing{overflow:hidden;isolation:isolate}
.erp-landing .erp-hero{padding-top:clamp(145px,13vw,190px);padding-bottom:85px}
.erp-landing .erp-hero-grid{gap:clamp(28px,4vw,64px)}
.erp-landing .erp-hero-copy{min-width:0}
.erp-landing .erp-hero p{margin:18px 0 0}
.erp-landing .erp-kicker{max-width:100%;white-space:normal;line-height:1.4}
.erp-landing .erp-hero-visual{min-width:0}
.erp-landing .erp-shot{padding:9px;background:#edf1f3;border:1px solid rgba(255,255,255,.65);border-radius:18px;transform:rotate(-1.5deg);overflow:hidden}
.erp-landing .erp-browser{height:30px;display:flex;align-items:center;gap:5px;padding:0 11px 8px;direction:ltr;color:#34424b}
.erp-landing .erp-browser span{height:7px;width:7px;border-radius:50%;background:#ff666a}
.erp-landing .erp-browser span:nth-child(2){background:#ffbf48}
.erp-landing .erp-browser span:nth-child(3){background:#35c687}
.erp-landing .erp-browser strong{font-size:10px;letter-spacing:.01em;font-weight:700;margin-inline-start:12px}
.erp-landing .erp-shot img{display:block;width:100%;height:auto;aspect-ratio:auto;object-fit:contain;object-position:center;border-radius:9px;border:1px solid #d8e0e4}
.erp-landing .erp-visual-caption{color:#a4b2b9;font-size:11px;line-height:1.5;margin:14px 0 0}
.erp-landing .erp-gallery figure{overflow:hidden;background:#eef2f5;padding:10px;border:1px solid #d6e0e5}
.erp-landing .erp-gallery-media{overflow:hidden;border-radius:11px;background:#fff}
.erp-landing .erp-gallery-media img{display:block;width:100%;height:auto;aspect-ratio:auto;object-fit:contain}
.erp-landing .erp-gallery figcaption{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;padding:14px 8px 6px;color:#263945}
.erp-landing .erp-gallery figcaption strong{font-size:14px}
.erp-landing .erp-gallery figcaption small{font-size:11px;color:#536875}
.erp-landing .erp-gallery figcaption a{color:#12698d;text-decoration:underline}
.erp-landing #pricing{scroll-margin-top:125px}
.erp-landing .erp-plan ul li::marker{color:#c9ff4a}
@media(max-width:900px){
 .erp-landing .erp-hero{padding:140px 0 48px}
 .erp-landing .erp-hero-grid{gap:32px}
 .erp-landing .erp-shot{transform:none}
 .erp-landing .erp-hero h1{font-size:clamp(34px,6.2vw,50px);line-height:1.15;letter-spacing:-.032em;margin:21px 0 16px}
 .erp-landing .erp-hero p{font-size:16px;line-height:1.68}
 .erp-landing .erp-hero .erp-button{margin-top:20px}
 .erp-landing .erp-visual-caption{font-size:11px}
}
@media(max-width:540px){
 .erp-landing .erp-hero{padding-top:146px;padding-bottom:40px}
 .erp-landing .erp-hero-grid{gap:27px}
 .erp-landing .erp-hero h1{font-size:clamp(32px,9vw,39px);line-height:1.14;letter-spacing:-.032em;margin:17px 0 12px}
 .erp-landing .erp-kicker{padding:8px 12px;font-size:10px;letter-spacing:.04em}
 .erp-landing .erp-hero p{font-size:15px;line-height:1.65;margin:14px 0 0}
 .erp-landing .erp-hero .erp-button{display:flex;width:100%;margin:18px 0 0;padding:13px 16px;font-size:14px;min-height:48px}
 .erp-landing .erp-hero .erp-button.ghost{margin:9px 0 0}
 .erp-landing .erp-shot{padding:6px;border-radius:15px}
 .erp-landing .erp-browser{height:24px;padding:0 6px 5px}
 .erp-landing .erp-browser strong{font-size:9px;margin-inline-start:8px}
 .erp-landing .erp-visual-caption{font-size:10px;margin:10px 3px 0}
 .erp-landing .erp-heading h2{font-size:clamp(26px,8vw,34px)}
 .erp-landing .erp-gallery{gap:18px}
 .erp-landing .erp-gallery figcaption{align-items:flex-start;flex-direction:column;gap:4px}
 .erp-landing .erp-training{padding:26px}
 .erp-landing .erp-training h2{font-size:25px}
}
</style>
<div class="erp-landing">
<section class="erp-hero"><div class="erp-wrap erp-hero-grid">
<div class="erp-hero-copy"><span class="erp-kicker">{{ $copy['eyebrow'] }}</span><h1>{{ $copy['hero'] }}</h1><p>{{ $copy['intro'] }}</p><a class="erp-button" href="{{ \App\Support\LocalizedUrl::path('/contact') }}?interest=erpnext-afghanistan#contact">{{ $copy['consult'] }} ↗</a><a class="erp-button ghost" href="#pricing">{{ $locale === 'fa' ? 'دیدن قیمت‌ها' : ($locale === 'ps' ? 'بیې وګورئ' : 'See pricing') }} ↓</a></div>
<div class="erp-hero-visual"><div class="erp-shot"><div class="erp-browser"><span></span><span></span><span></span><strong>ERPNext · Company dashboard</strong></div><img src="https://frappe.io/files/image6f308b.png" loading="eager" fetchpriority="high" alt="ERPNext company dashboard with sales, stock, purchasing and business analytics from Frappe" width="1000" height="625"></div><p class="erp-visual-caption">{{ $copy['gallerynote'] }}</p></div>
</div></section>
<section class="erp-section" id="pricing"><div class="erp-wrap"><div class="erp-heading"><span class="erp-kicker">IMPLEMENTATION PACKAGES</span><h2>{{ $copy['prices'] }}</h2><p>{{ $copy['pricesIntro'] }}</p></div><div class="erp-prices">
@foreach($plans as $plan)
<article @class(['erp-plan','featured'=>$plan['slug']==='business'])>
<span class="erp-pill">{{ $plan['slug']==='business' ? $copy['popular'] : 'FIDA ERPNext' }}</span>
<h3>{{ $plan['name'] }}</h3>
<div class="price">{{ $plan['price'] }}</div>
<small>{{ $copy['setup'] }}</small>
<div class="year">{{ $copy['year'] }} <strong>{{ $plan['annual'] }}</strong> / year</div>
<p>{{ $plan['desc'] }}</p><ul>@foreach($plan['features'] as $feature)<li>{{ $feature }}</li>@endforeach</ul>
<a class="erp-button" href="{{ \App\Support\LocalizedUrl::path('/contact') }}?interest=erpnext-afghanistan&amp;plan={{ $plan['slug'] }}#contact">{{ $copy['contact'] }} ↗</a>
</article>
@endforeach
</div><p class="erp-fineprint">{{ $copy['scope'] }}</p></div></section>
<section class="erp-section" style="background:#10212b"><div class="erp-wrap"><div class="erp-heading"><h2>{{ $copy['modules'] }}</h2></div><div class="erp-grid">@foreach($capabilities as $capability)<div class="erp-tile"><span>0{{ $loop->iteration }}</span>{{ $capability }}</div>@endforeach</div></div></section>
<section class="erp-section"><div class="erp-wrap"><div class="erp-heading"><h2>{{ $copy['gallery'] }}</h2><p>{{ $copy['gallerynote'] }}</p></div><div class="erp-gallery"><figure><div class="erp-gallery-media"><img loading="lazy" src="https://frappe.io/files/sales.png" alt="ERPNext Selling Dashboard, including sales order trends and customer summary" width="1000" height="507"></div><figcaption><strong>Sales and customer overview</strong><small>ERPNext Selling · <a href="https://frappe.io/erpnext/usa" rel="noopener noreferrer" target="_blank">Frappe</a></small></figcaption></figure><figure><div class="erp-gallery-media"><img loading="lazy" src="https://docs.frappe.io/files/production-analytics.png" alt="ERPNext manufacturing production analytics with status chart and work orders" width="1000" height="562"></div><figcaption><strong>Production analytics</strong><small>ERPNext Manufacturing · <a href="https://docs.frappe.io/erpnext/manufacturing-dashboard" rel="noopener noreferrer" target="_blank">Frappe documentation</a></small></figcaption></figure></div><div class="erp-training"><h2>{{ $copy['training'] }}</h2><p>{{ $copy['trainingtext'] }}</p><a class="erp-button" href="{{ \App\Support\LocalizedUrl::path('/contact') }}?interest=erpnext-afghanistan#contact">{{ $copy['consult'] }} ↗</a></div></div></section>
@if($faqs !== [])
<section class="erp-section" style="background:#10212b"><div class="erp-wrap"><div class="erp-heading"><h2>{{ $copy['faq'] }}</h2></div><div class="erp-faq">@foreach($faqs as $faq)<details @if($loop->first) open @endif><summary>{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>@endforeach</div></div></section>
@endif
</div>
@endsection
