<?php

namespace Tests\Feature;

use App\Models\ContentPage;
use App\Support\WebsiteTemplate;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LaunchAndTranslationTest extends TestCase
{
    use RefreshDatabase;

    private const OLD = 'فیدا';

    private const NEW = 'فدا';

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
        config()->set('website.appearance.default_template', 'modern');
    }

    public function test_dari_and_pashto_pages_use_the_fda_spelling(): void
    {
        foreach (['/fa', '/ps', '/fa/about', '/ps/contact', '/fa/products'] as $path) {
            $html = $this->get($path)->assertOk()->getContent();

            $this->assertStringNotContainsString(self::OLD, $html, "Old spelling found on {$path}");
        }

        $this->get('/fa/about')->assertSee(self::NEW);
    }

    public function test_the_spelling_migration_fixes_raw_and_escaped_content(): void
    {
        $page = ContentPage::query()->where('slug', 'about')->firstOrFail();
        DB::table('content_pages')->where('id', $page->id)->update([
            'summary' => json_encode(['en' => 'About', 'fa' => 'درباره '.self::OLD]),
            'eyebrow' => '{"en":"x","ps":"'.trim(json_encode(self::OLD), '"').'"}',
        ]);

        (require database_path('migrations/2026_11_04_000001_use_fda_spelling_in_dari_and_pashto.php'))->up();

        $row = DB::table('content_pages')->where('id', $page->id)->first();
        $this->assertSame('درباره '.self::NEW, json_decode($row->summary, true)['fa']);
        $this->assertSame(self::NEW, json_decode($row->eyebrow, true)['ps']);
    }

    public function test_english_only_faqs_and_tags_show_reviewed_translations(): void
    {
        $this->get('/fa/contact')
            ->assertOk()
            ->assertSee('در پیام اول چه معلوماتی بنویسیم؟')
            ->assertDontSee('What information should be included in the first message?');

        $this->get('/ps/cybersecurity-solutions-afghanistan')
            ->assertOk()
            ->assertSee('هویت او لاسرسی')
            ->assertDontSee('Identity and access');

        $this->get('/contact')->assertOk()->assertSee('What information should be included in the first message?');
    }

    public function test_dari_pages_translate_the_address_and_system_names(): void
    {
        $this->get('/fa')
            ->assertOk()
            ->assertSee('منزل چهارم، پلازای المنوره، جاده میوند، کابل')
            ->assertSee('سیستم مدیریت خیاطی');

        $this->get('/ps/request-for-quotation')
            ->assertOk()
            ->assertSee('خصوصي شرکت')
            ->assertDontSee('Private Enterprise');
    }

    public function test_the_launch_migration_switches_to_the_new_design_and_can_be_rolled_back(): void
    {
        config()->set('website.appearance.default_template', 'technology');
        config()->set('website.appearance.activate_modern_on_migrate', true);
        DB::table('site_settings')->updateOrInsert(
            ['key' => 'website.appearance'],
            ['group' => 'appearance', 'value' => json_encode(['template' => 'technology', 'theme' => 'obsidian']), 'type' => 'json', 'is_public' => true],
        );

        $migration = require database_path('migrations/2026_11_04_000002_activate_fida_2026_template.php');
        $migration->up();

        $value = json_decode(DB::table('site_settings')->where('key', 'website.appearance')->value('value'), true);
        $this->assertSame('modern', $value['template']);
        $this->assertSame('obsidian', $value['theme']);

        app(\App\Support\WebsiteSettings::class)->forget();
        $this->get('/')->assertOk()->assertSee('site-template-modern', false);

        $migration->down();
        $value = json_decode(DB::table('site_settings')->where('key', 'website.appearance')->value('value'), true);
        $this->assertSame('technology', $value['template']);
        $this->assertArrayNotHasKey('previous_template', $value);
    }
}
