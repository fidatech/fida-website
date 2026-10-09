<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $page = ContentPage::query()->where('slug', 'solutions')->first();

        if (! $page) {
            return;
        }

        $page->update([
            'title' => [
                'en' => 'Enterprise Technology Solutions in Afghanistan',
                'fa' => 'راهکارهای تکنالوژی سازمانی در افغانستان',
                'ps' => 'په افغانستان کې د سازماني ټکنالوژۍ حللارې',
            ],
            'eyebrow' => [
                'en' => 'Software, infrastructure and integrated delivery',
                'fa' => 'نرم‌افزار، زیربنا و تحویل یکپارچه',
                'ps' => 'سافټویر، زیربنا او مدغم سپارنه',
            ],
            'summary' => [
                'en' => 'Explore ERP, custom software, web and mobile, AI, IoT, data centers, networks, cloud, cybersecurity, enterprise hardware, integration and managed IT services for government, NGOs and enterprises.',
                'fa' => 'ERP، نرم‌افزار اختصاصی، وب و موبایل، AI، IoT، دیتاسنتر، شبکه، کلود، امنیت، تجهیزات، یکپارچه‌سازی و خدمات IT را برای دولت، NGO و سازمان‌ها بررسی کنید.',
                'ps' => 'د دولت، NGO او سازمانونو لپاره ERP، ځانګړی سافټویر، ویب او موبایل، AI، IoT، ډیټا سنټر، شبکه، کلاوډ، امنیت، تجهیزات، ادغام او IT خدمات وګورئ.',
            ],
            'body' => [
                'en' => '<h2>One technology portfolio for software and infrastructure</h2><p>Fida solutions cover digital platforms and the infrastructure beneath them. Organizations can engage us for a focused software project, an infrastructure deployment, a technology supply requirement, or a coordinated project that combines software, hardware, networking, servers, security and support.</p><h2>Designed for formal institutional requirements</h2><p>For government, NGOs, banks and enterprises, solution pages identify scope, controls, implementation boundaries and documentation expectations. Formal RFQ, RFP, TOR and BoQ requirements can be submitted through the dedicated procurement channel.</p>',
                'fa' => '<h2>یک پورتفولیوی تکنالوژی برای نرم‌افزار و زیربنا</h2><p>راهکارهای Fida پلتفرم‌های دیجیتال و زیربنای آن را پوشش می‌دهد. سازمان‌ها می‌توانند برای پروژه نرم‌افزار، زیربنا، تأمین تجهیزات یا پروژه یکپارچه شامل نرم‌افزار، سخت‌افزار، شبکه، سرور، امنیت و پشتیبانی همکاری کنند.</p><h2>مناسب نیازمندی رسمی سازمانی</h2><p>برای دولت، NGO، بانک و سازمان‌ها، محدوده، کنترول، روش تطبیق و اسناد مورد نیاز واضح می‌شود. RFQ، RFP، TOR و BoQ از مسیر اختصاصی تدارکات قابل ارسال است.</p>',
                'ps' => '<h2>د سافټویر او زیربنا لپاره یو ټکنالوژي پورټفولیو</h2><p>د Fida حللارې ډیجیټل پلېټفارمونه او د هغوی زیربنا دواړه پوښي. ادارې کولی شي د سافټویر، زیربنا، تجهیزاتو عرضې یا ګډې پروژې لپاره همکاري وکړي.</p><h2>د رسمي سازماني اړتیاوو لپاره</h2><p>د دولت، NGO، بانک او سازمانونو لپاره حدود، کنټرولونه، پلي کول او اسناد روښانه کېږي. RFQ، RFP، TOR او BoQ د ځانګړي تدارکاتي چینل له لارې لېږل کېدای شي.</p>',
            ],
            'meta_title' => [
                'en' => 'Enterprise Technology Solutions Afghanistan | Fida',
                'fa' => 'راهکارهای تکنالوژی سازمانی افغانستان | Fida',
                'ps' => 'د سازماني ټکنالوژۍ حللارې افغانستان | Fida',
            ],
            'meta_description' => [
                'en' => 'ERP, software, AI, IoT, data centers, networks, cloud, cybersecurity, hardware and managed IT solutions for government, NGOs and enterprises in Afghanistan.',
                'fa' => 'ERP، نرم‌افزار، AI، IoT، دیتاسنتر، شبکه، کلود، امنیت، تجهیزات و خدمات IT برای دولت، NGO و سازمان‌ها در افغانستان.',
                'ps' => 'ERP، سافټویر، AI، IoT، ډیټا سنټر، شبکې، کلاوډ، امنیت، تجهیزات او IT خدمات د دولت، NGO او سازمانونو لپاره.',
            ],
            'primary_query' => [
                'en' => 'enterprise technology solutions Afghanistan',
                'fa' => 'راهکار تکنالوژی سازمانی افغانستان',
                'ps' => 'په افغانستان کې د سازماني ټکنالوژۍ حللارې',
            ],
            'search_intent' => 'commercial',
        ]);
    }

    public function down(): void
    {
        // Content expansion is intentionally retained on rollback.
    }
};
