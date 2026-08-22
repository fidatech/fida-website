<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRedirectRequest;
use App\Models\PageRedirect;
use App\Support\PageRedirects;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PageRedirectController extends Controller
{
    public function index(): View
    {
        return view('admin.redirects.index', [
            'redirects' => PageRedirect::query()->latest('updated_at')->paginate(30),
        ]);
    }

    public function store(PageRedirectRequest $request, PageRedirects $pageRedirects): RedirectResponse
    {
        try {
            $pageRedirects->upsert(...$this->arguments($request));
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->withErrors(['target_path' => $exception->getMessage()]);
        }

        return back()->with('success', 'Redirect created.');
    }

    public function update(PageRedirectRequest $request, PageRedirect $pageRedirect, PageRedirects $pageRedirects): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $pageRedirect, $pageRedirects): void {
                $oldSource = $pageRedirect->source_path;
                $updated = $pageRedirects->upsert(...$this->arguments($request));

                if ($oldSource !== $updated->source_path) {
                    $pageRedirect->delete();
                }
            });
        } catch (InvalidArgumentException $exception) {
            return back()->withInput()->withErrors(['target_path' => $exception->getMessage()]);
        }

        return back()->with('success', 'Redirect updated.');
    }

    public function destroy(PageRedirect $pageRedirect): RedirectResponse
    {
        $pageRedirect->delete();

        return back()->with('success', 'Redirect removed.');
    }

    private function arguments(PageRedirectRequest $request): array
    {
        $data = $request->validated();

        return [
            $data['source_path'],
            $data['target_path'],
            (int) $data['status_code'],
            (bool) $data['active'],
        ];
    }
}
