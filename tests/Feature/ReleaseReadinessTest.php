<?php

namespace Tests\Feature;

use App\Models\ContentPage;
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

        $this->assertSame([], $blockers, json_encode($blockers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $this->assertTrue($report['ready']);
        $this->assertSame([], $report['summary']['blocker_codes']);
        $this->assertArrayNotHasKey('missing-primary-query', $report['summary']['warning_codes']);
        $this->assertArrayNotHasKey('missing-social-image', $report['summary']['warning_codes']);
        $this->assertGreaterThan(0, $report['summary']['public_pages']);
        $this->assertSame(
            $report['summary']['public_pages'] * count(config('website.locales')),
            $report['summary']['localized_routes'],
        );

        $this->artisan('website:release-audit')
            ->expectsOutputToContain('Release audit passed with no blockers.')
            ->assertSuccessful();
    }

    public function test_discovery_cleanup_fills_only_missing_localized_primary_topics(): void
    {
        $page = ContentPage::query()->create([
            'type' => 'solution',
            'slug' => 'discovery-cleanup-fixture',
            'title' => [
                'en' => 'Localized fixture title',
                'fa' => 'عنوان محلی آزمایشی',
                'ps' => 'ځايي ازمایښتي سرلیک',
            ],
            'primary_query' => [
                'en' => 'Editor-selected primary topic',
                'fa' => '',
            ],
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->seed(ReleaseDiscoveryCleanupSeeder::class);
        $page->refresh();

        $this->assertSame('Editor-selected primary topic', $page->primary_query['en']);
        $this->assertSame('عنوان محلی آزمایشی', $page->primary_query['fa']);
        $this->assertSame('ځايي ازمایښتي سرلیک', $page->primary_query['ps']);
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
        config()->set('app.debug', true);

        $report = app(WebsiteReleaseAudit::class)->run(production: true);
        $codes = collect($report['findings'])->where('severity', 'blocker')->pluck('code');

        $this->assertContains('production-environment', $codes);
        $this->assertContains('production-debug', $codes);
        $this->assertContains('production-indexing', $codes);
        $this->assertContains('production-canonical-url', $codes);
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
