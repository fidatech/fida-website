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
use Illuminate\Support\Facades\Crypt;
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
        $this->assertSame('Invite us to tender', $page->metadata['cta']['primary_label']['en']);
        $this->assertSame('tender', $page->metadata['cta']['primary_intent']);
        $this->assertSame('company-profile', $page->metadata['cta']['secondary_intent']);
        $this->assertSame('commercial', $page->search_intent);
        $this->assertTrue($page->sitemap_included);
        $this->assertSame('0.9', $page->sitemap_priority);
        $this->assertSame('weekly', $page->sitemap_change_frequency);
        $this->assertNotNull($page->published_at);

        $this->actingAs($editor)->get(route('admin.leads.index'))->assertForbidden();
        $this->actingAs($editor)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_editor_can_open_auto_articles_with_generated_history(): void
    {
        $editor = User::factory()->admin('editor')->create();

        ContentPage::query()->create([
            'type' => 'article',
            'slug' => 'generated-admin-history-test',
            'title' => ['en' => 'Generated history test'],
            'eyebrow' => ['en' => 'Fida Answers'],
            'summary' => ['en' => 'A generated article used to verify the automation console.'],
            'body' => ['en' => '<p>Generated content.</p>'],
            'meta_title' => ['en' => 'Generated history test | Fida'],
            'meta_description' => ['en' => 'Generated article history regression test.'],
            'primary_query' => ['en' => 'generated article test'],
            'search_intent' => 'informational',
            'robots_directive' => config('website.discovery.default_robots'),
            'sitemap_included' => true,
            'sitemap_priority' => 0.7,
            'sitemap_change_frequency' => 'monthly',
            'metadata' => ['automation' => ['generated' => true]],
            'status' => 'published',
            'featured' => false,
            'sort_order' => 100,
            'published_at' => now(),
        ]);

        $this->actingAs($editor)
            ->get(route('admin.auto-articles.index'))
            ->assertOk()
            ->assertSee('Generate useful drafts on schedule.')
            ->assertSee('Generated history test')
            ->assertSee('09:00');
    }

    public function test_automated_article_cannot_publish_without_human_quality_review(): void
    {
        $editor = User::factory()->admin('editor')->create();
        $bodyEn = '<h2>Decision context</h2><p>'.str_repeat('practical guidance for business software selection ', 250).'</p><h2>Implementation checklist</h2><ul><li>Review workflow ownership</li></ul>';
        $bodyFa = '<h2>زمینه تصمیم</h2><p>'.str_repeat('راهنمای عملی برای انتخاب سیستم و بررسی نیازهای واقعی کسب و کار ', 180).'</p><h2>چک‌لیست تطبیق</h2><ul><li>مسئولیت جریان کاری را بررسی کنید</li></ul>';
        $bodyPs = '<h2>د پرېکړې زمینه</h2><p>'.str_repeat('د سوداګرۍ د سیسټم د انتخاب او رښتینو اړتیاوو لپاره عملي لارښود ', 180).'</p><h2>د پلي کولو لست</h2><ul><li>د کاري بهیر مسؤلیت وڅېړئ</li></ul>';

        $page = ContentPage::query()->create([
            'type' => 'article',
            'slug' => 'review-gated-ai-article',
            'title' => ['en' => 'Review gated AI article', 'fa' => 'مقاله نیازمند بازبینی', 'ps' => 'د بیاکتنې مقاله'],
            'eyebrow' => ['en' => 'Fida Answers', 'fa' => 'پاسخ‌های فدا', 'ps' => 'د فدا ځوابونه'],
            'summary' => ['en' => str_repeat('Useful buyer guidance. ', 8), 'fa' => str_repeat('راهنمای مفید برای خریدار. ', 8), 'ps' => str_repeat('د پېرودونکي لپاره ګټور لارښود. ', 8)],
            'body' => ['en' => $bodyEn, 'fa' => $bodyFa, 'ps' => $bodyPs],
            'meta_title' => ['en' => 'Review Gated AI Article | Fida', 'fa' => 'مقاله بازبینی‌شده فدا', 'ps' => 'د فدا بیاکتل شوې مقاله'],
            'meta_description' => ['en' => str_repeat('Practical guidance for reviewing software decisions. ', 2), 'fa' => str_repeat('راهنمای عملی برای بازبینی تصمیم‌های نرم‌افزاری. ', 2), 'ps' => str_repeat('د سافټویر پرېکړو د بیاکتنې لپاره عملي لارښود. ', 2)],
            'primary_query' => ['en' => 'review gated software article', 'fa' => 'مقاله بازبینی نرم افزار', 'ps' => 'د سافټویر بیاکتنې مقاله'],
            'search_intent' => 'informational',
            'robots_directive' => config('website.discovery.default_robots'),
            'sitemap_included' => true,
            'sitemap_priority' => 0.7,
            'sitemap_change_frequency' => 'monthly',
            'metadata' => ['automation' => ['generated' => true]],
            'status' => 'review',
            'featured' => false,
            'sort_order' => 100,
        ]);

        $payload = [
            'type' => 'article',
            'slug' => $page->slug,
            'title' => $page->title,
            'eyebrow' => $page->eyebrow,
            'summary' => $page->summary,
            'body' => $page->body,
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'primary_query' => $page->primary_query,
            'search_intent' => 'informational',
            'robots_directive' => config('website.discovery.default_robots'),
            'sitemap_included' => '1',
            'sitemap_priority' => '0.7',
            'sitemap_change_frequency' => 'monthly',
            'author_name' => 'Fida Editorial Team',
            'reviewer_name' => 'Fida Reviewer',
            'reviewed_at' => now()->format('Y-m-d H:i:s'),
            'status' => 'published',
            'featured' => '0',
            'sort_order' => 100,
        ];

        $this->actingAs($editor)
            ->put(route('admin.content-pages.update', $page), $payload)
            ->assertSessionHasErrors([
                'metadata.automation.editorial_reviewed',
                'metadata.automation.fact_checked',
                'metadata.automation.translations_reviewed',
            ]);

        $payload['metadata']['automation'] = [
            'editorial_reviewed' => '1',
            'fact_checked' => '1',
            'translations_reviewed' => '1',
        ];

        $this->actingAs($editor)
            ->put(route('admin.content-pages.update', $page), $payload)
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $page->refresh();
        $this->assertSame('published', $page->status);
        $this->assertTrue((bool) data_get($page->metadata, 'automation.editorial_reviewed'));
        $this->assertNotEmpty(data_get($page->metadata, 'automation.reviewed_content_hash'));
    }

    public function test_auto_article_settings_never_enable_autonomous_publishing(): void
    {
        SiteSetting::query()->create([
            'key' => 'content.automation',
            'group' => 'content',
            'value' => [
                'enabled' => true,
                'auto_publish' => true,
                'daily_time' => '09:00',
                'timezone' => 'Asia/Kabul',
            ],
            'type' => 'json',
            'is_public' => false,
        ]);

        $settings = app(\App\Services\AutoArticleService::class)->settings();

        $this->assertTrue($settings['enabled']);
        $this->assertFalse($settings['auto_publish']);
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

        $this->assertDatabaseCount('site_settings', 5);
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


    public function test_super_administrator_can_store_ai_provider_key_encrypted(): void
    {
        $admin = User::factory()->admin()->create();
        $payload = $this->settingsPayload();
        $payload['ai_provider'] = 'gemini';
        $payload['ai_model'] = 'gemini-3.8-flash';
        $payload['ai_api_key'] = 'test-secret-api-key';
        $payload['remove_ai_api_key'] = '0';

        $this->actingAs($admin)
            ->put(route('admin.settings.update'), $payload)
            ->assertRedirect();

        $value = SiteSetting::query()->where('key', 'analytics.ai')->firstOrFail()->value;

        $this->assertSame('gemini', $value['provider']);
        $this->assertSame('gemini-3.8-flash', $value['model']);
        $this->assertNotSame('test-secret-api-key', $value['api_key']);
        $this->assertSame('test-secret-api-key', Crypt::decryptString($value['api_key']));
    }

    public function test_openai_growth_advisor_can_be_saved_with_blank_model(): void
    {
        $admin = User::factory()->admin()->create();
        $payload = $this->settingsPayload();
        $payload['ai_provider'] = 'openai';
        $payload['ai_model'] = '';
        $payload['ai_api_key'] = 'test-openai-key';
        $payload['remove_ai_api_key'] = '0';

        $this->actingAs($admin)
            ->put(route('admin.settings.update'), $payload)
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $value = SiteSetting::query()->where('key', 'analytics.ai')->firstOrFail()->value;

        $this->assertSame('openai', $value['provider']);
        $this->assertSame('', $value['model']);
        $this->assertSame('test-openai-key', Crypt::decryptString($value['api_key']));
    }

    public function test_admin_appearance_autosaves_without_changing_public_theme(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->put(route('admin.settings.update'), $this->settingsPayload())
            ->assertRedirect();

        $this->actingAs($admin)
            ->patchJson(route('admin.settings.admin-appearance'), [
                'theme' => 'obsidian',
                'palette' => 'royal',
            ])
            ->assertOk()
            ->assertJson([
                'ok' => true,
                'theme' => 'obsidian',
                'palette' => 'royal',
            ]);

        $appearance = SiteSetting::query()->where('key', 'website.appearance')->firstOrFail()->value;

        $this->assertSame('deep_navy', $appearance['theme']);
        $this->assertSame('electric', $appearance['palette']);
        $this->assertSame('obsidian', $appearance['admin_theme']);
        $this->assertSame('royal', $appearance['admin_palette']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('--admin-bg:#050506', false)
            ->assertSee('--admin-lime:#a78bfa', false);

        $this->get('/')
            ->assertOk()
            ->assertSee('theme-deep_navy palette-electric', false);
    }

    public function test_admin_light_theme_can_be_selected_and_persisted(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patchJson(route('admin.settings.admin-appearance'), [
                'theme' => 'light',
                'palette' => 'electric',
            ])
            ->assertOk()
            ->assertJson([
                'ok' => true,
                'theme' => 'light',
                'palette' => 'electric',
            ]);

        $appearance = SiteSetting::query()->where('key', 'website.appearance')->firstOrFail()->value;

        $this->assertSame('light', $appearance['admin_theme']);
        $this->assertSame('electric', $appearance['admin_palette']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('data-admin-theme="light"', false)
            ->assertSee('--admin-bg:#f5f7fb', false);
    }

    public function test_website_settings_accept_google_maps_output_embed_url(): void
    {
        $admin = User::factory()->admin()->create();
        $payload = $this->settingsPayload();
        $payload['map_embed_url'] = 'https://www.google.com/maps?q=34.5143264,69.1840542&z=17&output=embed';

        $this->actingAs($admin)
            ->put(route('admin.settings.update'), $payload)
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $stored = SiteSetting::query()->where('key', 'website.general')->firstOrFail()->value;

        $this->assertSame(
            'https://www.google.com/maps?q=34.5143264,69.1840542&z=17&output=embed',
            $stored['map_embed_url'],
        );
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

    public function test_case_study_publication_requires_complete_evidence_and_client_approval(): void
    {
        $editor = User::factory()->admin('editor')->create();
        $payload = $this->pagePayload();
        $payload['type'] = 'case-study';
        $payload['slug'] = 'verified-implementation-case-study';
        $payload['title'] = [
            'en' => 'Verified implementation case study',
            'fa' => 'مطالعه موردی تطبیق تأییدشده',
            'ps' => 'د تایید شوې پلي کېدو قضیوي مطالعه',
        ];

        $this->actingAs($editor)
            ->post(route('admin.content-pages.store'), $payload)
            ->assertSessionHasErrors([
                'metadata.case_study.client_identity_confirmed',
                'metadata.case_study.approval_reference',
                'summary.fa',
                'body.ps',
            ]);

        $this->assertDatabaseMissing('content_pages', ['slug' => 'verified-implementation-case-study']);

        foreach (['summary', 'body', 'meta_title', 'meta_description'] as $field) {
            $payload[$field]['fa'] = $payload[$field]['en'].' FA';
            $payload[$field]['ps'] = $payload[$field]['en'].' PS';
        }

        $payload['metadata']['case_study'] = collect(ContentPage::CASE_STUDY_EVIDENCE_CHECKS)
            ->mapWithKeys(fn (string $label, string $key): array => [$key => '1'])
            ->merge([
                'evidence_owner' => 'Fida Delivery Lead',
                'approval_reference' => 'CLIENT-APPROVAL-2026-001',
                'approved_at' => '2026-08-29',
            ])
            ->all();

        $response = $this->actingAs($editor)->post(route('admin.content-pages.store'), $payload);
        $caseStudy = ContentPage::query()->where('slug', 'verified-implementation-case-study')->firstOrFail();

        $response->assertRedirect(route('admin.content-pages.edit', $caseStudy));
        $this->assertTrue($caseStudy->caseStudyPublicationApproved());
        $this->assertTrue((bool) data_get($caseStudy->metadata, 'case_study.publication_approved'));
        $this->assertTrue(ContentPage::published()->whereKey($caseStudy)->exists());
        $this->get('/verified-implementation-case-study')->assertOk();

        $payload['body']['en'] = '<h2>Revised implementation account</h2><p>This public copy now requires renewed client approval.</p>';
        $this->actingAs($editor)
            ->put(route('admin.content-pages.update', $caseStudy), $payload)
            ->assertRedirect();

        $caseStudy->refresh();
        $this->assertSame('review', $caseStudy->status);
        $this->assertFalse($caseStudy->caseStudyPublicationApproved());
        $this->assertFalse((bool) data_get($caseStudy->metadata, 'case_study.final_client_approval_recorded'));
        $this->get('/verified-implementation-case-study')->assertNotFound();
    }

    public function test_case_study_editor_explains_the_evidence_gate(): void
    {
        $editor = User::factory()->admin('editor')->create();

        $this->actingAs($editor)
            ->get(route('admin.content-pages.create', ['type' => 'case-study']))
            ->assertOk()
            ->assertSee('Case-study evidence and client approval')
            ->assertSee('Written permission to publish is retained.')
            ->assertSee('Approval reference')
            ->assertSee('0 of 6 evidence checks recorded');
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
            ->assertSee('Include in the appropriate XML sitemap')
            ->assertSee('DISCOVERY READINESS')
            ->assertSee('ERP consulting in Afghanistan')
            ->assertSee('Contextual call to action')
            ->assertSee('FAQ 06')
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
            'sitemap_included' => '1',
            'sitemap_priority' => '0.9',
            'sitemap_change_frequency' => 'weekly',
            'sitemap_last_modified_at' => null,
            'social_image_url' => 'https://fida.af/media/erp-consulting.jpg',
            'author_name' => 'Fida Technologies',
            'reviewer_name' => 'Fida Editorial Team',
            'reviewed_at' => now()->format('Y-m-d H:i:s'),
            'metadata' => [
                'faqs' => [[
                    'question' => ['en' => 'What is ERP consulting?'],
                    'answer' => ['en' => 'It maps business workflows and turns them into a practical ERP implementation plan.'],
                ]],
                'cta' => [
                    'heading' => ['en' => 'Discuss the procurement'],
                    'description' => ['en' => 'Send the approved request and deadline.'],
                    'primary_label' => ['en' => 'Invite us to tender'],
                    'primary_intent' => 'tender',
                    'secondary_label' => ['en' => 'Request our profile'],
                    'secondary_intent' => 'company-profile',
                ],
            ],
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
