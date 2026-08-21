<?php

namespace Tests\Feature;

use App\Models\Lead;
use Database\Seeders\WebsiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->assertSee('<h1>ERP Systems in Afghanistan</h1>', false);
    }

    public function test_sitemap_contains_seeded_pages_and_localized_alternates(): void
    {
        $this->seed(WebsiteSeeder::class);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('erp-systems-afghanistan')
            ->assertSee('hreflang="fa"', false);
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
