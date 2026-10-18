<?php

namespace Tests\Feature;

use App\Support\WebsiteTemplate;
use Illuminate\Http\Request;
use Tests\TestCase;

class WebsiteTemplateTest extends TestCase
{
    public function test_a_public_visitor_cannot_activate_the_corporate_preview_query(): void
    {
        config()->set('website.appearance.current_template', 'technology');
        $request = Request::create('/?template_preview=corporate');

        $this->assertSame('technology', WebsiteTemplate::resolve($request));
        $this->assertFalse(WebsiteTemplate::isAuthorizedPreview($request));
    }

    public function test_an_authorized_settings_administrator_can_preview_the_corporate_template(): void
    {
        config()->set('website.appearance.current_template', 'technology');
        $request = Request::create('/?template_preview=corporate');
        $request->setUserResolver(fn () => new class
        {
            public function allows(string $ability): bool
            {
                return $ability === 'settings.manage';
            }
        });

        $this->assertTrue(WebsiteTemplate::isAuthorizedPreview($request));
        $this->assertSame('corporate', WebsiteTemplate::resolve($request));
    }

    public function test_an_unknown_template_cannot_be_selected_by_the_query_string(): void
    {
        config()->set('website.appearance.current_template', 'technology');
        $request = Request::create('/?template_preview=unknown');
        $request->setUserResolver(fn () => new class
        {
            public function allows(string $ability): bool
            {
                return true;
            }
        });

        $this->assertFalse(WebsiteTemplate::isAuthorizedPreview($request));
        $this->assertSame('technology', WebsiteTemplate::resolve($request));
    }

    public function test_an_invalid_saved_template_falls_back_to_technology(): void
    {
        config()->set('website.appearance.current_template', 'unknown');

        $this->assertSame('technology', WebsiteTemplate::resolve(Request::create('/')));
    }
}
