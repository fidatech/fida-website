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

        $this->repairKnownStarterMetadata();
    }

    private function repairKnownStarterMetadata(): void
    {
        foreach ($this->metadataReplacements() as $slug => $fields) {
            $page = ContentPage::query()->where('slug', $slug)->first();

            if (! $page) {
                continue;
            }

            $updates = [];

            foreach ($fields as $field => $locales) {
                $translations = is_array($page->getAttribute($field))
                    ? $page->getAttribute($field)
                    : [];

                foreach ($locales as $locale => $replacement) {
                    if (data_get($translations, $locale) !== $replacement['from']) {
                        continue;
                    }

                    $translations[$locale] = $replacement['to'];
                    $updates[$field] = $translations;
                }
            }

            if ($updates !== []) {
                $page->forceFill($updates)->save();
            }
        }
    }

    private function metadataReplacements(): array
    {
        return [
            'custom-software-vs-off-the-shelf-afghanistan' => [
                'meta_description' => [
                    'ps' => [
                        'from' => 'مناسب‌والی، لګښت، چټکتیا، مالکیت، ادغام او اوږدمهاله بدلون پرتله کړئ.',
                        'to' => 'د ځانګړي او چمتو سافټویر مناسب‌والی، لګښت، چټکتیا، مالکیت، ادغام او اوږدمهاله بدلون پرتله کړئ.',
                    ],
                ],
            ],
            'erp-implementation-checklist-afghanistan' => [
                'meta_description' => [
                    'fa' => [
                        'from' => 'چک‌لیست مرحله‌وار آمادگی از مسئولیت پروژه تا راه‌اندازی.',
                        'to' => 'چک‌لیست مرحله‌وار تطبیق ERP برای آمادگی سازمان، مسئولیت پروژه، معلومات، آزمایش، آموزش و راه‌اندازی.',
                    ],
                    'ps' => [
                        'from' => 'د پروژې له مسؤلیت څخه تر پیل پورې پړاویز چمتووالي لست.',
                        'to' => 'د ERP پلي کولو پړاویز لست: د پروژې مسؤلیت، معلومات، ازموینه، روزنه او بریالی پیل چمتو کړئ.',
                    ],
                ],
            ],
            'how-to-choose-erp-system-afghanistan' => [
                'meta_description' => [
                    'fa' => [
                        'from' => 'راهنمای عملی ارزیابی روند، کاربران، کنترول، معلومات و تطبیق.',
                        'to' => 'برای انتخاب ERP در افغانستان، روندها، کاربران، کنترول‌ها، معلومات، تطبیق، پشتیبانی و هزینه کامل را مسئولانه ارزیابی کنید.',
                    ],
                    'ps' => [
                        'from' => 'د کاري بهیر، کاروونکو، کنټرول، معلوماتو او پلي کولو عملي لارښود.',
                        'to' => 'په افغانستان کې د ERP د ټاکلو لپاره کاري بهیرونه، کاروونکي، کنټرولونه، معلومات، پلي کول، ملاتړ او ټول لګښت وارزوئ.',
                    ],
                ],
            ],
            'professional-services-software-afghanistan' => [
                'meta_description' => [
                    'en' => [
                        'from' => 'Connect clients, projects, tasks, billing and team accountability.',
                        'to' => 'Professional services software in Afghanistan for connected clients, projects, tasks, billing and accountable team delivery.',
                    ],
                    'fa' => [
                        'from' => 'مشتری، پروژه، وظیفه، بل و پاسخگویی تیم را یکجا سازید.',
                        'to' => 'نرم‌افزار خدمات مسلکی در افغانستان برای مدیریت یکپارچه مشتری، پروژه، وظیفه، بل‌دهی و پاسخگویی تیم.',
                    ],
                    'ps' => [
                        'from' => 'مشتریان، پروژې، دندې، بلونه او د ټیم حساب ورکونه ونښلوئ.',
                        'to' => 'په افغانستان کې د مسلکي خدمتونو سافټویر؛ مشتریان، پروژې، دندې، بلونه او د ټیم حساب ورکونه یوځای اداره کړئ.',
                    ],
                ],
            ],
            'questions-before-hiring-software-company-afghanistan' => [
                'meta_title' => [
                    'en' => [
                        'from' => 'Questions to Ask Before Hiring a Software Company in Afghanistan | Fida',
                        'to' => 'Questions Before Hiring a Software Company in Afghanistan | Fida',
                    ],
                ],
            ],
            'real-estate-construction-software-afghanistan' => [
                'meta_description' => [
                    'en' => [
                        'from' => 'Connect inventory, sales, contracts, construction and finance.',
                        'to' => 'Real estate and construction software in Afghanistan connecting property inventory, sales, contracts, project costs and finance.',
                    ],
                    'fa' => [
                        'from' => 'موجودی، فروش، قرارداد، ساختمان و مالی را یکجا سازید.',
                        'to' => 'نرم‌افزار املاک و ساختمان در افغانستان برای یکپارچه‌سازی موجودی، فروش، قراردادها، مصارف پروژه و امور مالی.',
                    ],
                    'ps' => [
                        'from' => 'موجودي، پلور، قراردادونه، ساختمان او مالي چارې یوځای کړئ.',
                        'to' => 'په افغانستان کې د املاکو او ساختماني سافټویر؛ موجودي، پلور، قراردادونه، د پروژې لګښتونه او مالي چارې یوځای کړئ.',
                    ],
                ],
            ],
        ];
    }
}
