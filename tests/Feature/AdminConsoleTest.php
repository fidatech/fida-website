<?php

namespace Tests\Feature;

use App\Models\ContentPage;
use App\Models\Lead;
use App\Models\SiteSetting;
use App\Models\User;
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
        $this->assertNotNull($page->published_at);

        $this->actingAs($editor)->get(route('admin.leads.index'))->assertForbidden();
        $this->actingAs($editor)->get(route('admin.users.index'))->assertForbidden();
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
