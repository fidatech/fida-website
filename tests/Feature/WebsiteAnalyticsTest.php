<?php

namespace Tests\Feature;

use App\Models\SearchConsoleMetric;
use App\Models\User;
use App\Models\WebsiteAnalyticsEvent;
use App\Models\WebsitePageView;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_public_html_requests_are_recorded_without_raw_ip_storage(): void
    {
        $this->withServerVariables([
            'REMOTE_ADDR' => '203.0.113.18',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_0 like Mac OS X) AppleWebKit/605.1.15 Version/18.0 Mobile/15E148 Safari/604.1',
            'HTTP_CF_IPCOUNTRY' => 'AF',
        ])->get('/')->assertOk();

        $view = WebsitePageView::query()->latest('id')->firstOrFail();

        $this->assertFalse($view->is_bot);
        $this->assertSame('mobile', $view->device_type);
        $this->assertSame('AF', $view->country_code);
        $this->assertSame('/', $view->path);
        $this->assertNotSame('203.0.113.18', $view->ip_hash);
        $this->assertSame(64, strlen((string) $view->ip_hash));
    }

    public function test_search_and_ai_crawlers_are_separated_from_human_traffic(): void
    {
        $this->withHeader('User-Agent', 'Mozilla/5.0 compatible; OAI-SearchBot/1.0')
            ->get('/')
            ->assertOk();

        $view = WebsitePageView::query()->latest('id')->firstOrFail();

        $this->assertTrue($view->is_bot);
        $this->assertSame('OpenAI Search', $view->bot_name);
    }


    public function test_automated_http_clients_are_not_counted_as_real_visitors(): void
    {
        $this->withHeader('User-Agent', 'GuzzleHttp/7.10 curl/8.7.1 PHP/8.4')
            ->get('/')
            ->assertOk();

        $view = WebsitePageView::query()->latest('id')->firstOrFail();

        $this->assertTrue($view->is_bot);
        $this->assertSame('Automated HTTP client', $view->bot_name);
    }

    public function test_super_admin_can_open_analytics_but_editor_cannot(): void
    {
        $admin = User::factory()->admin()->create();
        $editor = User::factory()->admin('editor')->create();

        $this->actingAs($admin)
            ->get(route('admin.analytics.index'))
            ->assertOk()
            ->assertSee('Website analytics')
            ->assertSee('Google Search Console')
            ->assertSee('Search & AI bots')
            ->assertSee('Real visitor activity')
            ->assertSee('What should Fida work on next?');

        $this->actingAs($editor)
            ->get(route('admin.analytics.index'))
            ->assertForbidden();
    }

    public function test_first_party_cta_event_can_be_recorded(): void
    {
        $this->postJson(route('analytics.event'), [
            'event_name' => 'cta_click',
            'event_label' => 'header_contact',
            'path' => '/erp-systems-afghanistan',
        ])->assertOk()->assertJson(['ok' => true]);

        $this->assertDatabaseHas('website_analytics_events', [
            'event_name' => 'cta_click',
            'event_label' => 'header_contact',
            'path' => '/erp-systems-afghanistan',
        ]);
    }

    public function test_initial_search_console_snapshot_is_available(): void
    {
        $this->assertGreaterThan(0, SearchConsoleMetric::query()->where('metric_type', 'query')->count());
        $this->assertDatabaseHas('search_console_metrics', [
            'metric_type' => 'page',
            'dimension' => 'https://fida.af/hrmis-payroll-software-afghanistan',
            'impressions' => 58,
        ]);
    }

    public function test_llms_document_exposes_official_discovery_information(): void
    {
        $this->get('/llms.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Fida Technologies')
            ->assertSee('ERP and management information systems')
            ->assertSee('Sitemap:');
    }
}
