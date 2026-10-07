<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use App\Models\ContentPage;
use App\Services\AutoArticleService;
use App\Services\WebsiteContentAiService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class AutoArticleController extends Controller
{
    public function index(AutoArticleService $automation, WebsiteContentAiService $ai): View
    {
        return view('admin.auto-articles.index', [
            'settings' => $automation->settings(),
            'categories' => ArticleCategory::query()->where('active', true)->orderBy('sort_order')->get(),
            'aiConfigured' => $ai->configured(),
            'recent' => ContentPage::query()
                ->where('type', 'article')
                ->whereJsonContains('metadata->automation->generated', true)
                ->latest()
                ->limit(20)
                ->get(),
        ]);
    }

    public function update(Request $request, AutoArticleService $automation): RedirectResponse
    {
        $validated = $request->validate([
            'enabled' => ['nullable', 'boolean'],
            'auto_publish' => ['nullable', 'boolean'],
            'daily_time' => ['required', 'date_format:H:i'],
            'category_id' => ['nullable', 'exists:article_categories,id'],
            'themes' => ['required', 'string', 'max:3000'],
        ]);

        $automation->saveSettings([
            ...$validated,
            'enabled' => $request->boolean('enabled'),
            'auto_publish' => $request->boolean('auto_publish'),
        ]);

        return back()->with('success', 'Article automation settings updated.');
    }

    public function generate(Request $request, AutoArticleService $automation, WebsiteContentAiService $ai): RedirectResponse
    {
        try {
            $page = $automation->generate($ai, true);

            return redirect()->route('admin.content-pages.edit', $page)
                ->with('success', 'AI article generated. Review the multilingual draft before publishing.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors(['automation' => $exception->getMessage()]);
        }
    }
}
