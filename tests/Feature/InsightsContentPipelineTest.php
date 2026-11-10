<?php

namespace Tests\Feature;

use App\Models\ContentPage;
use App\Services\AutoArticleService;
use App\Services\InsightArticleImporter;
use App\Services\WebsiteContentAiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class InsightsContentPipelineTest extends TestCase
{
    use RefreshDatabase;

    private string $directory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->directory = storage_path('framework/testing/insights-'.uniqid());
        File::ensureDirectoryExists($this->directory);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->directory);

        parent::tearDown();
    }

    public function test_repository_article_is_published_once_and_updated_when_its_file_changes(): void
    {
        $this->writeArticle('sarafi-software-guide');
        $importer = app(InsightArticleImporter::class);

        $first = $importer->import($this->directory);
        $this->assertSame(['sarafi-software-guide'], $first['created']);
        $this->assertSame([], $first['errors']);

        $page = ContentPage::query()->where('slug', 'sarafi-software-guide')->firstOrFail();
        $this->assertSame('article', $page->type);
        $this->assertSame('published', $page->status);
        $this->assertTrue($page->isPubliclyVisible());
        $this->assertSame('Fida Technologies', $page->byline());
        $this->assertStringNotContainsString('<script', $page->body['en']);
        $this->assertStringNotContainsString('onclick', $page->body['en']);
        $this->assertSame([], $page->metadata['related_slugs']);

        $second = $importer->import($this->directory);
        $this->assertSame(['sarafi-software-guide'], $second['unchanged']);
        $this->assertSame(1, ContentPage::query()->where('slug', 'sarafi-software-guide')->count());

        $this->writeArticle('sarafi-software-guide', ['title' => ['en' => 'Updated title', 'fa' => 'عنوان تازه', 'ps' => 'نوی سرلیک']]);
        $third = $importer->import($this->directory);
        $this->assertSame(['sarafi-software-guide'], $third['updated']);
        $this->assertSame('Updated title', $page->fresh()->title['en']);
    }

    public function test_importer_does_not_overwrite_admin_pages_and_reports_invalid_files(): void
    {
        ContentPage::query()->create([
            'type' => 'article',
            'slug' => 'managed-in-admin',
            'title' => ['en' => 'Admin title'],
            'summary' => ['en' => 'Admin summary'],
            'body' => ['en' => '<p>Admin body</p>'],
            'status' => 'draft',
        ]);

        $this->writeArticle('managed-in-admin');
        $this->writeArticle('too-thin', ['body' => ['en' => '<h2>A</h2><h2>B</h2><p>Short.</p>', 'fa' => 'x', 'ps' => 'x']]);
        File::put($this->directory.'/wrong-name.json', json_encode(['slug' => 'another-slug']));

        $importer = app(InsightArticleImporter::class);
        $result = $importer->import($this->directory);

        $this->assertSame(['managed-in-admin'], $result['skipped']);
        $this->assertSame('Admin title', ContentPage::query()->where('slug', 'managed-in-admin')->value('title')['en']);
        $this->assertArrayHasKey('too-thin.json', $result['errors']);
        $this->assertArrayHasKey('wrong-name.json', $result['errors']);
        $this->assertFalse(ContentPage::query()->where('slug', 'too-thin')->exists());
        $this->assertCount(2, $importer->validate($this->directory));
    }

    public function test_committed_insight_article_files_are_valid(): void
    {
        $this->assertSame([], app(InsightArticleImporter::class)->validate());
        $this->artisan('website:import-insights', ['--check' => true])->assertSuccessful();
    }

    public function test_auto_article_recovers_when_the_ai_reuses_the_slug_of_an_unpublished_draft(): void
    {
        ContentPage::query()->create([
            'type' => 'article',
            'slug' => 'pos-software-afghanistan',
            'title' => ['en' => 'Earlier draft'],
            'summary' => ['en' => 'Earlier summary'],
            'body' => ['en' => '<p>Earlier body</p>'],
            'primary_query' => ['en' => 'pos software kabul'],
            'status' => 'review',
        ]);

        $generated = $this->article('pos-software-afghanistan', [
            'title' => ['en' => 'Choosing Retail POS Software', 'fa' => 'انتخاب سیستم فروش', 'ps' => 'د پلور سیسټم ټاکل'],
        ]) + ['quality' => [
            'publishable' => true,
            'distinctive_value' => 'Explains practical selection criteria that are specific to shops in Afghanistan.',
        ]];

        $ai = $this->mock(WebsiteContentAiService::class);
        $ai->shouldReceive('generateArticle')
            ->once()
            ->withArgs(fn (array $context): bool => collect($context['existing_content'])->contains('slug', 'pos-software-afghanistan'))
            ->andReturn($generated);

        $page = app(AutoArticleService::class)->generate($ai, true);

        $this->assertSame('choosing-retail-pos-software', $page->slug);
        $this->assertSame('review', $page->status);
        $this->assertNull($page->published_at);
    }

    private function writeArticle(string $slug, array $overrides = []): void
    {
        File::put(
            $this->directory."/{$slug}.json",
            json_encode($this->article($slug, $overrides), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        );
    }

    private function article(string $slug, array $overrides = []): array
    {
        $en = '<h2>First section</h2><p onclick="x()">'.trim(str_repeat('practical guidance ', 160)).'</p><script>alert(1)</script><h2>Second section</h2><p>More detail.</p>';
        $fa = '<h2>بخش اول</h2><p>'.trim(str_repeat('رهنمای عملی ', 120)).'</p><h2>بخش دوم</h2><p>جزئیات بیشتر.</p>';
        $ps = '<h2>لومړۍ برخه</h2><p>'.trim(str_repeat('عملي لارښود ', 120)).'</p><h2>دویمه برخه</h2><p>نور جزئیات.</p>';

        return array_merge([
            'slug' => $slug,
            'title' => ['en' => 'Sarafi software guide', 'fa' => 'رهنمای سیستم صرافی', 'ps' => 'د صرافۍ سیسټم لارښود'],
            'summary' => ['en' => 'A summary.', 'fa' => 'خلاصه.', 'ps' => 'لنډیز.'],
            'body' => ['en' => $en, 'fa' => $fa, 'ps' => $ps],
            'meta_title' => ['en' => 'Sarafi software guide | Fida', 'fa' => 'رهنمای سیستم صرافی | فدا', 'ps' => 'د صرافۍ سیسټم لارښود | فدا'],
            'meta_description' => ['en' => 'A description.', 'fa' => 'توضیح.', 'ps' => 'تشریح.'],
            'primary_query' => ['en' => 'sarafi software', 'fa' => 'سیستم صرافی', 'ps' => 'د صرافۍ سیسټم'],
            'related_slugs' => [$slug, 'does-not-exist'],
        ], $overrides);
    }
}
