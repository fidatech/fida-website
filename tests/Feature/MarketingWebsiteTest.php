<?php

namespace Tests\Feature;

use App\Models\Lead;
use Database\Seeders\WebsiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MarketingWebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_homepage_targets_the_primary_software_company_keyword(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<html lang="en" dir="ltr">', false)
            ->assertSee('Software Company in Afghanistan')
            ->assertSee('A software company in Afghanistan built for operational complexity.')
            ->assertSee('ERP &amp; MIS Systems', false);
    }

    public function test_localized_homepage_uses_rtl_markup(): void
    {
        $this->get('/fa')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl">', false)
            ->assertSee('شرکت نرم‌افزاری در افغانستان');
    }

    public function test_seeded_erp_landing_page_is_indexable(): void
    {
        $this->seed(WebsiteSeeder::class);

        $canonical = url('/erp-systems-afghanistan');

        $this->get('/erp-systems-afghanistan')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.$canonical.'">', false)
            ->assertSee('<h1>ERP Systems in Afghanistan</h1>', false)
            ->assertSee('What is an ERP system?')
            ->assertSee('"@type":"Service"', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('BreadcrumbList');
    }

    public function test_localized_service_page_keeps_answer_content_available(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/fa/erp-systems-afghanistan')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl">', false)
            ->assertSee('پرسش‌های متداول')
            ->assertSee('What is an ERP system?');
    }

    public function test_sitemap_contains_seeded_pages_and_localized_alternates(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('erp-systems-afghanistan')
            ->assertSee('technology-company-afghanistan')
            ->assertSee('hreflang="fa"', false)
            ->assertSee('hreflang="x-default"', false);
    }

    public function test_homepage_exposes_organization_and_website_entities(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('"@type":"Organization"', false)
            ->assertSee('"@type":"WebSite"', false)
            ->assertSee('"knowsAbout"', false);
    }

    public function test_search_verification_and_crawler_controls_are_configurable(): void
    {
        config()->set('website.search_verification.google', 'google-token');
        config()->set('website.search_verification.bing', 'bing-token');

        $this->get('/')
            ->assertSee('name="google-site-verification" content="google-token"', false)
            ->assertSee('name="msvalidate.01" content="bing-token"', false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent: OAI-SearchBot')
            ->assertSee('User-agent: GPTBot')
            ->assertSee(route('sitemap'));
    }

    public function test_non_indexable_environment_blocks_crawlers_and_url_submission(): void
    {
        config()->set('website.indexable', false);
        config()->set('website.indexnow.key', '0123456789abcdef0123456789abcdef');

        $this->get('/')
            ->assertOk()
            ->assertSee('name="robots" content="noindex,nofollow,noarchive"', false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee("User-agent: *\nDisallow: /")
            ->assertDontSee('Sitemap:');

        $this->artisan('website:indexnow')
            ->expectsOutput('IndexNow submission is disabled while WEBSITE_INDEXABLE is false.')
            ->assertFailed();
    }

    public function test_indexnow_key_and_published_url_submission_are_available(): void
    {
        $this->seed(WebsiteSeeder::class);
        config()->set('website.indexnow.key', '0123456789abcdef0123456789abcdef');
        config()->set('website.indexnow.endpoint', 'https://api.indexnow.org/indexnow');
        config()->set('website.url', url('/'));
        Http::fake(['https://api.indexnow.org/*' => Http::response('', 200)]);

        $this->get('/indexnow-key.txt')
            ->assertOk()
            ->assertSee('0123456789abcdef0123456789abcdef');

        $this->artisan('website:indexnow')->assertSuccessful();

        Http::assertSent(fn ($request): bool =>
            $request['host'] === parse_url(url('/'), PHP_URL_HOST)
            && $request['key'] === '0123456789abcdef0123456789abcdef'
            && in_array(url('/erp-systems-afghanistan'), $request['urlList'], true)
        );
    }

    public function test_valid_project_request_is_recorded_as_a_lead(): void
    {
        $response = $this->post('/contact/lead', [
            'name' => 'Ahmad Example',
            'email' => 'ahmad@example.com',
            'phone' => '+93700000000',
            'company' => 'Example Trading',
            'project_type' => 'erp',
            'budget' => '3000-10000',
            'message' => 'We need an ERP for our multi-branch trading company.',
            'locale' => 'en',
            'source_url' => 'https://fida.af/',
            'utm_source' => 'google',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('lead_success');
        $this->assertDatabaseCount('leads', 1);
        $this->assertSame('new', Lead::query()->firstOrFail()->status);
    }

    public function test_honeypot_field_rejects_bot_submissions(): void
    {
        $this->post('/contact/lead', [
            'name' => 'Spam Bot',
            'email' => 'spam@example.com',
            'project_type' => 'website',
            'message' => 'This message is deliberately long enough to pass validation.',
            'website' => 'https://spam.example.com',
        ])->assertSessionHasErrors('website');

        $this->assertDatabaseCount('leads', 0);
    }
}
