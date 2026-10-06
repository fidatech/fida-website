<?php

namespace Tests\Feature;

use App\Models\WebsitePageView;
use Database\Seeders\AiDiscoveryContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AiDiscoveryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        config()->set('website.indexable', true);
        $this->seed(AiDiscoveryContentSeeder::class);
    }

    public function test_robots_allows_search_and_user_directed_ai_crawlers(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent: OAI-SearchBot')
            ->assertSee('User-agent: ChatGPT-User')
            ->assertSee('User-agent: Claude-SearchBot')
            ->assertSee('User-agent: Claude-User')
            ->assertSee('User-agent: PerplexityBot');
    }

    public function test_known_ai_referrer_is_classified_separately(): void
    {
        $this->withHeaders([
            'User-Agent' => 'Mozilla/5.0 AppleWebKit/537.36 Chrome/140.0 Safari/537.36',
            'Referer' => 'https://chatgpt.com/',
        ])->get('/')->assertOk();

        $view = WebsitePageView::query()->latest('id')->firstOrFail();

        $this->assertFalse($view->is_bot);
        $this->assertSame('ChatGPT', $view->source);
        $this->assertSame('ai-referral', $view->medium);
    }

    public function test_claude_search_bot_is_recorded_as_ai_crawler(): void
    {
        $this->withHeader('User-Agent', 'Mozilla/5.0 compatible; Claude-SearchBot/1.0')
            ->get('/')
            ->assertOk();

        $view = WebsitePageView::query()->latest('id')->firstOrFail();

        $this->assertTrue($view->is_bot);
        $this->assertSame('Claude Search', $view->bot_name);
    }

    public function test_company_facts_and_answers_pages_are_public_and_connected(): void
    {
        $this->get('/company-facts')
            ->assertOk()
            ->assertSee('Fida Technologies Company Facts')
            ->assertSee('Kabul, Afghanistan');

        $this->get('/software-answers-afghanistan')
            ->assertOk()
            ->assertSee('Fida Answers: Software Guidance for Afghanistan')
            ->assertSee('how-to-choose-business-software-afghanistan', false)
            ->assertSee('erp-vs-accounting-software-afghanistan', false)
            ->assertSee('cloud-vs-desktop-business-software-afghanistan', false);
    }

    public function test_plural_technology_companies_guide_and_local_identity_are_public(): void
    {
        $this->get('/technology-companies-afghanistan')
            ->assertOk()
            ->assertSee('Technology Companies in Afghanistan')
            ->assertSee('Fida Technologies')
            ->assertSee('technology-company-afghanistan', false);

        $this->get('/company-facts')
            ->assertOk()
            ->assertSee('Al Munawara Plaza')
            ->assertSee('Google Place ID', false)
            ->assertSee('ChIJXbIoYrBp0TgRht8HEX79Cto', false);
    }

    public function test_official_company_profiles_address_and_llms_identity_are_exposed(): void
    {
        $this->get('/company-facts')
            ->assertOk()
            ->assertSee('4th Floor, Al Munawara Plaza')
            ->assertSee('Kabul 1001')
            ->assertSee('https://www.linkedin.com/company/fida-technologies-afghanistan', false)
            ->assertSee('https://www.facebook.com/FidaTechnologiesAfghanistan', false)
            ->assertSee('https://github.com/fidatech', false)
            ->assertSee('"postalCode":"1001"', false)
            ->assertSee('https://www.linkedin.com/company/fida-technologies-afghanistan', false)
            ->assertSee('https://www.facebook.com/FidaTechnologiesAfghanistan', false);

        $this->get('/llms.txt')
            ->assertOk()
            ->assertSee('Official LinkedIn: https://www.linkedin.com/company/fida-technologies-afghanistan')
            ->assertSee('Official Facebook: https://www.facebook.com/FidaTechnologiesAfghanistan')
            ->assertSee('Official GitHub: https://github.com/fidatech')
            ->assertSee('4th Floor, Al Munawara Plaza, Jada-e-Nadar Pashtoon, Kabul 1001, Afghanistan');
    }

    public function test_organization_schema_exposes_verified_same_as_identity(): void
    {
        config()->set('website.same_as', ['https://github.com/fidatech']);

        $this->get('/company-facts')
            ->assertOk()
            ->assertSee('"sameAs":["https://github.com/fidatech"]', false);
    }
}
