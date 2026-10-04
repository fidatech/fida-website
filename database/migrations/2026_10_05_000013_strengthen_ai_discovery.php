<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('content_pages')) {
            return;
        }

        // Existing production sites already have the base website content at migration time.
        // Fresh installs intentionally stay empty until DatabaseSeeder runs so isolated
        // feature tests can control their own content fixtures.
        if (! DB::table('content_pages')->where('slug', 'about')->exists()) {
            return;
        }

        $this->publish();
    }

    public function down(): void
    {
        if (Schema::hasTable('content_pages')) {
            DB::table('content_pages')->whereIn('slug', array_keys($this->pages()))->delete();
        }
    }

    private function publish(): void
    {
        foreach ($this->pages() as $slug => $page) {
            if (DB::table('content_pages')->where('slug', $slug)->exists()) {
                continue;
            }

            DB::table('content_pages')->insert([
                'type' => $page['type'],
                'slug' => $slug,
                'title' => $this->json($page['title']),
                'eyebrow' => $this->json($page['eyebrow']),
                'summary' => $this->json($page['summary']),
                'body' => $this->json($page['body']),
                'meta_title' => $this->json($page['meta_title']),
                'meta_description' => $this->json($page['meta_description']),
                'primary_query' => $this->json($page['primary_query']),
                'search_intent' => $page['search_intent'],
                'robots_directive' => 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1',
                'sitemap_included' => true,
                'sitemap_priority' => $page['priority'],
                'sitemap_change_frequency' => 'monthly',
                'sitemap_last_modified_at' => now(),
                'schema' => null,
                'metadata' => $this->json($page['metadata']),
                'status' => 'published',
                'featured' => $page['featured'],
                'sort_order' => $page['sort_order'],
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->appendRelated('about', ['company-facts', 'software-answers-afghanistan']);
        $this->appendRelated('technology-company-afghanistan', ['company-facts', 'software-answers-afghanistan']);
    }

    private function appendRelated(string $slug, array $related): void
    {
        $record = DB::table('content_pages')->select(['id', 'metadata'])->where('slug', $slug)->first();

        if (! $record) {
            return;
        }

        $metadata = json_decode((string) $record->metadata, true);
        $metadata = is_array($metadata) ? $metadata : [];
        $metadata['related_slugs'] = array_values(array_unique(array_merge(
            (array) ($metadata['related_slugs'] ?? []),
            $related,
        )));

        DB::table('content_pages')->where('id', $record->id)->update([
            'metadata' => $this->json($metadata),
            'updated_at' => now(),
        ]);
    }

    private function pages(): array
    {
        $factory = require database_path('data/ai-discovery-content.php');

        return $factory(fn (array $question, array $answer): array => compact('question', 'answer'));
    }

    private function json(array $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }
};
