<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $page = ContentPage::query()->where('slug', 'privacy-policy')->first();

        if (! $page) {
            return;
        }

        $body = (array) $page->body;
        $append = [
            'en' => '<h2>Website analytics and search performance</h2><p>Fida Technologies uses first-party website analytics to understand page visits, traffic sources, device categories, crawler activity and business actions such as contact clicks and submitted enquiries. The analytics system stores one-way hashes derived from technical identifiers instead of storing the visitor IP address in raw form. Country information is recorded only when the hosting or delivery infrastructure supplies a country code. Search-query and search-performance data may also be imported from Google Search Console to understand how public pages appear in search results.</p><p>This information is used to improve website content, usability, search visibility and business services. It is not intended to identify individual visitors.</p>',
            'fa' => '<h2>تحلیل وب‌سایت و عملکرد جستجو</h2><p>Fida Technologies از تحلیل داخلی وب‌سایت برای درک بازدید صفحات، منابع ترافیک، نوع دستگاه، فعالیت crawlerها و اقدام‌های تجارتی مانند کلیک تماس و ارسال درخواست استفاده می‌کند. سیستم تحلیل به‌جای نگهداری IP خام، هش یک‌طرفه از شناسه‌های تخنیکی ذخیره می‌کند. معلومات کشور تنها زمانی ثبت می‌شود که زیرساخت میزبانی یا تحویل محتوا کد کشور را فراهم کند. معلومات عملکرد جستجو نیز ممکن است از Google Search Console وارد شود تا نحوه نمایش صفحات عمومی در نتایج جستجو بررسی گردد.</p><p>این معلومات برای بهبود محتوا، تجربه کاربر، دیده‌شدن در جستجو و خدمات تجارتی استفاده می‌شود و هدف آن شناسایی اشخاص نیست.</p>',
            'ps' => '<h2>د وېب‌سایټ تحلیل او د لټون فعالیت</h2><p>Fida Technologies د پاڼو لیدنې، د ترافیک سرچینې، د وسایلو ډولونه، د crawler فعالیت او سوداګریز اقدامات لکه د اړیکې کلیک او د غوښتنې لېږل د پوهېدو لپاره لومړي-ګوند وېب تحلیل کاروي. سیسټم د خام IP پر ځای د تخنیکي پېژندپاڼو یوطرفه hash ساتي. د هېواد معلومات یوازې هغه وخت ثبتېږي چې کوربه یا د محتوا رسولو زیربنا د هېواد کوډ وړاندې کړي. د Google Search Console د لټون معلومات هم واردېدای شي څو د عامه پاڼو د لټون فعالیت وارزول شي.</p><p>دا معلومات د منځپانګې، کارن تجربې، د لټون لید او سوداګریزو خدمتونو د ښه کولو لپاره کارول کېږي او موخه یې د اشخاصو پېژندنه نه ده.</p>',
        ];

        foreach ($append as $locale => $section) {
            $current = (string) ($body[$locale] ?? '');

            if (! str_contains($current, 'Website analytics and search performance')
                && ! str_contains($current, 'تحلیل وب‌سایت و عملکرد جستجو')
                && ! str_contains($current, 'د وېب‌سایټ تحلیل او د لټون فعالیت')) {
                $body[$locale] = $current.$section;
            }
        }

        $page->update([
            'body' => $body,
            'sitemap_last_modified_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Privacy disclosure is intentionally retained.
    }
};
