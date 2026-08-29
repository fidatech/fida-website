<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class ReleaseDiscoveryCleanupSeeder extends Seeder
{
    public function run(): void
    {
        $locales = array_keys(config('website.locales', []));

        ContentPage::query()
            ->where('status', 'published')
            ->get(['id', 'title', 'primary_query'])
            ->each(function (ContentPage $page) use ($locales): void {
                $queries = is_array($page->primary_query) ? $page->primary_query : [];
                $changed = false;

                foreach ($locales as $locale) {
                    if (trim((string) data_get($queries, $locale)) !== '') {
                        continue;
                    }

                    $localizedTitle = trim((string) data_get($page->title, $locale));

                    if ($localizedTitle === '') {
                        continue;
                    }

                    $queries[$locale] = $localizedTitle;
                    $changed = true;
                }

                if ($changed) {
                    $page->forceFill(['primary_query' => $queries])->save();
                }
            });
    }
}
