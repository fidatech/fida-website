<?php

namespace App\Services;

use App\Models\ArticleCategory;
use App\Models\ContentPage;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

/**
 * Publishes Insights articles that are stored as reviewed JSON files in the repository.
 *
 * Each file in database/content/insights is merged through a pull request, which is the
 * editorial approval step. The importer never overwrites pages created in the admin panel.
 */
class InsightArticleImporter
{
    public const LOCALES = ['en', 'fa', 'ps'];

    private const REQUIRED_FIELDS = ['title', 'summary', 'body', 'meta_title', 'meta_description', 'primary_query'];

    private const MINIMUM_BODY_WORDS = ['en' => 280, 'fa' => 200, 'ps' => 200];

    public function directory(): string
    {
        return database_path('content/insights');
    }

    /**
     * @return array{created: list<string>, updated: list<string>, unchanged: list<string>, skipped: list<string>, errors: array<string, string>}
     */
    public function import(?string $directory = null): array
    {
        $result = ['created' => [], 'updated' => [], 'unchanged' => [], 'skipped' => [], 'errors' => []];

        foreach ($this->files($directory) as $file) {
            $name = basename($file);

            try {
                $article = $this->read($file);
                $outcome = $this->store($article, $name);
                $result[$outcome][] = $article['slug'];
            } catch (Throwable $exception) {
                $result['errors'][$name] = $exception->getMessage();
            }
        }

        return $result;
    }

    /**
     * @return array<string, string> Validation errors keyed by file name.
     */
    public function validate(?string $directory = null): array
    {
        $errors = [];

        foreach ($this->files($directory) as $file) {
            try {
                $this->read($file);
            } catch (Throwable $exception) {
                $errors[basename($file)] = $exception->getMessage();
            }
        }

        return $errors;
    }

    /**
     * @return list<string>
     */
    private function files(?string $directory): array
    {
        $directory ??= $this->directory();
        $files = glob(rtrim($directory, '/').'/*.json') ?: [];
        sort($files);

        return array_values($files);
    }

    private function read(string $file): array
    {
        $raw = (string) file_get_contents($file);
        $data = json_decode($raw, true);

        if (! is_array($data)) {
            throw new RuntimeException('The file is not valid JSON.');
        }

        $slug = (string) ($data['slug'] ?? '');
        if ($slug === '' || $slug !== Str::slug($slug) || mb_strlen($slug) > 120) {
            throw new RuntimeException('The slug must be lowercase kebab-case and at most 120 characters.');
        }

        if ($slug !== basename($file, '.json')) {
            throw new RuntimeException('The file name must match the slug.');
        }

        foreach (self::LOCALES as $locale) {
            foreach (self::REQUIRED_FIELDS as $field) {
                if (trim(strip_tags((string) data_get($data, "{$field}.{$locale}", ''))) === '') {
                    throw new RuntimeException("{$field}.{$locale} is missing.");
                }
            }

            $body = $this->cleanHtml((string) data_get($data, "body.{$locale}"));
            if ($this->wordCount(strip_tags($body)) < self::MINIMUM_BODY_WORDS[$locale]) {
                throw new RuntimeException("The {$locale} body is too short to publish.");
            }

            if (substr_count(mb_strtolower($body), '<h2') < 2) {
                throw new RuntimeException("The {$locale} body needs at least two <h2> sections.");
            }
        }

        $publishOn = $data['publish_on'] ?? null;
        if ($publishOn !== null && ! preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $publishOn)) {
            throw new RuntimeException('publish_on must use the YYYY-MM-DD format.');
        }

        $data['hash'] = hash('sha256', $raw);

