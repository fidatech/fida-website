<?php

namespace Tests\Feature;

use App\Http\Middleware\EnforceCanonicalHost;
use App\Models\ContentPage;
use App\Models\Lead;
use Database\Seeders\WebsiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
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
            ->assertSee('realist-real-estate-erp')
            ->assertSee('prime-sarafi-software')
            ->assertSee('/about')
            ->assertSee('/services')
            ->assertSee('/projects')
            ->assertSee('/pricing')
            ->assertSee('/contact')
            ->assertSee('privacy-policy')
            ->assertDontSee('realist-erp-case-study')
            ->assertSee('hreflang="fa"', false)
            ->assertSee('hreflang="x-default"', false);
    }

    public function test_product_pages_expose_localized_profiles_and_software_schema(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/realist-real-estate-erp')
            ->assertOk()
            ->assertSee('<h1>Realist ERP for Real Estate &amp; Construction</h1>', false)
            ->assertSee('Property inventory')
            ->assertSee('Project-based implementation')
            ->assertSee('"@type":"SoftwareApplication"', false)
            ->assertSee('"featureList"', false);

        $this->get('/fa/prime-sarafi-software')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl">', false)
            ->assertSee('نرم‌افزار مدیریت صرافی و حواله Prime')
            ->assertSee('پلتفرم صرافی و حواله');
    }

    public function test_primary_navigation_uses_real_multilingual_pages(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('href="'.url('/about').'"', false)
            ->assertSee('href="'.url('/services').'"', false)
            ->assertSee('href="'.url('/projects').'"', false)
            ->assertSee('href="'.url('/pricing').'"', false)
            ->assertSee('href="'.url('/contact').'"', false);

        $this->get('/fa/about')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl">', false)
            ->assertSee('درباره Fida Technologies');
    }

    public function test_services_and_projects_hubs_link_to_detailed_pages(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/services')
            ->assertOk()
            ->assertSee('<h1>Software &amp; Technology Services</h1>', false)
            ->assertSee('ERP Systems in Afghanistan')
            ->assertSee('Accounting Software in Afghanistan')
            ->assertSee('"@type":"CollectionPage"', false);

        $this->get('/projects')
            ->assertOk()
            ->assertSee('Realist ERP for Real Estate &amp; Construction', false)
            ->assertSee('Prime Sarafi &amp; Remittance Management Software', false)
            ->assertSee('Darmal Pharmacy &amp; Pharmaceutical ERP', false)
            ->assertSee('OGRAYI Mobile Credit &amp; Debit Account Manager', false)
            ->assertDontSee('publication draft');
    }

    public function test_pricing_and_contact_pages_are_truthful_and_actionable(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/pricing')
            ->assertOk()
            ->assertSee('Custom quotation')
            ->assertSee('Why one fixed price would be misleading')
            ->assertSee('Request an estimate');

        $this->get('/contact')
            ->assertOk()
            ->assertSee('<h1>Contact Fida Technologies</h1>', false)
            ->assertSee('action="'.route('leads.store').'"', false)
            ->assertSee('"@type":"ContactPage"', false);
    }

    public function test_unverified_case_studies_remain_private_drafts(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->assertSame(4, ContentPage::query()->where('type', 'case-study')->where('status', 'draft')->count());

        $this->get('/realist-erp-case-study')->assertNotFound();
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
        config()->set('website.indexable', true);
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

    public function test_production_analytics_is_configurable_and_requires_consent(): void
    {
        config()->set('website.indexable', true);
        config()->set('website.analytics.ga4_measurement_id', 'G-TEST123');
        config()->set('website.analytics.require_consent', true);

        $this->get('/')
            ->assertOk()
            ->assertSee('measurementId: "G-TEST123"', false)
            ->assertSee('data-analytics-consent', false)
            ->assertSee('Analytics stays off until you accept.')
            ->assertDontSee('https://www.googletagmanager.com/gtag/js?id=G-TEST123', false);
    }

    public function test_www_requests_redirect_permanently_to_the_canonical_production_host(): void
    {
        config()->set('website.indexable', true);
        config()->set('website.url', 'https://fida.af');

        $request = Request::create(
            'https://www.fida.af/realist-real-estate-erp?utm_source=google',
            'GET',
        );
        $response = (new EnforceCanonicalHost)->handle($request, fn () => response('next'));

        $this->assertSame(301, $response->getStatusCode());
        $this->assertSame(
            'https://fida.af/realist-real-estate-erp?utm_source=google',
            $response->headers->get('Location'),
        );
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
        config()->set('website.indexable', true);
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
