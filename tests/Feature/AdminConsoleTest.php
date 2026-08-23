<?php

namespace Tests\Feature;

use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\ContentPage;
use App\Models\Lead;
use App\Models\PageRedirect;
use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\WebsiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminConsoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_guest_is_sent_to_the_secure_admin_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->get('/admin/login')->assertOk()->assertSee('Welcome back.');
    }

    public function test_active_administrator_can_login_and_logout(): void
    {
        $admin = User::factory()->admin()->create(['password' => 'SecurePassword123']);

        $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'SecurePassword123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
        $this->assertNotNull($admin->fresh()->last_login_at);

        $this->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_inactive_or_non_admin_accounts_cannot_login(): void
    {
        $inactive = User::factory()->admin()->inactive()->create(['password' => 'SecurePassword123']);
        $publicUser = User::factory()->create(['password' => 'SecurePassword123']);

        foreach ([$inactive, $publicUser] as $user) {
            $this->post('/admin/login', [
                'email' => $user->email,
                'password' => 'SecurePassword123',
            ])->assertSessionHasErrors('email');

            $this->assertGuest();
        }
    }

    public function test_content_editor_can_manage_pages_but_not_leads(): void
    {
        $editor = User::factory()->admin('editor')->create();

        $response = $this->actingAs($editor)->post(route('admin.content-pages.store'), $this->pagePayload());

        $page = ContentPage::query()->firstOrFail();
        $response->assertRedirect(route('admin.content-pages.edit', $page));
        $this->assertSame('ERP Consulting Afghanistan', $page->title['en']);
        $this->assertSame('What is ERP consulting?', $page->metadata['faqs'][0]['question']['en']);
        $this->assertSame('ERP consulting in Afghanistan', $page->primary_query['en']);
        $this->assertSame('commercial', $page->search_intent);
        $this->assertNotNull($page->published_at);

        $this->actingAs($editor)->get(route('admin.leads.index'))->assertForbidden();
        $this->actingAs($editor)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_editor_manages_insight_taxonomies_and_article_publication_state(): void
    {
        $editor = User::factory()->admin('editor')->create();

        $this->actingAs($editor)->post(route('admin.article-categories.store'), [
            'slug' => 'software-security',
            'name' => ['en' => 'Software Security', 'fa' => 'امنیت نرم‌افزار', 'ps' => 'د سافټویر امنیت'],
            'description' => ['en' => 'Verified software security guidance.'],
            'meta_title' => ['en' => 'Software Security Insights | Fida'],
            'meta_description' => ['en' => 'Verified software security guidance from Fida Technologies.'],
            'active' => '1',
            'sort_order' => 30,
        ])->assertRedirect();
        $category = ArticleCategory::query()->where('slug', 'software-security')->firstOrFail();

        $this->actingAs($editor)->post(route('admin.article-authors.store'), [
            'slug' => 'verified-author',
            'name' => 'Verified Author',
            'role' => ['en' => 'Technical editor'],
            'bio' => ['en' => 'Verified public biography.'],
            'active' => '1',
            'sort_order' => 10,
        ])->assertRedirect();
        $author = ArticleAuthor::query()->where('slug', 'verified-author')->firstOrFail();

        $payload = $this->pagePayload();
        $payload['type'] = 'article';
        $payload['slug'] = 'secure-software-planning';
        $payload['title']['en'] = 'Secure Software Planning';
        $payload['article_category_id'] = $category->id;
        $payload['article_author_id'] = $author->id;
        $payload['status'] = 'review';
        $payload['published_at'] = now()->addDay()->format('Y-m-d H:i:s');

        $this->actingAs($editor)->post(route('admin.content-pages.store'), $payload)->assertRedirect();
        $article = ContentPage::query()->where('slug', 'secure-software-planning')->firstOrFail();

        $this->assertTrue($article->articleCategory->is($category));
        $this->assertTrue($article->articleAuthor->is($author));
        $this->get('/secure-software-planning')->assertNotFound();

        $article->update(['status' => 'published']);
        $this->assertSame('scheduled', $article->fresh()->publicationStatus());
        $this->get('/secure-software-planning')->assertNotFound();
    }

    public function test_sales_manager_can_update_leads_but_not_content(): void
    {
        $sales = User::factory()->admin('sales')->create();
        $lead = $this->lead();

        $this->actingAs($sales)
            ->put(route('admin.leads.update', $lead), [
                'status' => 'qualified',
                'assigned_to' => $sales->id,
            ])
            ->assertRedirect();

        $lead->refresh();
        $this->assertSame('qualified', $lead->status);
        $this->assertTrue($lead->assignee->is($sales));
        $this->assertNotNull($lead->contacted_at);

        $this->actingAs($sales)->get(route('admin.content-pages.index'))->assertForbidden();
    }

    public function test_super_administrator_can_manage_team_access(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'Fida Editor',
                'email' => 'editor@fida.af',
                'role' => 'editor',
                'active' => '1',
                'password' => 'StrongEditor123',
                'password_confirmation' => 'StrongEditor123',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => 'editor@fida.af',
            'role' => 'editor',
            'active' => true,
        ]);
    }

    public function test_only_super_administrator_can_open_website_settings(): void
    {
        $admin = User::factory()->admin()->create();
        $editor = User::factory()->admin('editor')->create();

        $this->actingAs($admin)
            ->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertSee('Your identity, from one place.')
            ->assertSee('Fida lime');

        $this->actingAs($editor)
            ->get(route('admin.settings.edit'))
            ->assertForbidden();
    }

    public function test_super_administrator_can_update_public_identity_and_theme(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.settings.update'), $this->settingsPayload())
            ->assertRedirect();

        $this->assertDatabaseCount('site_settings', 3);
        $this->assertSame(
            'Fida Technology Group',
            SiteSetting::query()->where('key', 'website.general')->firstOrFail()->value['company_name'],
        );

        $this->get('/')
            ->assertOk()
            ->assertSee('Fida Technology Group')
            ->assertSee('hello@fida.af')
            ->assertSee('--ink:#050914', false)
            ->assertSee('--lime:#55a7ff', false)
            ->assertSee('theme-deep_navy palette-electric', false);
    }

    public function test_website_settings_reject_unsafe_map_provider(): void
    {
        $admin = User::factory()->admin()->create();
        $payload = $this->settingsPayload();
        $payload['map_embed_url'] = 'https://example.com/embed/map';

        $this->actingAs($admin)
            ->put(route('admin.settings.update'), $payload)
            ->assertSessionHasErrors('map_embed_url');

        $this->assertDatabaseCount('site_settings', 0);
    }

    public function test_content_body_rejects_executable_html(): void
    {
        $editor = User::factory()->admin('editor')->create();
        $payload = $this->pagePayload();
        $payload['body']['en'] = '<script>alert(1)</script>';

        $this->actingAs($editor)
            ->post(route('admin.content-pages.store'), $payload)
            ->assertSessionHasErrors('body.en');

        $this->assertDatabaseCount('content_pages', 0);
    }

    public function test_editor_can_browse_every_content_type_from_the_library(): void
    {
        $editor = User::factory()->admin('editor')->create();
        $this->seed(WebsiteSeeder::class);

        $this->actingAs($editor)
            ->get(route('admin.content-pages.index'))
            ->assertOk()
            ->assertSee('Every story, one publishing system.')
            ->assertSee('Solutions')
            ->assertSee('Services')
            ->assertSee('Products')
            ->assertSee('Industries')
            ->assertSee('Case studies')
            ->assertSee('Articles')
            ->assertSee('Pages');

        $this->actingAs($editor)
            ->get(route('admin.content-pages.index', ['type' => 'case-study']))
            ->assertOk()
            ->assertSee('Case studies built to be found.')
            ->assertSee('Realist ERP case study');
    }

    public function test_type_specific_create_link_prefills_the_editor(): void
    {
        $editor = User::factory()->admin('editor')->create();

        $this->actingAs($editor)
            ->get(route('admin.content-pages.create', ['type' => 'article']))
            ->assertOk()
            ->assertSee('New Article')
            ->assertSee('<option value="article" selected>Article</option>', false);
    }

    public function test_editor_can_review_page_discovery_readiness(): void
    {
        $editor = User::factory()->admin('editor')->create();
        $response = $this->actingAs($editor)->post(route('admin.content-pages.store'), $this->pagePayload());
        $page = ContentPage::query()->firstOrFail();

        $response->assertRedirect(route('admin.content-pages.edit', $page));

        $this->actingAs($editor)
            ->get(route('admin.content-pages.edit', $page))
            ->assertOk()
            ->assertSee('Search, answer and generative discovery')
            ->assertSee('DISCOVERY READINESS')
            ->assertSee('ERP consulting in Afghanistan')
            ->assertSee('Planning field only—never printed as a meta-keywords tag.');
    }

    public function test_slug_changes_create_direct_multilingual_redirects(): void
    {
        $editor = User::factory()->admin('editor')->create();
        $this->actingAs($editor)->post(route('admin.content-pages.store'), $this->pagePayload());
        $page = ContentPage::query()->firstOrFail();
        $payload = $this->pagePayload();
        $payload['slug'] = 'erp-advisory-afghanistan';

        $this->actingAs($editor)
            ->put(route('admin.content-pages.update', $page), $payload)
            ->assertRedirect();

        $this->assertDatabaseCount('page_redirects', 3);
        $this->assertDatabaseHas('page_redirects', [
            'source_path' => '/erp-consulting-afghanistan',
            'target_path' => '/erp-advisory-afghanistan',
            'status_code' => 301,
        ]);
        $this->assertDatabaseHas('page_redirects', [
            'source_path' => '/fa/erp-consulting-afghanistan',
            'target_path' => '/fa/erp-advisory-afghanistan',
        ]);

        $this->get('/erp-consulting-afghanistan?utm_source=legacy')
            ->assertRedirect(url('/erp-advisory-afghanistan').'?utm_source=legacy');

        $this->get('/fa/erp-consulting-afghanistan')
            ->assertRedirect(url('/fa/erp-advisory-afghanistan'));

        $this->assertSame(1, PageRedirect::query()->where('source_path', '/erp-consulting-afghanistan')->value('hits'));
    }

    public function test_redirect_manager_rejects_loops_and_protects_admin_paths(): void
    {
        $editor = User::factory()->admin('editor')->create();

        $this->actingAs($editor)->post(route('admin.redirects.store'), [
            'source_path' => '/old-erp',
            'target_path' => '/new-erp',
            'status_code' => 301,
            'active' => 1,
        ])->assertRedirect();

        $this->actingAs($editor)->post(route('admin.redirects.store'), [
            'source_path' => '/new-erp',
            'target_path' => '/old-erp',
            'status_code' => 301,
            'active' => 1,
        ])->assertSessionHasErrors('target_path');

        $this->actingAs($editor)->post(route('admin.redirects.store'), [
            'source_path' => '/admin/login',
            'target_path' => '/contact',
            'status_code' => 301,
            'active' => 1,
        ])->assertSessionHasErrors('source_path');

        $this->assertDatabaseCount('page_redirects', 1);
    }

    private function pagePayload(): array
    {
        return [
            'type' => 'solution',
            'slug' => 'erp-consulting-afghanistan',
            'title' => ['en' => 'ERP Consulting Afghanistan', 'fa' => 'مشاوره ERP افغانستان', 'ps' => 'د ERP مشوره افغانستان'],
            'eyebrow' => ['en' => 'Connected operations'],
            'summary' => ['en' => 'A practical ERP consulting service for growing Afghan companies.'],
            'body' => ['en' => '<h2>Build the right operating system</h2><p>Start with the workflow.</p>'],
            'meta_title' => ['en' => 'ERP Consulting Afghanistan | Fida'],
            'meta_description' => ['en' => 'ERP consulting and implementation for companies in Afghanistan.'],
            'primary_query' => ['en' => 'ERP consulting in Afghanistan', 'fa' => 'مشاوره ERP در افغانستان', 'ps' => 'په افغانستان کې د ERP مشوره'],
            'search_intent' => 'commercial',
            'robots_directive' => 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
            'social_image_url' => 'https://fida.af/media/erp-consulting.jpg',
            'author_name' => 'Fida Technologies',
            'reviewer_name' => 'Fida Editorial Team',
            'reviewed_at' => now()->format('Y-m-d H:i:s'),
            'metadata' => ['faqs' => [[
                'question' => ['en' => 'What is ERP consulting?'],
                'answer' => ['en' => 'It maps business workflows and turns them into a practical ERP implementation plan.'],
            ]]],
            'status' => 'published',
            'featured' => '1',
            'sort_order' => 1,
            'published_at' => null,
        ];
    }

    private function settingsPayload(): array
    {
        return [
            'company_name' => 'Fida Technology Group',
            'legal_name' => 'Fida Technologies & Marketing Services',
            'email' => 'hello@fida.af',
            'phone' => '+93 784 006 200',
            'whatsapp' => '93784006200',
            'address_line' => 'Technology District',
            'city' => 'Kabul',
            'country' => 'Afghanistan',
            'country_code' => 'AF',
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=test',
            'brand_name' => 'Fida',
            'brand_tagline' => 'Technology Group',
            'remove_logo' => '0',
            'theme' => 'deep_navy',
            'palette' => 'electric',
            'primary_color' => '#55a7ff',
            'secondary_color' => '#725cff',
            'highlight_color' => '#54f4dc',
        ];
    }

    private function lead(): Lead
    {
        return Lead::query()->create([
            'name' => 'Ahmad Example',
            'email' => 'ahmad@example.com',
            'phone' => '+93700000000',
            'company' => 'Example Trading',
            'project_type' => 'erp',
            'message' => 'We need an ERP system for several company branches.',
            'locale' => 'en',
            'status' => 'new',
        ]);
    }
}