        return $data;
    }

    private function store(array $article, string $file): string
    {
        $slug = $article['slug'];
        $existing = ContentPage::query()->where('slug', $slug)->first();

        if ($existing && data_get($existing->metadata, 'repository.file') !== $file) {
            return 'skipped';
        }

        if ($existing && data_get($existing->metadata, 'repository.hash') === $article['hash']) {
            return 'unchanged';
        }

        $content = [
            'type' => 'article',
            'article_category_id' => $this->categoryId($article['category'] ?? null),
            'title' => $this->text($article['title']),
            'eyebrow' => $this->text($article['eyebrow'] ?? []),
            'summary' => $this->text($article['summary']),
            'body' => $this->html($article['body']),
            'meta_title' => $this->text($article['meta_title']),
            'meta_description' => $this->text($article['meta_description']),
            'primary_query' => $this->text($article['primary_query']),
            'search_intent' => 'informational',
            'robots_directive' => config('website.discovery.default_robots'),
            'sitemap_included' => true,
            'sitemap_priority' => 0.7,
            'sitemap_change_frequency' => 'monthly',
            'sitemap_last_modified_at' => now(),
            'author_name' => mb_substr(trim(strip_tags((string) ($article['author_name'] ?? 'Fida Technologies'))), 0, 120),
            'metadata' => [
                'faqs' => $this->faqs($article['faqs'] ?? []),
                'related_slugs' => $this->relatedSlugs($article['related_slugs'] ?? [], $slug),
                'repository' => [
                    'file' => $file,
                    'hash' => $article['hash'],
                    'ai_assisted' => true,
                    'approved_by' => 'pull-request-merge',
                ],
            ],
        ];

        if ($existing) {
            $content['metadata'] = array_merge((array) $existing->metadata, $content['metadata']);
            $existing->update($content);

            return 'updated';
        }

        ContentPage::query()->create($content + [
            'slug' => $slug,
            'status' => 'published',
            'featured' => false,
            'sort_order' => 1300,
            'published_at' => $this->publishedAt($article['publish_on'] ?? null),
        ]);

        return 'created';
    }

    private function publishedAt(?string $publishOn): CarbonImmutable
    {
        if ($publishOn === null) {
            return CarbonImmutable::now();
        }

        return CarbonImmutable::createFromFormat('Y-m-d H:i', "{$publishOn} 09:00", 'Asia/Kabul')
            ->setTimezone(config('app.timezone'));
    }

    private function categoryId(mixed $slug): ?int
    {
        $id = filled($slug)
            ? ArticleCategory::query()->where('slug', (string) $slug)->where('active', true)->value('id')
            : null;

        return $id ?? ArticleCategory::query()->where('slug', 'business-software-planning')->value('id');
    }

    private function relatedSlugs(mixed $slugs, string $self): array
    {
        return collect(is_array($slugs) ? $slugs : [])
            ->map(fn ($slug) => Str::slug((string) $slug))
            ->filter(fn ($slug) => $slug !== '' && $slug !== $self && ContentPage::query()->where('slug', $slug)->exists())
            ->unique()->take(8)->values()->all();
    }

    private function faqs(mixed $faqs): array
    {
        return collect(is_array($faqs) ? $faqs : [])
            ->map(fn ($faq) => [
                'question' => $this->text(is_array($faq) ? ($faq['question'] ?? []) : []),
                'answer' => $this->text(is_array($faq) ? ($faq['answer'] ?? []) : []),
            ])
            ->filter(fn (array $faq) => filled($faq['question']['en'] ?? null) && filled($faq['answer']['en'] ?? null))
            ->take(8)->values()->all();
    }

    private function text(mixed $values): array
    {
        $values = is_array($values) ? $values : [];

        return collect(self::LOCALES)->mapWithKeys(fn (string $locale): array => [
            $locale => mb_substr(trim(strip_tags((string) ($values[$locale] ?? ''))), 0, 60000),
        ])->filter()->all();
    }

    private function html(mixed $values): array
    {
        $values = is_array($values) ? $values : [];

        return collect(self::LOCALES)->mapWithKeys(fn (string $locale): array => [
            $locale => mb_substr($this->cleanHtml((string) ($values[$locale] ?? '')), 0, 60000),
        ])->filter()->all();
    }

    private function cleanHtml(string $value): string
    {
        $value = preg_replace('/<\s*(script|style|iframe|object|embed)[^>]*>.*?<\/\s*\1\s*>/is', '', $value) ?? $value;
        $value = preg_replace('/\s+on\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $value) ?? $value;
        $value = preg_replace('/javascript\s*:/i', '', $value) ?? $value;

        return trim(strip_tags($value, '<h2><h3><p><ul><ol><li><strong><em><a>'));
    }

    private function wordCount(string $value): int
    {
        $value = trim($value);

        return $value === '' ? 0 : count(preg_split('/\s+/u', $value, -1, PREG_SPLIT_NO_EMPTY) ?: []);
    }
}
