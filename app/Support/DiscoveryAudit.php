<?php

namespace App\Support;

use App\Models\ContentPage;

final class DiscoveryAudit
{
    public function analyze(ContentPage $page): array
    {
        $checks = [];

        foreach (array_keys(config('website.locales')) as $locale) {
            $title = trim((string) data_get($page->title, $locale));
            $summary = trim((string) data_get($page->summary, $locale));
            $body = trim(strip_tags((string) data_get($page->body, $locale)));
            $metaTitle = trim((string) data_get($page->meta_title, $locale));
            $metaDescription = trim((string) data_get($page->meta_description, $locale));
            $primaryQuery = trim((string) data_get($page->primary_query, $locale));

            $checks[] = $this->check("{$locale}:primary-query", $primaryQuery !== '', strtoupper($locale).' has a defined primary search topic.');
            $checks[] = $this->check("{$locale}:title", mb_strlen($title) >= 12, strtoupper($locale).' has a descriptive page title.');
            $checks[] = $this->check("{$locale}:summary", mb_strlen($summary) >= 60, strtoupper($locale).' has a direct, useful summary.');
            $checks[] = $this->check("{$locale}:meta-title", mb_strlen($metaTitle) >= 25 && mb_strlen($metaTitle) <= 70, strtoupper($locale).' meta title is within the practical review range.');
            $checks[] = $this->check("{$locale}:meta-description", mb_strlen($metaDescription) >= 70 && mb_strlen($metaDescription) <= 180, strtoupper($locale).' meta description is within the practical review range.');
            $checks[] = $this->check("{$locale}:body", $this->wordCount($body) >= 80, strtoupper($locale).' contains substantial visible content.');
        }

        $checks[] = $this->check('intent', filled($page->search_intent), 'Search intent is documented.');
        $checks[] = $this->check('robots', in_array($page->robotsDirective(), array_keys(config('website.discovery.robots')), true), 'Robots policy is explicit and valid.');
        $checks[] = $this->check(
            'sitemap-policy',
            ! $page->sitemap_included || ! str_starts_with($page->robotsDirective(), 'noindex'),
            'Sitemap inclusion agrees with the page robots policy.',
        );
        $checks[] = $this->check('social-image', filled($page->social_image_url) || filled(config('website.social_image')), 'A page or site-wide social preview image is available.');

        if (in_array($page->type, ['article', 'case-study'], true)) {
            $checks[] = $this->check('author', filled($page->author_name), 'The responsible author is identified.');
            $checks[] = $this->check('review', filled($page->reviewer_name) && $page->reviewed_at !== null, 'Editorial review is recorded.');
        }

        if (($caseStudyReadiness = $page->caseStudyReadiness()) !== null) {
            foreach ($caseStudyReadiness['checks'] as $evidenceCheck) {
                $checks[] = $this->check(
                    'case-study:'.$evidenceCheck['key'],
                    $evidenceCheck['passed'],
                    $evidenceCheck['label'],
                );
            }

            $checks[] = $this->check(
                'case-study:approval-record',
                $caseStudyReadiness['records_complete'],
                'Evidence owner, approval reference and approval date are recorded.',
            );
        }

        $passed = collect($checks)->where('passed', true)->count();
        $total = count($checks);
        $score = $total === 0 ? 0 : (int) round(($passed / $total) * 100);

        return [
            'score' => $score,
            'status' => $score >= 85 ? 'ready' : ($score >= 60 ? 'improving' : 'incomplete'),
            'passed' => $passed,
            'total' => $total,
            'checks' => $checks,
            'issues' => collect($checks)->where('passed', false)->values()->all(),
        ];
    }

    private function check(string $key, bool $passed, string $label): array
    {
        return compact('key', 'passed', 'label');
    }

    private function wordCount(string $value): int
    {
        if ($value === '') {
            return 0;
        }

        return count(preg_split('/\s+/u', trim($value), -1, PREG_SPLIT_NO_EMPTY) ?: []);
    }
}
