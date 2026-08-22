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
            ->assertSee('<html lang="en" dir="ltr"', false)
            ->assertSee('Software Company in Afghanistan')
            ->assertSee('A software company in Afghanistan built for operational complexity.')
            ->assertSee('ERP &amp; MIS Systems', false);
    }

    public function test_localized_homepage_uses_rtl_markup(): void
    {
        $this->get('/fa')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
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
            ->assertSee('<html lang="fa" dir="rtl"', false)
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
            ->assertSee('erp-implementation-services-afghanistan')
            ->assertSee('real-estate-construction-software-afghanistan')
            ->assertSee('how-to-choose-erp-system-afghanistan')
            ->assertSee('/about')
            ->assertSee('/services')
            ->assertSee('/projects')
            ->assertSee('/solutions')
            ->assertSee('/products')
            ->assertSee('/industries')
            ->assertSee('/case-studies')
            ->assertSee('/articles')
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
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('نرم‌افزار مدیریت صرافی و حواله Prime')
            ->assertSee('پلتفرم صرافی و حواله');
    }

    public function test_primary_navigation_uses_real_multilingual_pages(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('data-nav-cluster', false)
            ->assertSee('class="nav-cluster-menu nav-mega-menu', false)
            ->assertSee('href="'.url('/about').'"', false)
            ->assertSee('href="'.url('/services').'"', false)
            ->assertSee('href="'.url('/solutions').'"', false)
            ->assertSee('href="'.url('/products').'"', false)
            ->assertSee('href="'.url('/industries').'"', false)
            ->assertSee('href="'.url('/case-studies').'"', false)
            ->assertSee('href="'.url('/articles').'"', false)
            ->assertSee('href="'.url('/projects').'"', false)
            ->assertSee('href="'.url('/pricing').'"', false)
            ->assertSee('href="'.url('/contact').'"', false);

        $this->get('/')
            ->assertSee('href="'.url('/erp-implementation-services-afghanistan').'"', false)
            ->assertSee('href="'.url('/real-estate-construction-software-afghanistan').'"', false)
            ->assertSee('href="'.url('/how-to-choose-erp-system-afghanistan').'"', false)
            ->assertDontSee('realist-erp-case-study');

        $this->get('/fa/about')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('درباره Fida Technologies')
            ->assertSee('href="'.url('/fa/erp-implementation-services-afghanistan').'"', false)
            ->assertSee('خدمات تطبیق ERP در افغانستان');
    }

    public function test_public_search_finds_published_content_and_is_not_indexable(): void
    {
        $this->seed(WebsiteSeeder::class);
        config()->set('website.indexable', true);

        $this->get('/search?q=ERP')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,follow,noarchive">', false)
            ->assertSee('Results for “ERP”')
            ->assertSee('ERP Systems in Afghanistan')
            ->assertSee('ERP Implementation Services in Afghanistan')
            ->assertSee('href="'.url('/erp-systems-afghanistan').'"', false)
            ->assertDontSee('Realist ERP case study');

        $this->get('/fa/search?q=ERP')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('نتایج برای «ERP»')
            ->assertSee('سیستم‌های ERP در افغانستان')
            ->assertSee('href="'.url('/fa/erp-systems-afghanistan').'"', false);
    }

    public function test_public_search_requires_a_meaningful_query(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/search?q=E')
            ->assertOk()
            ->assertSee('Enter at least two characters to search the published website.')
            ->assertDontSee('search-result-card', false);
    }

    public function test_services_and_projects_hubs_link_to_detailed_pages(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/services')
            ->assertOk()
            ->assertSee('<h1>Software &amp; Technology Services</h1>', false)
            ->assertSee('ERP Systems in Afghanistan')
            ->assertSee('ERP Implementation Services in Afghanistan')
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

    public function test_every_public_content_archive_is_available_and_only_lists_published_entries(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/solutions')
            ->assertOk()
            ->assertSee('Business Software Solutions')
            ->assertSee('ERP Systems in Afghanistan')
            ->assertSee('"@type":"CollectionPage"', false);

        $this->get('/products')
            ->assertOk()
            ->assertSee('Fida Software Products')
            ->assertSee('Realist ERP for Real Estate &amp; Construction', false);

        $this->get('/industries')
            ->assertOk()
            ->assertSee('Real Estate &amp; Construction Software in Afghanistan', false)
            ->assertSee('Sarafi &amp; Remittance Software in Afghanistan', false)
            ->assertDontSee('No public entries yet.');

        $this->get('/case-studies')
            ->assertOk()
            ->assertSee('No public entries yet.')
            ->assertDontSee('publication draft');

        $this->get('/articles')
            ->assertOk()
            ->assertSee('Software &amp; Business Insights', false)
            ->assertSee('How to Choose an ERP System in Afghanistan')
            ->assertSee('ERP Implementation Checklist for Afghan Businesses')
            ->assertDontSee('No public entries yet.');
    }

    public function test_seeded_article_has_localized_content_archive_context_and_article_schema(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/how-to-choose-erp-system-afghanistan')
            ->assertOk()
            ->assertSee('<meta property="og:type" content="article">', false)
            ->assertSee('href="'.url('/articles').'"', false)
            ->assertSee('<time datetime="', false)
            ->assertSee('How to Choose an ERP System in Afghanistan')
            ->assertSee('Ask vendors to demonstrate your scenario')
            ->assertSee('"@type":"Article"', false)
            ->assertSee('"mainEntityOfPage"', false)
            ->assertSee('"position":3', false);

        $this->get('/fa/how-to-choose-erp-system-afghanistan')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('چگونه یک سیستم ERP در افغانستان انتخاب کنیم')
            ->assertSee('سناریوی خود را از فروشنده بخواهید')
            ->assertSee('href="'.url('/fa/articles').'"', false);
    }

    public function test_marketing_seeder_does_not_overwrite_content_edited_in_admin(): void
    {
        $this->seed(WebsiteSeeder::class);

        $page = ContentPage::query()->where('slug', 'erp-implementation-services-afghanistan')->firstOrFail();
        $page->update(['title' => ['en' => 'Admin edited service title']]);

        $this->seed(WebsiteSeeder::class);

        $this->assertSame(
            'Admin edited service title',
            ContentPage::query()->where('slug', 'erp-implementation-services-afghanistan')->firstOrFail()->translation('title', 'en'),
        );
    }

    public function test_newly_published_typed_content_appears_in_its_archive(): void
    {
        $this->seed(WebsiteSeeder::class);

        ContentPage::query()->create([
            'type' => 'industry',
            'slug' => 'logistics-software-afghanistan',
            'title' => ['en' => 'Logistics Software in Afghanistan'],
            'summary' => ['en' => 'A verified overview of logistics software workflows.'],
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get('/industries')
            ->assertOk()
            ->assertSee('Logistics Software in Afghanistan')
            ->assertDontSee('No public entries yet.');
    }

    public function test_visitor_can_select_a_persistent_day_or_night_mode(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('data-color-mode-toggle', false)
            ->assertSee("const key = 'fida_color_mode'", false)
            ->assertSee('prefers-color-scheme: light', false)
            ->assertSee('Use day mode');
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
