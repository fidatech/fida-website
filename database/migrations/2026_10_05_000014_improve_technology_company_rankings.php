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

        // Production already has the base public website at this point. Fresh
        // installs remain empty until DatabaseSeeder so isolated tests can
        // control their own content fixtures.
        if (! DB::table('content_pages')->where('slug', 'about')->exists()) {
            return;
        }

        $this->updateTechnologyCompanyPage();
        $this->publishPluralTechnologyGuide();
        $this->alignPublicBusinessAddress();
    }

    public function down(): void
    {
        if (Schema::hasTable('content_pages')) {
            DB::table('content_pages')->where('slug', 'technology-companies-afghanistan')->delete();
        }
    }

    private function updateTechnologyCompanyPage(): void
    {
        $page = DB::table('content_pages')
            ->select(['id', 'summary', 'body', 'meta_title', 'meta_description', 'primary_query', 'metadata'])
            ->where('slug', 'technology-company-afghanistan')
            ->first();

        if (! $page) {
            return;
        }

        $summary = $this->decode($page->summary);
        $body = $this->decode($page->body);
        $metaTitle = $this->decode($page->meta_title);
        $metaDescription = $this->decode($page->meta_description);
        $primaryQuery = $this->decode($page->primary_query);
        $metadata = $this->decode($page->metadata);

        $summary['en'] = 'Fida Technologies is a Kabul-based technology and enterprise software company building ERP, MIS, financial systems, custom software, websites, mobile applications and integrations for organizations in Afghanistan.';
        $body['en'] = '<h2>Technology built around real Afghan business workflows</h2><p><strong>Fida Technologies: a technology company in Afghanistan.</strong> Fida Technologies is based in Kabul and focuses on enterprise software and digital systems. We build ERP, MIS, accounting and financial platforms, custom business software, websites, mobile applications, APIs, integrations and industry-specific systems for organizations in Afghanistan.</p><h2>Looking for technology companies in Afghanistan?</h2><p>The Afghan technology market includes telecom operators, internet and infrastructure providers, hosting companies, digital agencies and software developers. Fida belongs to the software and enterprise systems category rather than telecom. For organizations looking specifically for ERP, MIS, accounting, workflow automation, custom software, web development or mobile applications, this distinction matters.</p><h2>What we build</h2><ul><li>ERP and MIS systems for connected operations</li><li>Accounting and multi-currency financial software</li><li>Custom Laravel web applications, portals and SaaS products</li><li>Professional multilingual company and institutional websites</li><li>Android and iOS applications with secure APIs</li><li>Workflow automation, dashboards, integrations and data platforms</li><li>Industry systems for finance, Sarafi, pharmacy, healthcare, education, construction, real estate, logistics and manufacturing</li></ul><h2>Why organizations compare Fida with other Afghan technology companies</h2><p>Technology providers should be compared by the problem they actually solve. Fida focuses on business process analysis, permissions, approvals, auditability, reporting, integrations, data migration, multilingual delivery and maintainable software. Projects can support English, Dari and Pashto, right-to-left interfaces, multi-currency requirements and branch-based operations when required by the approved scope.</p><h2>Local presence in Kabul</h2><p>Fida Technologies operates from Kabul, Afghanistan and maintains a public business profile, official website, phone and company contact information. Our process covers discovery, solution design, development, testing, deployment, training and continued improvement.</p>';
        $metaTitle['en'] = 'Technology Company Afghanistan | Fida Technologies';
        $metaDescription['en'] = 'Fida Technologies is a Kabul technology company for ERP, MIS, accounting, custom software, websites and mobile apps. Compare technology companies in Afghanistan by capability.';
        $primaryQuery['en'] = 'technology company Afghanistan';

        $metadata['secondary_queries'] = array_values(array_unique(array_merge(
            (array) ($metadata['secondary_queries'] ?? []),
            [
                'technology company in Afghanistan',
                'technology companies Afghanistan',
                'technology companies in Afghanistan',
                'IT company Afghanistan',
                'software company Afghanistan',
                'technology company Kabul',
            ],
        )));

        $metadata['related_slugs'] = array_values(array_unique(array_merge(
            (array) ($metadata['related_slugs'] ?? []),
            ['technology-companies-afghanistan', 'company-facts', 'erp-systems-afghanistan'],
        )));

        $faqs = (array) ($metadata['faqs'] ?? []);
        $pluralQuestion = 'Is Fida Technologies one of the technology companies in Afghanistan?';

        if (! collect($faqs)->contains(fn (array $faq): bool => data_get($faq, 'question.en') === $pluralQuestion)) {
            $faqs[] = [
                'question' => [
                    'en' => $pluralQuestion,
                    'fa' => 'آیا Fida Technologies یکی از شرکت‌های تکنالوژی در افغانستان است؟',
                    'ps' => 'ایا Fida Technologies په افغانستان کې د ټکنالوژۍ له شرکتونو څخه دی؟',
                ],
                'answer' => [
                    'en' => 'Yes. Fida Technologies is a Kabul-based software and technology company focused on ERP, MIS, financial systems, custom software, websites, mobile applications and integrations.',
                    'fa' => 'بله. Fida Technologies یک شرکت نرم‌افزار و تکنالوژی مستقر در کابل است که روی ERP، MIS، سیستم‌های مالی، نرم‌افزار اختصاصی، ویب‌سایت، موبایل و یکپارچه‌سازی تمرکز دارد.',
                    'ps' => 'هو. Fida Technologies په کابل کې د سافټویر او ټکنالوژۍ شرکت دی چې ERP، MIS، مالي سیسټمونه، ځانګړی سافټویر، وېب، موبایل او ادغامونه جوړوي.',
                ],
            ];
        }

        $metadata['faqs'] = $faqs;

        DB::table('content_pages')->where('id', $page->id)->update([
            'summary' => $this->json($summary),
            'body' => $this->json($body),
            'meta_title' => $this->json($metaTitle),
            'meta_description' => $this->json($metaDescription),
            'primary_query' => $this->json($primaryQuery),
            'metadata' => $this->json($metadata),
            'sitemap_last_modified_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function publishPluralTechnologyGuide(): void
    {
        $factory = require database_path('data/ai-discovery-content.php');
        $pages = $factory(fn (array $question, array $answer): array => compact('question', 'answer'));
        $page = $pages['technology-companies-afghanistan'] ?? null;

        if (! is_array($page)) {
            return;
        }

        DB::table('content_pages')->updateOrInsert(
            ['slug' => 'technology-companies-afghanistan'],
            [
                'type' => $page['type'],
                'title' => $this->json($page['title']),
                'eyebrow' => $this->json($page['eyebrow']),
                'summary' => $this->json($page['summary']),
                'body' => $this->json($page['body']),
                'meta_title' => $this->json($page['meta_title']),
                'meta_description' => $this->json($page['meta_description']),
                'primary_query' => $this->json($page['primary_query']),
                'search_intent' => $page['search_intent'],
                'robots_directive' => 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
                'sitemap_included' => true,
                'sitemap_priority' => $page['priority'],
                'sitemap_change_frequency' => 'weekly',
                'sitemap_last_modified_at' => now(),
                'schema' => null,
                'metadata' => $this->json($page['metadata']),
                'status' => 'published',
                'featured' => $page['featured'],
                'sort_order' => $page['sort_order'],
                'published_at' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );
    }

    private function alignPublicBusinessAddress(): void
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

        if (trim((string) ($value['address_line'] ?? '')) !== '') {
            return;
        }

        $value['address_line'] = 'Al Munawara Plaza, Jada-e-nadar Pashtoon';

        DB::table('site_settings')->where('id', $setting->id)->update([
            'value' => $this->json($value),
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
