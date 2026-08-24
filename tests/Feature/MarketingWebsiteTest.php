<?php

namespace Tests\Feature;

use App\Http\Middleware\EnforceCanonicalHost;
use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\ContentPage;
use App\Models\Lead;
use App\Support\DiscoveryPublisher;
use Database\Seeders\EnterpriseAuthoritySeeder;
use Database\Seeders\EnterpriseCoreSeeder;
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
        config()->set('website.indexable', true);
    }

    public function test_homepage_establishes_enterprise_positioning_and_truthful_history(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<html lang="en" dir="ltr"', false)
            ->assertSee('Enterprise Software, ERP &amp; Digital Transformation Afghanistan', false)
            ->assertSee('Enterprise software, ERP &amp;', false)
            ->assertSee('Technology experience since 2014.')
            ->assertSee('Fida operations began in 2022')
            ->assertSee('formally licensed in 2024')
            ->assertDontSee('2027 READY')
            ->assertDontSee('70+')
            ->assertSee('ERP &amp; MIS Systems', false);
    }

    public function test_localized_homepage_uses_rtl_markup(): void
    {
        $this->get('/fa')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('نرم‌افزار سازمانی، ERP و')
            ->assertSee('تجربه تکنالوژی از ۲۰۱۴');
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
            ->assertSee('"@type":"Organization"', false)
            ->assertSee('"@type":"WebSite"', false)
            ->assertSee('"name":"ERP systems in Afghanistan"', false)
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

    public function test_service_detail_uses_cms_profile_and_contextual_conversion_path(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/erp-implementation-services-afghanistan')
            ->assertOk()
            ->assertSee('service-profile-section', false)
            ->assertSee('Confirmed workflow and written scope')
            ->assertSee('Documented handover and agreed support boundaries')
            ->assertSee('?interest=erp-implementation-services-afghanistan#contact', false);

        $this->get('/fa/erp-implementation-services-afghanistan')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('روند تأییدشده و محدوده کتبی');
    }

    public function test_insight_categories_have_localized_archives_schema_and_sitemap_entries(): void
    {
        $this->seed(WebsiteSeeder::class);
        $category = ArticleCategory::query()->where('slug', 'business-software-planning')->firstOrFail();

        $this->get('/articles/category/'.$category->slug)
            ->assertOk()
            ->assertSee('Business Software Planning')
            ->assertSee('How to Choose an ERP System in Afghanistan')
            ->assertSee('"@type":"CollectionPage"', false)
            ->assertSee('"@type":"ItemList"', false);

        $this->get('/fa/articles/category/'.$category->slug)
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('پلان‌گذاری نرم‌افزار تجارتی');

        $this->get('/sitemaps/insights.xml')
            ->assertOk()
            ->assertSee('/articles/category/business-software-planning')
            ->assertSee('/fa/articles/category/business-software-planning');
    }

    public function test_managed_author_drives_the_byline_archive_and_article_schema(): void
    {
        $this->seed(WebsiteSeeder::class);
        $author = ArticleAuthor::query()->create([
            'slug' => 'verified-editor',
            'name' => 'Verified Editor',
            'role' => ['en' => 'Software editor', 'fa' => 'ویرایشگر نرم‌افزار'],
            'bio' => ['en' => 'A verified editorial profile used for this test.'],
            'active' => true,
        ]);
        $article = ContentPage::query()->where('slug', 'how-to-choose-erp-system-afghanistan')->firstOrFail();
        $article->update(['article_author_id' => $author->id]);

        $this->get('/'.$article->slug)
            ->assertOk()
            ->assertSee('Verified Editor')
            ->assertSee('/articles/author/verified-editor', false)
            ->assertSee('"name":"Verified Editor"', false)
            ->assertSee('"articleSection":"Business Software Planning"', false);

        $this->get('/articles/author/verified-editor')
            ->assertOk()
            ->assertSee('Articles by Verified Editor')
            ->assertSee($article->translation('title', 'en'));
    }

    public function test_preferred_internal_links_and_lead_interest_are_preserved(): void
    {
        $this->seed(WebsiteSeeder::class);

        $response = $this->get('/how-to-choose-erp-system-afghanistan');

        $response->assertOk();
        $this->assertSame([
            'erp-implementation-services-afghanistan',
            'erp-systems-afghanistan',
            'products',
        ], $response->viewData('relatedPages')->pluck('slug')->all());

        $this->post('/contact/lead', [
            'name' => 'Ahmad Example',
            'email' => 'ahmad@example.com',
            'project_type' => 'erp',
            'message' => 'We need to review the ERP implementation workflow in detail.',
            'locale' => 'en',
            'source_url' => url('/how-to-choose-erp-system-afghanistan'),
            'interest_slug' => 'erp-implementation-services-afghanistan',
        ])->assertRedirect();

        $this->assertSame('erp-implementation-services-afghanistan', Lead::query()->firstOrFail()->interest_slug);
    }

    public function test_sitemap_contains_seeded_pages_and_localized_alternates(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('/sitemaps/pages.xml')
            ->assertSee('/sitemaps/services.xml')
            ->assertSee('/sitemaps/solutions.xml')
            ->assertSee('/sitemaps/products.xml')
            ->assertSee('/sitemaps/industries.xml')
            ->assertSee('/sitemaps/insights.xml')
            ->assertDontSee('/sitemaps/case-studies.xml');

        $this->get('/sitemaps/solutions.xml')
            ->assertOk()
            ->assertSee('erp-systems-afghanistan')
            ->assertSee('technology-company-afghanistan')
            ->assertSee('hreflang="fa-AF"', false)
            ->assertSee('hreflang="ps-AF"', false)
            ->assertSee('hreflang="x-default"', false);

        $this->get('/sitemaps/products.xml')
            ->assertOk()
            ->assertSee('realist-real-estate-erp')
            ->assertSee('prime-sarafi-software');

        $this->get('/sitemaps/services.xml')
            ->assertOk()
            ->assertSee('erp-implementation-services-afghanistan')
            ->assertDontSee('erp-systems-afghanistan');

        $this->get('/sitemaps/industries.xml')
            ->assertOk()
            ->assertSee('real-estate-construction-software-afghanistan');

        $this->get('/sitemaps/insights.xml')
            ->assertOk()
            ->assertSee('how-to-choose-erp-system-afghanistan')
            ->assertSee('/articles/category/business-software-planning');

        $this->get('/sitemaps/pages.xml')
            ->assertOk()
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
            ->assertDontSee('realist-erp-case-study');

        $this->get('/sitemaps/case-studies.xml')->assertNotFound();
    }

    public function test_sitemap_controls_exclude_private_urls_and_publish_verified_overrides(): void
    {
        $this->seed(WebsiteSeeder::class);

        ContentPage::query()->where('slug', 'erp-systems-afghanistan')->firstOrFail()->update([
            'sitemap_included' => false,
        ]);
        ContentPage::query()->where('slug', 'technology-company-afghanistan')->firstOrFail()->update([
            'robots_directive' => 'noindex,follow,noarchive',
        ]);
        ContentPage::query()->where('slug', 'accounting-software-afghanistan')->firstOrFail()->update([
            'sitemap_priority' => 0.9,
            'sitemap_change_frequency' => 'weekly',
            'sitemap_last_modified_at' => '2026-08-20 12:00:00',
        ]);

        $this->get('/sitemaps/solutions.xml')
            ->assertOk()
            ->assertDontSee('erp-systems-afghanistan')
            ->assertDontSee('technology-company-afghanistan')
            ->assertSee('accounting-software-afghanistan')
            ->assertSee('<priority>0.9</priority>', false)
            ->assertSee('<changefreq>weekly</changefreq>', false)
            ->assertSee('2026-08-20T12:00:00', false);
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

    public function test_navigation_has_clean_labels_single_panel_state_and_compact_home_sections(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('data-nav-cluster-button aria-expanded="false">Solutions<svg', false)
            ->assertSee('<summary>Solutions<i>+</i></summary>', false)
            ->assertDontSee('data-nav-cluster-button aria-expanded="false"><span>', false)
            ->assertDontSee('<span>05</span>Case Studies', false)
            ->assertSee('class="section home-section solutions-section"', false)
            ->assertSee('class="section home-section products-section"', false)
            ->assertSee('class="section home-section industry-section"', false)
            ->assertSee('class="section home-section process-section"', false)
            ->assertSee('class="section contact-section home-section"', false);

        $navigationScript = file_get_contents(resource_path('js/app.js'));
        $stylesheet = file_get_contents(resource_path('css/app.css'));

        $this->assertStringContainsString('closeNavClusters(cluster);', $navigationScript);
        $this->assertStringContainsString("group.addEventListener('toggle'", $navigationScript);
        $this->assertStringContainsString('.nav-cluster.open .nav-cluster-menu', $stylesheet);
        $this->assertStringNotContainsString('.nav-cluster:hover .nav-cluster-menu', $stylesheet);
        $this->assertStringNotContainsString('.nav-cluster:focus-within .nav-cluster-menu', $stylesheet);
        $this->assertStringContainsString('.home-section { padding-block: 112px; }', $stylesheet);
    }

    public function test_about_page_presents_verified_company_history_and_enterprise_authority(): void
    {
        $this->seed(WebsiteSeeder::class);
        $this->seed(EnterpriseAuthoritySeeder::class);

        $about = ContentPage::query()->where('slug', 'about')->firstOrFail();

        $this->assertSame('Fida Technologies Afghanistan', $about->primaryQuery('en'));
        $this->assertSame('navigational', $about->search_intent);

        $this->get('/about')
            ->assertOk()
            ->assertSee('Enterprise technology. Afghan context.')
            ->assertSee('The technology experience behind Fida began in 2014')
            ->assertSee('Fida Technologies began operations in 2022')
            ->assertSee('formally licensed in 2024')
            ->assertSee('Mission and direction')
            ->assertSee('Security, accountability and reliability')
            ->assertSee('Deployment, training and support')
            ->assertSee('WeSoft Technologies')
            ->assertSee('"foundingDate":"2022"', false)
            ->assertSee('"name":"Fida Technologies Afghanistan"', false);

        $this->get('/fa/about')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('تجربه تکنالوژی پشت Fida در سال ۲۰۱۴')
            ->assertSee('فعالیت Fida Technologies در ۲۰۲۲ آغاز شد');

        $this->get('/ps/about')
            ->assertOk()
            ->assertSee('<html lang="ps" dir="rtl"', false)
            ->assertSee('د فیدا تر شا د ټکنالوژۍ تجربه په ۲۰۱۴ کې')
            ->assertSee('د Fida Technologies فعالیت په ۲۰۲۲ کې پیل شو');
    }

    public function test_enterprise_authority_seeder_preserves_an_admin_edited_about_page(): void
    {
        $about = ContentPage::query()->create([
            'type' => 'page',
            'slug' => 'about',
            'title' => ['en' => 'Admin About Title'],
            'body' => ['en' => '<h2>Verified admin content</h2><p>This content must remain unchanged.</p>'],
            'status' => 'published',
        ]);

        $this->seed(WebsiteSeeder::class);
        $this->seed(EnterpriseAuthoritySeeder::class);

        $about->refresh();

        $this->assertSame('Admin About Title', $about->translation('title', 'en'));
        $this->assertStringContainsString('Verified admin content', $about->translation('body', 'en'));
        $this->assertNull($about->primary_query);
    }

    public function test_enterprise_core_pages_are_published_with_distinct_topics_and_buyer_content(): void
    {
        $this->seed(WebsiteSeeder::class);
        $this->seed(EnterpriseCoreSeeder::class);

        $expectedPages = [
            'enterprise-software-afghanistan' => ['solution', 'enterprise software company Afghanistan'],
            'mis-development-afghanistan' => ['service', 'MIS development Afghanistan'],
            'digital-transformation-afghanistan' => ['service', 'digital transformation Afghanistan'],
            'technology-consulting-afghanistan' => ['service', 'technology consulting Afghanistan'],
        ];

        foreach ($expectedPages as $slug => [$type, $primaryQuery]) {
            $page = ContentPage::query()->where('slug', $slug)->firstOrFail();

            $this->assertSame($type, $page->type);
            $this->assertSame('published', $page->status);
            $this->assertSame($primaryQuery, $page->primaryQuery('en'));
            $this->assertTrue($page->sitemap_included);
        }

        $this->get('/enterprise-software-afghanistan')
            ->assertOk()
            ->assertSee('<h1>Enterprise Software Company in Afghanistan</h1>', false)
            ->assertSee('Enterprise software connects responsibility, data and decisions')
            ->assertSee('From requirements to accountable delivery')
            ->assertSee('How is enterprise software priced?')
            ->assertSee('?interest=enterprise-software-afghanistan#contact', false)
            ->assertSee('"@type":"Service"', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('"name":"enterprise software company Afghanistan"', false);

        $this->get('/mis-development-afghanistan')
            ->assertOk()
            ->assertSee('service-profile-section', false)
            ->assertSee('Data governance comes before the dashboard')
            ->assertSee('MIS, ERP or both?')
            ->assertSee('Data, indicator and workflow discovery')
            ->assertSee('"@type":"Service"', false);

        $this->get('/digital-transformation-afghanistan')
            ->assertOk()
            ->assertSee('Digital transformation is an operating change, not a software purchase')
            ->assertSee('Measure only what has a baseline')
            ->assertSee('Phased delivery');

        $this->get('/technology-consulting-afghanistan')
            ->assertOk()
            ->assertSee('Technology decisions should be traceable to business requirements')
            ->assertSee('Because Fida also develops software')
            ->assertSee('RFP and vendor questions');
    }

    public function test_enterprise_core_pages_are_localized_grouped_in_sitemaps_and_preserve_admin_content(): void
    {
        $adminPage = ContentPage::query()->create([
            'type' => 'service',
            'slug' => 'technology-consulting-afghanistan',
            'title' => ['en' => 'Admin consulting title'],
            'body' => ['en' => '<h2>Verified admin consulting content</h2>'],
            'status' => 'published',
        ]);

        $this->seed(WebsiteSeeder::class);
        $this->seed(EnterpriseCoreSeeder::class);

        $adminPage->refresh();
        $this->assertSame('Admin consulting title', $adminPage->translation('title', 'en'));
        $this->assertStringContainsString('Verified admin consulting content', $adminPage->translation('body', 'en'));
        $this->assertSame(1, ContentPage::query()->where('slug', 'technology-consulting-afghanistan')->count());

        $this->get('/fa/digital-transformation-afghanistan')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('تحول دیجیتال در افغانستان')
            ->assertSee('تحول دیجیتال تغییر عملیات است، نه خرید نرم‌افزار');

        $this->get('/ps/mis-development-afghanistan')
            ->assertOk()
            ->assertSee('<html lang="ps" dir="rtl"', false)
            ->assertSee('په افغانستان کې د مدیریت معلوماتي MIS سیسټم جوړول')
            ->assertSee('د ډشبورډ تر مخه د معلوماتو حاکمیت');

        $this->get('/sitemaps/solutions.xml')
            ->assertOk()
            ->assertSee('enterprise-software-afghanistan')
            ->assertDontSee('mis-development-afghanistan');

        $this->get('/sitemaps/services.xml')
            ->assertOk()
            ->assertSee('mis-development-afghanistan')
            ->assertSee('digital-transformation-afghanistan')
            ->assertDontSee('enterprise-software-afghanistan');
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
            ->assertSee('"name":"software company in Afghanistan"', false)
            ->assertSee('"knowsAbout"', false);
    }

    public function test_page_discovery_controls_drive_public_metadata_and_schema(): void
    {
        $this->seed(WebsiteSeeder::class);
        config()->set('website.indexable', true);

        ContentPage::query()->where('slug', 'erp-systems-afghanistan')->firstOrFail()->update([
            'robots_directive' => 'noindex,follow,noarchive',
            'social_image_url' => 'https://fida.af/media/erp-afghanistan-social.jpg',
            'author_name' => 'Fida Technologies',
            'reviewer_name' => 'Fida Editorial Team',
            'reviewed_at' => now(),
        ]);

        $this->get('/erp-systems-afghanistan')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,follow,noarchive">', false)
            ->assertSee('<meta property="og:image" content="https://fida.af/media/erp-afghanistan-social.jpg">', false)
            ->assertSee('<meta name="author" content="Fida Technologies">', false)
            ->assertSee('"primaryImageOfPage"', false)
            ->assertSee('"reviewedBy"', false)
            ->assertSee('"lastReviewed"', false);
    }

    public function test_automatic_discovery_builds_current_and_previous_localized_urls(): void
    {
        $page = new ContentPage(['slug' => 'erp-platform-afghanistan']);
        $urls = app(DiscoveryPublisher::class)->urlsFor($page, 'erp-systems-afghanistan');

        $this->assertSame([
            url('/erp-platform-afghanistan'),
            url('/erp-systems-afghanistan'),
            url('/fa/erp-platform-afghanistan'),
            url('/fa/erp-systems-afghanistan'),
            url('/ps/erp-platform-afghanistan'),
            url('/ps/erp-systems-afghanistan'),
        ], $urls);
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
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive')
            ->assertSee('name="robots" content="noindex,nofollow,noarchive"', false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee("User-agent: *\nDisallow: /")
            ->assertDontSee('Sitemap:');

        $this->get('/sitemap.xml')
            ->assertNotFound()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');

        $this->get('/sitemaps/pages.xml')
            ->assertNotFound()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');

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

    public function test_software_company_keyword_cluster_has_distinct_topics_and_useful_content(): void
    {
        $this->seed(WebsiteSeeder::class);

        $customSoftware = ContentPage::query()
            ->where('slug', 'custom-software-development-afghanistan')
            ->firstOrFail();
        $technologyCompany = ContentPage::query()
            ->where('slug', 'technology-company-afghanistan')
            ->firstOrFail();

        $this->assertSame('custom software development in Afghanistan', $customSoftware->primaryQuery('en'));
        $this->assertSame('commercial', $customSoftware->search_intent);
        $this->assertSame('technology company in Afghanistan', $technologyCompany->primaryQuery('en'));
        $this->assertSame('local', $technologyCompany->search_intent);

        $this->get('/custom-software-development-afghanistan')
            ->assertOk()
            ->assertSee('Custom software should fit the business')
            ->assertSee('Designed for practical operations in Afghanistan')
            ->assertSee('From discovery to deployment')
            ->assertSee('How to request a useful estimate')
            ->assertSee('"name":"custom software development in Afghanistan"', false)
            ->assertSee('"@type":"Service"', false);

        $this->get('/technology-company-afghanistan')
            ->assertOk()
            ->assertSee('Technology built around real Afghan business workflows')
            ->assertSee('"name":"technology company in Afghanistan"', false);

        $this->get('/fa/custom-software-development-afghanistan')
            ->assertOk()
            ->assertSee('<html lang="fa" dir="rtl"', false)
            ->assertSee('نرم‌افزار اختصاصی باید با تجارت هماهنگ باشد')
            ->assertSee('از شناخت تا راه‌اندازی');
    }

    public function test_discovery_content_migration_backfills_defaults_without_overwriting_admin_topics(): void
    {
        $customSoftware = ContentPage::query()->create([
            'type' => 'solution',
            'slug' => 'custom-software-development-afghanistan',
            'title' => ['en' => 'Custom Software Development in Afghanistan'],
            'body' => [
                'en' => '<h2>Software should fit the business</h2><p>We analyze your operation, simplify the workflow and develop a maintainable system with clear permissions, auditability and reporting.</p>',
                'fa' => '<h2>نرم‌افزار باید با تجارت هماهنگ باشد</h2><p>عملیات شما را تحلیل، روند را ساده و یک سیستم قابل توسعه با صلاحیت‌ها، ثبت فعالیت و گزارش‌دهی روشن می‌سازیم.</p>',
                'ps' => '<h2>سافټویر باید له سوداګرۍ سره برابر وي</h2><p>ستاسو عملیات څېړو، کاري بهیر ساده کوو او د روښانه صلاحیتونو، ثبت او راپورونو لرونکی سیسټم جوړوو.</p>',
            ],
            'status' => 'published',
        ]);

        $technologyCompany = ContentPage::query()->create([
            'type' => 'solution',
            'slug' => 'technology-company-afghanistan',
            'title' => ['en' => 'Technology Company in Afghanistan'],
            'primary_query' => ['en' => 'Admin-selected technology topic'],
            'search_intent' => 'commercial',
            'status' => 'published',
        ]);

        $migration = require database_path('migrations/2026_08_23_000006_enrich_software_company_discovery_pages.php');
        $migration->up();

        $customSoftware->refresh();
        $technologyCompany->refresh();

        $this->assertSame('custom software development in Afghanistan', $customSoftware->primaryQuery('en'));
        $this->assertSame('commercial', $customSoftware->search_intent);
        $this->assertStringContainsString('From discovery to deployment', $customSoftware->translation('body', 'en'));
        $this->assertSame('Admin-selected technology topic', $technologyCompany->primaryQuery('en'));
        $this->assertSame('commercial', $technologyCompany->search_intent);
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
