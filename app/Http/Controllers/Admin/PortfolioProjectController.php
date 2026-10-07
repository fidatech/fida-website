<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ContentPage;
use App\Models\PortfolioProject;
use App\Models\ProjectScreenshot;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = PortfolioProject::query()
            ->with('client')->withCount(['screenshots','contracts'])
            ->when($request->filled('search'), function ($query) use ($request): void {
                $term = '%'.trim((string) $request->string('search')).'%';
                $query->where(fn ($q) => $q->where('name','like',$term)->orWhere('project_type','like',$term));
            })
            ->latest('updated_at')->paginate(25)->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return $this->formView(new PortfolioProject());
    }

    public function store(Request $request): RedirectResponse
    {
        $project = PortfolioProject::query()->create($this->validated($request));

        return redirect()->route('admin.projects.edit', $project)->with('success', 'Project added. You can upload screenshots now.');
    }

    public function edit(PortfolioProject $project): View
    {
        $project->load(['screenshots','client','contracts']);

        return $this->formView($project);
    }

    public function update(Request $request, PortfolioProject $project): RedirectResponse
    {
        $project->update($this->validated($request, $project));

        return back()->with('success', 'Project updated.');
    }

    public function uploadScreenshots(Request $request, PortfolioProject $project): RedirectResponse
    {
        $request->validate([
            'screenshots'=>['required','array','min:1','max:20'],
            'screenshots.*'=>['image','mimes:jpg,jpeg,png,webp','max:10240'],
        ]);

        $next = (int) ($project->screenshots()->max('sort_order') ?? 0);

        foreach ($request->file('screenshots', []) as $file) {
            $path = $file->store('projects/'.$project->id, 'public');
            $project->screenshots()->create([
                'disk'=>'public',
                'path'=>$path,
                'sort_order'=>++$next,
            ]);
        }

        return back()->with('success', 'Project screenshots uploaded.');
    }

    public function screenshot(ProjectScreenshot $projectScreenshot)
    {
        abort_unless(Storage::disk($projectScreenshot->disk)->exists($projectScreenshot->path), 404);

        return Storage::disk($projectScreenshot->disk)->response($projectScreenshot->path);
    }

    public function destroyScreenshot(ProjectScreenshot $projectScreenshot): RedirectResponse
    {
        Storage::disk($projectScreenshot->disk)->delete($projectScreenshot->path);
        $projectScreenshot->delete();

        return back()->with('success', 'Screenshot removed.');
    }

    private function formView(PortfolioProject $project): View
    {
        return view('admin.projects.form', [
            'project' => $project,
            'clients' => Client::query()->orderBy('name')->get(),
            'contentPages' => ContentPage::query()->whereIn('type',['product','case-study'])->orderBy('title->en')->get(['id','title','slug','type']),
        ]);
    }

    private function validated(Request $request, ?PortfolioProject $project = null): array
    {
        $data = $request->validate([
            'client_id'=>['nullable','exists:clients,id'],
            'name'=>['required','string','max:190'],
            'slug'=>['nullable','string','max:190','regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/','unique:portfolio_projects,slug,'.($project?->id ?? 'NULL')],
            'project_type'=>['nullable','string','max:120'],
            'status'=>['required','in:planning,active,on_hold,completed,maintenance,archived'],
            'started_at'=>['nullable','date'],
            'completed_at'=>['nullable','date','after_or_equal:started_at'],
            'technologies_text'=>['nullable','string','max:3000'],
            'summary'=>['nullable','string','max:3000'],
            'description'=>['nullable','string','max:12000'],
            'live_url'=>['nullable','url:http,https','max:512'],
            'repository_url'=>['nullable','url:http,https','max:512'],
            'public'=>['nullable','boolean'],
            'content_page_id'=>['nullable','exists:content_pages,id'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['technologies'] = collect(preg_split('/[,\n]+/', (string) ($data['technologies_text'] ?? '')))
            ->map(fn ($item) => trim((string) $item))->filter()->unique()->values()->all();
        $data['public'] = $request->boolean('public');
        unset($data['technologies_text']);

        return $data;
    }
}
