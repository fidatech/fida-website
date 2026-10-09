<?php

namespace Tests\Feature;

use App\Models\ContentPage;
use App\Models\PageRedirect;
use App\Support\LocalizedUrl;
use App\Support\WebsiteReleaseAudit;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\ReleaseDiscoveryCleanupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReleaseReadinessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_complete_release_seed_has_no_blocking_content_findings(): void
    {
        $this->seed(DatabaseSeeder::class);

        $report = app(WebsiteReleaseAudit::class)->run();
        $blockers = collect($report['findings'])->where('severity', 'blocker')->values()->all();
        $warnings = collect($report['findings'])->where('severity', 'warning')->values()->all();

        $this->assertSame([], $blockers, json_encode($blockers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $this->assertNotEmpty($warnings, 'The quality audit should surface editorial cleanup opportunities without blocking a safe release.');
        $this->assertTrue($report['ready']);
        $this->assertSame([], $report['summary']['blocker_codes']);
        $this->assertArrayHasKey('thin-visible-content', $report['summary']['warning_codes']);
        $this->assertArrayHasKey('missing-article-review', $report['summary']['warning_codes']);
        $this->assertGreaterThan(0, $report['summary']['public_pages']);
        $this->assertSame(
            $report['summary']['public_pages'] * count(config('website.locales')),
            $report['summary']['localized_routes'],
        );

        $this->artisan('website:release-audit')
            ->expectsOutputToContain('Release audit passed with no blockers.')
            ->assertSuccessful();
    }

    public function test_buyer_guides_use_distinct_primary_topics_from_commercial_pages(): void
    {
        $this->seed(DatabaseSeeder::class);

        $pairs = [
            ['about', 'company-facts'],
            ['accounting-software-afghanistan', 'accounting-software-afghanistan-buyers-guide'],
            ['agriculture-agribusiness-software-afghanistan', 'agriculture-software-afghanistan-guide'],
            ['asset-maintenance-management-software-afghanistan', 'asset-management-software-afghanistan-guide'],
            ['ngo-ingo-software-afghanistan', 'ngo-erp-finance-software-afghanistan-guide'],
        ];

        foreach ($pairs as [$commercialSlug, $guideSlug]) {
            $commercial = ContentPage::query()->where('slug', $commercialSlug)->firstOrFail();
            $guide = ContentPage::query()->where('slug', $guideSlug)->firstOrFail();

            foreach (array_keys(config('website.locales')) as $locale) {
                $this->assertNotSame(
                    mb_strtolower(trim((string) data_get($commercial->primary_query, $locale))),
                    mb_strtolower(trim((string) data_get($guide->primary_query, $locale))),
                    "{$commercialSlug} and {$guideSlug} should not target the same {$locale} primary topic.",
                );
            }
        }
    }

    public function test_discovery_cleanup_fills_only_missing_localized_primary_topics(): void
    {
        $page = ContentPage::query()->create([
            'type' => 'solution',
            'slug' => 'professional-services-software-afghanistan',
            'title' => [
                'en' => 'Localized fixture title',
                'fa' => 'عنوان محلی آزمایشی',
                'ps' => 'ځايي ازمایښتي سرلیک',
            ],
            'primary_query' => [
                'en' => 'Editor-selected primary topic',
                'fa' => '',
            ],
            'meta_description' => [
                'en' => 'Connect clients, projects, tasks, billing and team accountability.',
                'fa' => 'توضیح اختصاصی و تأییدشده مدیر محتوا باید بدون تغییر باقی بماند.',
                'ps' => 'مشتریان، پروژې، دندې، بلونه او د ټیم حساب ورکونه ونښلوئ.',
            ],
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->seed(ReleaseDiscoveryCleanupSeeder::class);
        $page->refresh();

        $this->assertSame('Editor-selected primary topic', $page->primary_query['en']);
        $this->assertSame('عنوان محلی آزمایشی', $page->primary_query['fa']);
        $this->assertSame('ځايي ازمایښتي سرلیک', $page->primary_query['ps']);
        $this->assertSame('Professional services software in Afghanistan for connected clients, projects, tasks, billing and accountable team delivery.', $page->meta_description['en']);
        $this->assertSame('توضیح اختصاصی و تأییدشده مدیر محتوا باید بدون تغییر باقی بماند.', $page->meta_description['fa']);
        $this->assertSame('په افغانستان کې د مسلکي خدمتونو سافټویر؛ مشتریان، پروژې، دندې، بلونه او د ټیم حساب ورکونه یوځای اداره کړئ.', $page->meta_description['ps']);
    }

    public function test_release_audit_blocks_missing_localization_broken_links_and_discovery_conflicts(): void
    {
        ContentPage::query()->create([
            'type' => 'solution',
            'slug' => 'unsafe-release-page',
            'title' => ['en' => 'Unsafe release page'],
            'summary' => ['en' => 'This fixture deliberately omits its required localized release content.'],
            'body' => ['en' => '<h2>Incomplete release fixture</h2><p>This page must fail the release audit.</p>'],
            'meta_title' => ['en' => 'Unsafe Release Page | Fida'],
            'meta_description' => ['en' => 'A deliberately incomplete page used to verify the automated release audit and publishing safeguards.'],
            'primary_query' => ['en' => 'unsafe release fixture'],
            'robots_directive' => 'noindex,follow,noarchive',
            'sitemap_included' => true,
            'metadata' => ['related_slugs' => ['missing-release-target']],
            'status' => 'published',
            'published_at' => now(),
        ]);

        $report = app(WebsiteReleaseAudit::class)->run();
        $codes = collect($report['findings'])->where('severity', 'blocker')->pluck('code');

        $this->assertFalse($report['ready']);
        $this->assertContains('missing-translation', $codes);
        $this->assertContains('broken-related-link', $codes);
        $this->assertContains('sitemap-robots-conflict', $codes);

        $this->artisan('website:release-audit')->assertFailed();
    }

    public function test_production_audit_requires_explicit_launch_configuration(): void
    {
        config()->set('website.indexable', false);
        config()->set('website.url', 'http://stage.fida.af');
        config()->set('website.social_image', 'http://stage.fida.af/images/fida-social-preview.png');
        config()->set('app.debug', true);
        config()->set('session.secure', false);

        $report = app(WebsiteReleaseAudit::class)->run(production: true);
        $codes = collect($report['findings'])->where('severity', 'blocker')->pluck('code');

        $this->assertContains('production-environment', $codes);
        $this->assertContains('production-debug', $codes);
        $this->assertContains('production-indexing', $codes);
        $this->assertContains('production-canonical-url', $codes);
        $this->assertContains('production-canonical-host', $codes);
        $this->assertContains('production-session-cookie', $codes);
        $this->assertContains('production-social-image', $codes);
    }

    public function test_production_audit_accepts_the_approved_secure_launch_configuration(): void
    {
        config()->set('app.env', 'production');
        config()->set('app.debug', false);
        config()->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
        config()->set('website.indexable', true);
        config()->set('website.url', 'https://fida.af');
        config()->set('website.production_host', 'fida.af');
        config()->set('website.social_image', 'https://fida.af/images/fida-social-preview.png');
        config()->set('session.secure', true);
        config()->set('session.http_only', true);

        $report = app(WebsiteReleaseAudit::class)->run(production: true);
        $blockers = collect($report['findings'])->where('severity', 'blocker')->values()->all();

        $this->assertSame([], $blockers, json_encode($blockers, JSON_PRETTY_PRINT));
    }

    public function test_release_audit_blocks_redirect_chains_conflicts_reserved_paths_and_missing_targets(): void
    {
        $this->seed(DatabaseSeeder::class);

        PageRedirect::query()->insert([
            ['source_path' => '/erp-systems-afghanistan', 'target_path' => '/contact', 'status_code' => 301, 'active' => true, 'hits' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['source_path' => '/old-a', 'target_path' => '/old-b', 'status_code' => 301, 'active' => true, 'hits' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['source_path' => '/old-b', 'target_path' => '/contact', 'status_code' => 301, 'active' => true, 'hits' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['source_path' => '/old-missing', 'target_path' => '/not-a-public-page', 'status_code' => 301, 'active' => true, 'hits' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['source_path' => '/admin/legacy', 'target_path' => '/contact', 'status_code' => 301, 'active' => true, 'hits' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $report = app(WebsiteReleaseAudit::class)->run();
        $codes = collect($report['findings'])->where('severity', 'blocker')->pluck('code');

        $this->assertContains('redirect-source-conflict', $codes);
        $this->assertContains('redirect-chain', $codes);
        $this->assertContains('redirect-target-missing', $codes);
        $this->assertContains('redirect-reserved-source', $codes);
        $this->assertSame(5, $report['summary']['active_redirects']);
    }

    public function test_every_public_page_renders_in_every_locale_with_accessibility_and_discovery_markup(): void
    {
        $this->seed(DatabaseSeeder::class);
        config()->set('website.indexable', true);
        $pages = ContentPage::published()->orderBy('slug')->get(['id', 'slug']);
        $routeCount = 0;

        foreach ($pages as $page) {
            foreach (config('website.locales') as $locale => $definition) {
                $path = $locale === config('website.default_locale')
                    ? '/'.$page->slug
                    : '/'.$locale.'/'.$page->slug;
                $canonical = LocalizedUrl::path('/'.$page->slug, $locale);
                $skipLabel = trans('website.accessibility.skip_to_content', [], $locale);
                $socialImageAlt = trans('website.seo.social_image_alt', [], $locale);

                $this->get($path)
                    ->assertOk()
                    ->assertSee('<html lang="'.$locale.'" dir="'.$definition['direction'].'"', false)
                    ->assertSee('<link rel="canonical" href="'.$canonical.'">', false)
                    ->assertSee('<meta property="og:image" content="'.config('website.social_image').'">', false)
                    ->assertSee('<meta property="og:image:width" content="1200">', false)
                    ->assertSee('<meta property="og:image:height" content="630">', false)
                    ->assertSee('<meta property="og:image:alt" content="'.$socialImageAlt.'">', false)
                    ->assertSee('href="#main">'.$skipLabel, false)
                    ->assertSee('<main id="main">', false);

                $routeCount++;
            }
        }

        $this->assertSame($pages->count() * count(config('website.locales')), $routeCount);
    }
}
