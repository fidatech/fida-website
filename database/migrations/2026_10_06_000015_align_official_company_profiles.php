<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('content_pages')) {
            return;
        }

        // Existing production sites have the core about page before this
        // migration. Fresh/test databases stay empty until their seeders run.
        if (! DB::table('content_pages')->where('slug', 'about')->exists()) {
            return;
        }

        $this->alignWebsiteAddress();
        $this->refreshCompanyFactsIdentity();
    }

    public function down(): void
    {
        // Identity/profile URLs are intentionally not rolled back automatically.
        // They represent the current verified public company identity.
    }

    private function alignWebsiteAddress(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $setting = DB::table('site_settings')
            ->select(['id', 'value'])
            ->where('key', 'website.general')
            ->first();

        if (! $setting) {
            return;
        }

        $value = $this->decode($setting->value);
        $address = trim((string) ($value['address_line'] ?? ''));

        if (
            $address === ''
            || (
                str_contains(mb_strtolower($address), 'al munawara plaza')
                && ! str_contains(mb_strtolower($address), '4th floor')
            )
        ) {
            $value['address_line'] = '4th Floor, Al Munawara Plaza, Jada-e-Maiwand';

            DB::table('site_settings')->where('id', $setting->id)->update([
                'value' => $this->json($value),
                'updated_at' => now(),
            ]);
        }
    }

    private function refreshCompanyFactsIdentity(): void
    {
        $page = DB::table('content_pages')
            ->select(['id', 'body'])
            ->where('slug', 'company-facts')
            ->first();

        if (! $page) {
            return;
        }

        $body = $this->decode($page->body);
        $updated = false;

        $replacements = [
            'en' => [
                '<h2>Identity and contact</h2><p>The canonical company name is Fida Technologies. The official website is fida.af. Public website content is available in English, Dari and Pashto, and the contact details published on this website are the authoritative contact reference.</p>',
                '<h2>Identity and contact</h2><p>The canonical company name is Fida Technologies. The official website is fida.af. The Kabul office is at 4th Floor, Al Munawara Plaza, Jada-e-Maiwand, Kabul 1001, Afghanistan. Public website content is available in English, Dari and Pashto.</p><h2>Official public profiles</h2><ul><li><a href="https://www.linkedin.com/company/fida-technologies-afghanistan">LinkedIn — Fida Technologies Afghanistan</a></li><li><a href="https://www.facebook.com/FidaTechnologiesAfghanistan">Facebook — Fida Technologies Afghanistan</a></li><li><a href="https://github.com/fidatech">GitHub — fidatech</a></li></ul><p>These profiles, the Google Business Profile and fida.af represent the same Fida Technologies entity in Kabul, Afghanistan.</p>',
            ],
            'fa' => [
                '<h2>هویت و تماس</h2><p>نام برند Fida Technologies و وب‌سایت رسمی fida.af است. معلومات تماس همین وب‌سایت مرجع رسمی تماس است.</p>',
                '<h2>هویت و تماس</h2><p>نام رسمی برند Fida Technologies و وب‌سایت رسمی fida.af است. دفتر کابل در طبقه چهارم، Al Munawara Plaza، Jada-e-Maiwand، کابل 1001، افغانستان قرار دارد.</p><h2>پروفایل‌های رسمی</h2><ul><li><a href="https://www.linkedin.com/company/fida-technologies-afghanistan">LinkedIn — Fida Technologies Afghanistan</a></li><li><a href="https://www.facebook.com/FidaTechnologiesAfghanistan">Facebook — Fida Technologies Afghanistan</a></li><li><a href="https://github.com/fidatech">GitHub — fidatech</a></li></ul><p>این پروفایل‌ها، پروفایل تجارتی گوگل و fida.af همه مربوط به همان Fida Technologies در کابل، افغانستان است.</p>',
            ],
            'ps' => [
                '<h2>هویت او اړیکه</h2><p>رسمي برانډ نوم Fida Technologies او رسمي وېب‌سایټ fida.af دی. د همدې وېب‌سایټ د اړیکې معلومات رسمي مرجع ده.</p>',
                '<h2>هویت او اړیکه</h2><p>رسمي برانډ نوم Fida Technologies او رسمي وېب‌سایټ fida.af دی. د کابل دفتر په 4th Floor، Al Munawara Plaza، Jada-e-Maiwand، کابل 1001، افغانستان کې دی.</p><h2>رسمي عامه پروفایلونه</h2><ul><li><a href="https://www.linkedin.com/company/fida-technologies-afghanistan">LinkedIn — Fida Technologies Afghanistan</a></li><li><a href="https://www.facebook.com/FidaTechnologiesAfghanistan">Facebook — Fida Technologies Afghanistan</a></li><li><a href="https://github.com/fidatech">GitHub — fidatech</a></li></ul><p>دا پروفایلونه، د Google Business Profile او fida.af ټول په کابل، افغانستان کې د همدې Fida Technologies استازیتوب کوي.</p>',
            ],
        ];

        foreach ($replacements as $locale => [$before, $after]) {
            if (isset($body[$locale]) && str_contains($body[$locale], $before)) {
                $body[$locale] = str_replace($before, $after, $body[$locale]);
                $updated = true;
            }
        }

        if (! $updated) {
            return;
        }

        DB::table('content_pages')->where('id', $page->id)->update([
            'body' => $this->json($body),
            'sitemap_last_modified_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function decode(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode((string) $value, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function json(array $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }
};
