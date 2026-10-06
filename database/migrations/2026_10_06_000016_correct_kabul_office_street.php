<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_settings')) {
            $setting = DB::table('site_settings')
                ->select(['id', 'value'])
                ->where('key', 'website.general')
                ->first();

            if ($setting) {
                $value = $this->decode($setting->value);
                $address = (string) ($value['address_line'] ?? '');
                $corrected = str_ireplace(
                    ['Jada-e-Nadar Pashtoon', 'Jada-e-nadar Pashtoon'],
                    'Jada-e-Maiwand',
                    $address,
                );

                if ($corrected !== $address) {
                    $value['address_line'] = $corrected;

                    DB::table('site_settings')->where('id', $setting->id)->update([
                        'value' => $this->json($value),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        if (Schema::hasTable('content_pages')) {
            $page = DB::table('content_pages')
                ->select(['id', 'body'])
                ->where('slug', 'company-facts')
                ->first();

            if ($page) {
                $body = $this->decode($page->body);
                $changed = false;

                foreach ($body as $locale => $html) {
                    if (! is_string($html)) {
                        continue;
                    }

                    $corrected = str_ireplace(
                        ['Jada-e-Nadar Pashtoon', 'Jada-e-nadar Pashtoon'],
                        'Jada-e-Maiwand',
                        $html,
                    );

                    if ($corrected !== $html) {
                        $body[$locale] = $corrected;
                        $changed = true;
                    }
                }

                if ($changed) {
                    DB::table('content_pages')->where('id', $page->id)->update([
                        'body' => $this->json($body),
                        'sitemap_last_modified_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        // The previous street value was incorrect, so it is intentionally not restored.
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
