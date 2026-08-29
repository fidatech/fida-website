<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentPageRequest;
use App\Models\ArticleAuthor;
use App\Models\ArticleCategory;
use App\Models\ContentPage;
use App\Support\DiscoveryAudit;
use App\Support\DiscoveryPublisher;
use App\Support\PageRedirects;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentPageController extends Controller
{
    public function index(Request $request): View
    {
        $contentTypes = config('website.content_types');
        $activeType = array_key_exists((string) $request->string('type'), $contentTypes)
            ? (string) $request->string('type')
            : null;
        $pages = ContentPage::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', (string) $request->string('status')))
            ->when($activeType, fn ($query) => $query->where('type', $activeType))
            ->when($request->filled('search'), fn ($query) => $query->where(function ($query) use ($request): void {
                $term = '%'.(string) $request->string('search')->trim().'%';
                $query->where('slug', 'like', $term)->orWhere('title->en', 'like', $term);
            }))
            ->orderByDesc('updated_at')
            ->paginate(20)
            ->withQueryString();
        $typeCounts = ContentPage::query()
            ->selectRaw('type, count(*) as aggregate')
            ->groupBy('type')
            ->pluck('aggregate', 'type');

        return view('admin.content-pages.index', compact('pages', 'contentTypes', 'activeType', 'typeCounts'));
    }

    public function create(Request $request, DiscoveryAudit $discoveryAudit): View
    {
        $requestedType = (string) $request->string('type');
        $contentPage = new ContentPage([
            'type' => array_key_exists($requestedType, config('website.content_types')) ? $requestedType : 'page',
        ]);

        return view('admin.content-pages.create', [
            'contentPage' => $contentPage,
            'discoveryAudit' => $discoveryAudit->analyze($contentPage),
            ...$this->editorOptions(),
        ]);
    }

    public function store(ContentPageRequest $request, DiscoveryPublisher $discoveryPublisher): RedirectResponse
    {
        $page = ContentPage::query()->create($this->payload($request));
        $discoveryPublisher->schedule($page);

        return redirect()
            ->route('admin.content-pages.edit', $page)
            ->with('success', 'Content page created.');
    }

    public function edit(ContentPage $contentPage, DiscoveryAudit $discoveryAudit): View
    {
        return view('admin.content-pages.edit', [
            'contentPage' => $contentPage,
            'discoveryAudit' => $discoveryAudit->analyze($contentPage),
            ...$this->editorOptions($contentPage),
        ]);
    }

    public function update(
        ContentPageRequest $request,
        ContentPage $contentPage,
        PageRedirects $pageRedirects,
        DiscoveryPublisher $discoveryPublisher,
    ): RedirectResponse
    {
        $oldSlug = $contentPage->slug;

        DB::transaction(function () use ($request, $contentPage, $pageRedirects, $oldSlug): void {
            $contentPage->update($this->payload($request));

            if ($oldSlug !== $contentPage->slug) {
                $pageRedirects->rememberSlugChange($oldSlug, $contentPage->slug);
            }
        });

        $discoveryPublisher->schedule($contentPage, $oldSlug !== $contentPage->slug ? $oldSlug : null);

        return back()->with('success', 'Content page updated.');
    }

    public function destroy(ContentPage $contentPage): RedirectResponse
    {
        abort_if($contentPage->status === 'published', 422, 'Published pages must be changed to draft before deletion.');
        $contentPage->delete();

        return redirect()->route('admin.content-pages.index')->with('success', 'Draft page deleted.');
    }

    private function payload(ContentPageRequest $request): array
    {
        $data = $request->validated();
        $existingMetadata = (array) ($request->route('contentPage')?->metadata ?? []);
        $submittedMetadata = (array) data_get($data, 'metadata', []);
        $faqs = collect(data_get($data, 'metadata.faqs', []))
            ->map(function (array $faq): array {
                return [
                    'question' => collect($faq['question'] ?? [])->map(fn (mixed $value): string => trim((string) $value))->filter()->all(),
                    'answer' => collect($faq['answer'] ?? [])->map(fn (mixed $value): string => trim((string) $value))->filter()->all(),
                ];
            })
            ->filter(fn (array $faq): bool => $faq['question'] !== [] && $faq['answer'] !== [])
            ->values()
            ->all();

        $metadata = array_replace($existingMetadata, $submittedMetadata);
        $metadata['faqs'] = $faqs;
        $metadata['related_slugs'] = collect(data_get($submittedMetadata, 'related_slugs', []))
            ->map(fn (mixed $slug): string => trim((string) $slug))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $cta = (array) data_get($submittedMetadata, 'cta', []);
        $cleanCta = [
            'heading' => $this->cleanTranslations((array) data_get($cta, 'heading', [])),
            'description' => $this->cleanTranslations((array) data_get($cta, 'description', [])),
            'primary_label' => $this->cleanTranslations((array) data_get($cta, 'primary_label', [])),
            'primary_intent' => trim((string) data_get($cta, 'primary_intent', 'proposal')) ?: 'proposal',
            'secondary_label' => $this->cleanTranslations((array) data_get($cta, 'secondary_label', [])),
            'secondary_intent' => trim((string) data_get($cta, 'secondary_intent')) ?: null,
        ];

        if ($cleanCta['heading'] !== [] || $cleanCta['description'] !== [] || $cleanCta['primary_label'] !== [] || $cleanCta['secondary_label'] !== []) {
            $metadata['cta'] = $cleanCta;
        } else {
            unset($metadata['cta']);
        }

        if ($data['type'] === 'service') {
            $service = (array) data_get($submittedMetadata, 'service', []);
            $metadata['service'] = [
                'engagement' => $this->cleanTranslations((array) data_get($service, 'engagement', [])),
                'delivery' => $this->cleanTranslations((array) data_get($service, 'delivery', [])),
                'handover' => $this->cleanTranslations((array) data_get($service, 'handover', [])),
                'capabilities' => $this->cleanLocalizedList((array) data_get($service, 'capabilities', [])),
            ];
        }

        if ($data['type'] === 'product') {
            $product = (array) data_get($submittedMetadata, 'product', []);
            $metadata['product'] = [
                'code' => trim((string) data_get($product, 'code')),
                'accent' => trim((string) data_get($product, 'accent', '#c9ff4a')) ?: '#c9ff4a',
                'category' => $this->cleanTranslations((array) data_get($product, 'category', [])),
                'platform' => $this->cleanTranslations((array) data_get($product, 'platform', [])),
                'deployment' => $this->cleanTranslations((array) data_get($product, 'deployment', [])),
                'status' => $this->cleanTranslations((array) data_get($product, 'status', [])),
                'features' => $this->cleanLocalizedList((array) data_get($product, 'features', [])),
            ];
        }

        if ($data['type'] === 'case-study') {
            $caseStudy = (array) data_get($submittedMetadata, 'case_study', []);
            $evidence = collect(array_keys(ContentPage::CASE_STUDY_EVIDENCE_CHECKS))
                ->mapWithKeys(fn (string $key): array => [
                    $key => filter_var(data_get($caseStudy, $key, false), FILTER_VALIDATE_BOOL),
                ])
                ->all();
            $evidence['evidence_owner'] = trim((string) data_get($caseStudy, 'evidence_owner'));
            $evidence['approval_reference'] = trim((string) data_get($caseStudy, 'approval_reference'));
            $evidence['approved_at'] = trim((string) data_get($caseStudy, 'approved_at')) ?: null;
            $approvedContentHash = trim((string) data_get($existingMetadata, 'case_study.approved_content_hash'));
            $currentContentHash = $this->caseStudyContentHash($data, $metadata);
            $approvedCopyChanged = $approvedContentHash !== ''
                && ! hash_equals($approvedContentHash, $currentContentHash);

            if ($approvedCopyChanged) {
                $evidence['final_client_approval_recorded'] = false;
                $data['status'] = 'review';
            }

            $evidence['publication_approved'] = ! $approvedCopyChanged
                && ! in_array(false, array_intersect_key($evidence, ContentPage::CASE_STUDY_EVIDENCE_CHECKS), true)
                && $evidence['evidence_owner'] !== ''
                && $evidence['approval_reference'] !== ''
                && $evidence['approved_at'] !== null;
            $evidence['approved_content_hash'] = $evidence['publication_approved'] ? $currentContentHash : null;
            $metadata['case_study'] = $evidence;
        }

        $data['metadata'] = $metadata;
        $data['article_category_id'] = $data['type'] === 'article' ? ($data['article_category_id'] ?? null) : null;
        $data['article_author_id'] = $data['type'] === 'article' ? ($data['article_author_id'] ?? null) : null;
        $data['robots_directive'] ??= config('website.discovery.default_robots');
        $data['sitemap_included'] ??= true;
        $data['sitemap_priority'] ??= 0.8;

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }

    private function editorOptions(?ContentPage $contentPage = null): array
    {
        return [
            'articleCategories' => ArticleCategory::query()->orderBy('sort_order')->orderBy('name->en')->get(),
            'articleAuthors' => ArticleAuthor::query()->orderBy('sort_order')->orderBy('name')->get(),
            'relatedOptions' => ContentPage::query()
                ->when($contentPage, fn ($query) => $query->whereKeyNot($contentPage->getKey()))
                ->orderBy('type')
                ->orderBy('title->en')
                ->get(['id', 'type', 'slug', 'title', 'status']),
        ];
    }

    private function cleanTranslations(array $translations): array
    {
        return collect($translations)
            ->map(fn (mixed $value): string => trim((string) $value))
            ->filter()
            ->all();
    }

    private function cleanLocalizedList(array $items): array
    {
        return collect($items)
            ->map(fn (mixed $item): array => $this->cleanTranslations((array) $item))
            ->filter()
            ->values()
            ->all();
    }

    private function caseStudyContentHash(array $data, array $metadata): string
    {
        $publicContent = collect([
            'title',
            'eyebrow',
            'summary',
            'body',
            'meta_title',
            'meta_description',
            'primary_query',
            'social_image_url',
            'author_name',
            'reviewer_name',
        ])->mapWithKeys(fn (string $field): array => [$field => $data[$field] ?? null])->all();
        $publicContent['faqs'] = data_get($metadata, 'faqs', []);
        $publicContent['cta'] = data_get($metadata, 'cta', []);
        $publicContent['related_slugs'] = data_get($metadata, 'related_slugs', []);

        return hash('sha256', json_encode($publicContent, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}
