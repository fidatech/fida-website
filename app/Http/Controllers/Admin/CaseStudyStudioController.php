<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ContentPage;
use App\Models\PortfolioProject;
use App\Services\WebsiteContentAiService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class CaseStudyStudioController extends Controller
{
    public function index(): View
    {
        return view('admin.case-studies.index', [
            'caseStudies' => ContentPage::query()
                ->where('type', 'case-study')
                ->latest('updated_at')
                ->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.case-studies.create', [
            'clients' => Client::query()->orderBy('name')->get(),
            'projects' => PortfolioProject::query()->with('client')->orderByDesc('updated_at')->get(),
        ]);
    }

    public function generate(Request $request, WebsiteContentAiService $ai): RedirectResponse
    {
        $validated = $request->validate([
            'client_id' => ['nullable', 'exists:clients,id'],
            'portfolio_project_id' => ['nullable', 'exists:portfolio_projects,id'],
            'client_display_name' => ['nullable', 'string', 'max:190'],
            'keep_client_private' => ['nullable', 'boolean'],
            'industry' => ['required', 'string', 'max:190'],
            'project_name' => ['required', 'string', 'max:190'],
            'problem' => ['required', 'string', 'max:5000'],
            'previous_process' => ['nullable', 'string', 'max:4000'],
            'scope' => ['required', 'string', 'max:7000'],
            'implementation' => ['nullable', 'string', 'max:7000'],
            'outcomes' => ['required', 'string', 'max:7000'],
            'measurable_results' => ['nullable', 'string', 'max:3000'],
            'technologies' => ['nullable', 'string', 'max:2000'],
            'timeline' => ['nullable', 'string', 'max:1000'],
            'testimonial' => ['nullable', 'string', 'max:3000'],
            'notes' => ['nullable', 'string', 'max:4000'],
        ]);

        $answers = [
            ...$validated,
            'keep_client_private' => $request->boolean('keep_client_private'),
        ];

        if ($answers['keep_client_private']) {
            $answers['client_display_name'] = null;
        }

        try {
            $generated = $ai->generateCaseStudy($answers);
            $slug = Str::slug((string) ($generated['slug'] ?? ''));

            if ($slug === '' || ContentPage::query()->where('slug', $slug)->exists()) {
                $slug = Str::slug($validated['project_name'].' case study');
            }

            if ($slug === '' || ContentPage::query()->where('slug', $slug)->exists()) {
                throw new RuntimeException('Could not create a unique case-study slug. Change the project name or create it manually.');
            }

            $page = ContentPage::query()->create([
                'type' => 'case-study',
                'slug' => $slug,
                'title' => $this->translations($generated['title'] ?? []),
                'eyebrow' => $this->translations($generated['eyebrow'] ?? []),
                'summary' => $this->translations($generated['summary'] ?? []),
                'body' => $this->htmlTranslations($generated['body'] ?? []),
                'meta_title' => $this->translations($generated['meta_title'] ?? []),
                'meta_description' => $this->translations($generated['meta_description'] ?? []),
                'primary_query' => $this->translations($generated['primary_query'] ?? []),
                'search_intent' => 'commercial',
                'robots_directive' => config('website.discovery.default_robots'),
                'sitemap_included' => true,
                'sitemap_priority' => 0.75,
                'sitemap_change_frequency' => 'monthly',
                'sitemap_last_modified_at' => now(),
                'metadata' => [
                    'case_study' => [
                        'client_identity_confirmed' => false,
                        'publication_permission_recorded' => false,
                        'implementation_scope_verified' => false,
                        'visual_assets_approved' => false,
                        'outcomes_evidence_verified' => false,
                        'final_client_approval_recorded' => false,
                        'evidence_owner' => '',
                        'approval_reference' => '',
                        'approved_at' => null,
                        'publication_approved' => false,
                    ],
                    'case_study_intake' => [
                        'client_id' => $validated['client_id'] ?? null,
                        'portfolio_project_id' => $validated['portfolio_project_id'] ?? null,
                        'keep_client_private' => $request->boolean('keep_client_private'),
                        'editor_note' => mb_substr(strip_tags((string) ($generated['editor_note'] ?? '')), 0, 1000),
                    ],
                ],
                'status' => 'review',
                'featured' => false,
                'sort_order' => 500,
                'published_at' => null,
            ]);

            return redirect()->route('admin.content-pages.edit', $page)
                ->with('success', 'Case-study draft generated. Confirm evidence, permissions, screenshots and wording before publishing.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->withInput()->withErrors(['case_study' => $exception->getMessage()]);
        }
    }

    private function translations(mixed $values): array
    {
        $values = is_array($values) ? $values : [];

        return collect(['en','fa','ps'])->mapWithKeys(fn (string $locale) => [
            $locale => mb_substr(trim(strip_tags((string) ($values[$locale] ?? ''))), 0, 60000),
        ])->filter()->all();
    }

    private function htmlTranslations(mixed $values): array
    {
        $values = is_array($values) ? $values : [];

        return collect(['en','fa','ps'])->mapWithKeys(function (string $locale) use ($values): array {
            $value = (string) ($values[$locale] ?? '');
            $value = preg_replace('/<\s*(script|iframe|object|embed)[^>]*>.*?<\/\s*\1\s*>/is', '', $value) ?? $value;
            $value = preg_replace('/\s+on\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $value) ?? $value;
            $value = preg_replace('/javascript\s*:/i', '', $value) ?? $value;
            $value = strip_tags($value, '<h2><h3><p><ul><ol><li><strong><em><a>');

            return [$locale => mb_substr(trim($value), 0, 60000)];
        })->filter()->all();
    }
}
