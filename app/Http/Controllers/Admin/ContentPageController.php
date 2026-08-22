<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentPageRequest;
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

        $data['metadata'] = array_replace($existingMetadata, ['faqs' => $faqs]);
        $data['robots_directive'] ??= config('website.discovery.default_robots');

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
