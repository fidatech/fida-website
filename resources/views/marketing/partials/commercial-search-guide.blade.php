@php
    $isErp = $page->slug === 'erp-systems-afghanistan';
    $isSoftware = in_array($page->slug, ['software-company-afghanistan', 'enterprise-software-company-afghanistan', 'technology-company-afghanistan'], true);
    $language = in_array(app()->getLocale(), ['en', 'fa', 'ps'], true) ? app()->getLocale() : 'en';
    $copy = [
      'en' => [
        'erp' => ['title' => 'Plan an ERP implementation in Afghanistan', 'intro' => 'Use these questions to compare an ERP proposal against actual organizational needs.', 'items' => ['Which departments and branches need one shared record?', 'Which purchases, payments and adjustments require approvals?', 'Which currencies, reports, integrations and migration sources are in scope?', 'Who accepts the system, receives training and owns support after launch?'], 'related' => 'Explore ERP implementation guidance'],
        'software' => ['title' => 'How to evaluate a software company in Afghanistan', 'intro' => 'Ask for a written scope and a demonstration relevant to your own workflow before commissioning a system.', 'items' => ['Review the required user roles, permissions and audit history.', 'Confirm source-code ownership, hosting, backups and data export terms.', 'Request a phased demonstration, acceptance criteria and support agreement.', 'Assess local language support, branch connectivity and offline requirements.'], 'related' => 'Explore ERP systems'],
        'request' => 'Send a formal request for quotation',
      ],
      'fa' => [
        'erp' => ['title' => 'برنامه‌ریزی تطبیق ERP در افغانستان', 'intro' => 'برای مقایسه پیشنهاد ERP با نیاز واقعی اداره از این پرسش‌ها استفاده کنید.', 'items' => ['کدام بخش‌ها و شعبات به معلومات مشترک نیاز دارند؟', 'کدام خریدها، پرداخت‌ها و تعدیلات به تأیید نیاز دارند؟', 'کدام اسعار، گزارش‌ها، یکپارچه‌سازی‌ها و معلومات قبلی شامل پروژه هستند؟', 'چه کسی سیستم را تأیید می‌کند و مسئول آموزش و پشتیبانی است؟'], 'related' => 'رهنمای تطبیق ERP'],
        'software' => ['title' => 'چگونه یک شرکت نرم‌افزاری را در افغانستان ارزیابی کنیم', 'intro' => 'پیش از سفارش سیستم، محدوده کتبی و نمایش مرتبط با روند کاری خود را درخواست کنید.', 'items' => ['نقش کاربران، صلاحیت‌ها و تاریخچه تغییرات را بررسی کنید.', 'مالکیت کود منبع، میزبانی، بکاپ و خروج معلومات را مشخص کنید.', 'نمایش مرحله‌ای، معیار پذیرش و قرارداد پشتیبانی بخواهید.', 'زبان‌های محلی، اتصال شعبات و نیاز آفلاین را بررسی کنید.'], 'related' => 'مشاهده سیستم‌های ERP'],
        'request' => 'ارسال درخواست رسمی قیمت',
      ],
      'ps' => [
        'erp' => ['title' => 'په افغانستان کې د ERP د پلي کولو پلان', 'intro' => 'دا پوښتنې د ادارې له واقعي اړتیاوو سره د ERP وړاندیز په پرتله کولو کې مرسته کوي.', 'items' => ['کومې څانګې ګډو معلوماتو ته اړتیا لري؟', 'کومې پېرودنې، تادیات او سمونونه تایید غواړي؟', 'کوم اسعار، راپورونه، ادغامونه او پخواني معلومات د پروژې برخه دي؟', 'څوک سیسټم مني او د روزنې او ملاتړ مسئولیت لري؟'], 'related' => 'د ERP پلي کولو لارښود'],
        'software' => ['title' => 'په افغانستان کې د سافټویر شرکت څنګه وارزوو', 'intro' => 'د سیسټم تر سپارښتنې مخکې لیکلې کاري محدوده او د خپل بهیر اړوند ننداره وغواړئ.', 'items' => ['د کاروونکو رولونه، صلاحیتونه او د بدلون ثبت وګورئ.', 'د سرچینې کوډ مالکیت، کوربه‌توب، بیک‌اپ او د معلوماتو ایستلو شرطونه روښانه کړئ.', 'پړاویزه ننداره، د منلو معیارونه او د ملاتړ تړون وغواړئ.', 'سیمه‌ییزې ژبې، د څانګو اړیکه او آفلاین اړتیاوې وارزوئ.'], 'related' => 'د ERP سیسټمونه وګورئ'],
        'request' => 'د نرخ رسمي غوښتنه ولېږئ',
      ],
    ];
    $section = $copy[$language][$isErp ? 'erp' : 'software'];
@endphp

@if($isErp || $isSoftware)
<section class="page-content-section" aria-labelledby="commercial-decision-guide">
    <div class="container narrow">
        <div class="prose">
            <h2 id="commercial-decision-guide">{{ $section['title'] }}</h2>
            <p>{{ $section['intro'] }}</p>
            <ul>
                @foreach($section['items'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
            <p>
                <a href="{{ App\Support\LocalizedUrl::path($isErp ? '/erp-implementation-services-afghanistan' : '/erp-systems-afghanistan') }}">{{ $section['related'] }}</a>
                ·
                <a href="{{ App\Support\LocalizedUrl::path('/request-for-quotation') }}">{{ $copy[$language]['request'] }}</a>
            </p>
        </div>
    </div>
</section>
@endif
