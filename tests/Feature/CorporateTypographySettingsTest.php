<?php

namespace Tests\Feature;

use App\Support\WebsiteSettings;
use Tests\TestCase;

class CorporateTypographySettingsTest extends TestCase
{
    public function test_public_font_presets_and_sizes_have_valid_defaults(): void
    {
        $fonts = config('website.appearance.font_presets', []);
        $sizes = config('website.appearance.type_scales', []);

        $this->assertArrayHasKey(config('website.appearance.default_font_preset'), $fonts);
        $this->assertArrayHasKey(config('website.appearance.default_type_scale'), $sizes);
        $this->assertArrayHasKey('editorial', $fonts);
        $this->assertArrayHasKey('modern', $fonts);
        $this->assertArrayHasKey('classic', $fonts);
    }

    public function test_the_selected_typography_does_not_require_an_additional_settings_record(): void
    {
        $form = app(WebsiteSettings::class)->formData();

        $this->assertContains($form['font_preset'], array_keys(config('website.appearance.font_presets')));
        $this->assertContains($form['type_scale'], array_keys(config('website.appearance.type_scales')));
    }
}
