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

        $body = is_array($page->body) ? $page->body : [];

        $sections = [
            'en' => '<h2>RFQ and procurement documents</h2><p>RFQ, RFP, TOR, BoQ and related procurement files submitted through the quotation channel are stored in private application storage and are intended only for authorized Fida personnel reviewing the opportunity. They are used to assess scope, eligibility, technical requirements, quotation and follow-up. Do not submit credentials, passwords or unrelated sensitive personal information.</p>',
            'fa' => '<h2>اسناد RFQ و تدارکات</h2><p>فایل‌های RFQ، RFP، TOR، BoQ و اسناد مرتبط که از مسیر درخواست قیمت ارسال می‌شود در فضای خصوصی سیستم نگهداری شده و فقط برای افراد مجاز Fida جهت بررسی محدوده، اهلیت، نیازمندی تخنیکی، قیمت و پیگیری قابل دسترسی است. لطفاً رمز عبور، معلومات ورود یا معلومات شخصی غیرمرتبط ارسال نکنید.</p>',
            'ps' => '<h2>RFQ او تدارکاتي اسناد</h2><p>RFQ، RFP، TOR، BoQ او اړوند فایلونه چې د نرخ غوښتنې له لارې لېږل کېږي په شخصي سیسټمي ذخیره کې ساتل کېږي او یوازې د Fida مجاز کارکوونکي یې د حدودو، اهلیت، تخنیکي اړتیاوو، نرخ او تعقیب لپاره کتلی شي. پاسورډونه، د ننوتلو معلومات یا غیر اړوند حساس شخصي معلومات مه لېږئ.</p>',
        ];

        foreach ($sections as $locale => $section) {
            $current = (string) ($body[$locale] ?? '');

            if ($current !== '' && ! str_contains($current, strip_tags(explode('</h2>', $section, 2)[0]))) {
                $body[$locale] = $current.$section;
            }
        }

        $page->update(['body' => $body]);
    }

    public function down(): void
    {
        // Privacy disclosure is intentionally retained.
    }
};
