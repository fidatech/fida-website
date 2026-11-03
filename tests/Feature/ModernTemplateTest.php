<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Support\ModernNav;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ModernTemplateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
        config()->set('website.appearance.default_template', 'modern');
    }

    public function test_the_homepage_renders_the_five_pillars_catalog_and_academy(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertViewIs('marketing.templates.modern.home')
            ->assertSee('site-template-modern', false)
            ->assertSee('Software, infrastructure and training for organizations in Afghanistan.')
            ->assertSee('Everything your organization runs on')
            ->assertSee('Infrastructure and security')
            ->assertSee('Fida Academy')
            ->assertSee('Linux administration')
            ->assertSee('Prime Sarafi')
            ->assertSee('Petromin ERP')
            ->assertSee('action="'.route('leads.store').'"', false)
            ->assertDontSee('SECURE CHANNEL / 256-BIT')
            ->assertDontSee('FIDA SYSTEM STATUS');
    }

    public function test_the_homepage_shows_the_headline_in_the_other_two_languages(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('lang="fa" dir="rtl"', false)
            ->assertSee('lang="ps" dir="rtl"', false)
            ->assertSee(trans('modern.hero.title', [], 'fa'));

        $this->get('/fa')
            ->assertOk()
            ->assertSee('dir="rtl"', false)
            ->assertSee(trans('modern.hero.title', [], 'fa'))
            ->assertSee('lang="en" dir="ltr"', false);

        $this->get('/ps')
            ->assertOk()
            ->assertSee(trans('modern.bento.title', [], 'ps'));
    }

    public function test_the_menu_shows_short_labels_without_repeating_the_country(): void
    {
        $this->assertSame('ERP Systems', ModernNav::label('ERP Systems in Afghanistan'));
        $this->assertSame('سیستم‌های ERP', ModernNav::label('سیستم‌های ERP در افغانستان'));
        $this->assertSame('Cloud & Server Infrastructure', ModernNav::label('Cloud & Server Infrastructure'));

        $this->get('/')
            ->assertOk()
            ->assertSee('>ERP Systems</a>', false);
    }

    public function test_infrastructure_solutions_are_separated_from_software_in_the_menu(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $infrastructureMenu = str($html)->after('<summary>'.__('modern.nav.infrastructure').'</summary>')->before('</details>');

        $this->assertStringContainsString('/cybersecurity-solutions-afghanistan', (string) $infrastructureMenu);
        $this->assertStringNotContainsString('/erp-systems-afghanistan', (string) $infrastructureMenu);
    }

    public function test_a_training_request_can_be_submitted_from_the_contact_form(): void
    {
        Mail::fake();

        $this->post('/contact/lead', [
            'name' => 'Training Coordinator',
            'email' => 'training@example.org',
            'project_type' => 'training',
            'message' => 'We need Linux administration training for six IT staff.',
            'locale' => 'en',
            'source_url' => url('/'),
            'interest_slug' => 'academy-linux',
        ])->assertRedirect();

        $lead = Lead::query()->firstOrFail();
        $this->assertSame('training', $lead->project_type);
        $this->assertSame('academy-linux', $lead->interest_slug);
    }

    public function test_inner_pages_use_the_new_design_and_keep_their_content(): void
    {
        $this->get('/prime-sarafi-software')
            ->assertOk()
            ->assertSee('class="mx-page-hero"', false)
            ->assertSee('class="mx-profile"', false)
            ->assertSee('id="frequently-asked-questions"', false)
            ->assertSee('Prime Sarafi')
            ->assertDontSee('product-profile-orbit', false);

        $this->get('/erp-systems-afghanistan')->assertOk()->assertSee('class="mx-prose"', false);
        $this->get('/solutions')->assertOk()->assertSee('class="mx-card"', false);
        $this->get('/how-to-choose-erp-system-afghanistan')->assertOk()->assertSee('class="mx-article-meta"', false);
        $this->get('/contact')->assertOk()->assertSee('action="'.route('leads.store').'"', false)->assertSee('mx-form', false);
        $this->get('/request-for-quotation')->assertOk()->assertSee('action="'.route('rfq.store').'"', false)->assertSee('name="capabilities[]"', false);
        $this->get('/search?q=erp')->assertOk()->assertSee('class="mx-search"', false);
        $this->get('/fa/prime-sarafi-software')->assertOk()->assertSee('dir="rtl"', false)->assertSee('class="mx-profile"', false);
    }

    public function test_the_live_template_keeps_its_original_inner_pages(): void
    {
        config()->set('website.appearance.default_template', 'technology');

        $this->get('/prime-sarafi-software')
            ->assertOk()
            ->assertSee('product-profile-section', false)
            ->assertDontSee('class="mx-page-hero"', false);
    }
}
