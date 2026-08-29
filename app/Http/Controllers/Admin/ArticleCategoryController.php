<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleCategoryRequest;
use App\Models\ArticleCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ArticleCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ArticleCategory::query()
            ->withCount(['articles' => fn ($query) => $query->where('type', 'article')])
            ->orderBy('sort_order')
            ->orderBy('name->en')
            ->get();

        return view('admin.article-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.article-categories.create', ['articleCategory' => new ArticleCategory]);
    }

    public function store(ArticleCategoryRequest $request): RedirectResponse
    {
        $category = ArticleCategory::query()->create($request->validated());

        return redirect()->route('admin.article-categories.edit', $category)->with('success', 'Article category created.');
    }

    public function edit(ArticleCategory $articleCategory): View
    {
        return view('admin.article-categories.edit', compact('articleCategory'));
    }

    public function update(ArticleCategoryRequest $request, ArticleCategory $articleCategory): RedirectResponse
    {
        $articleCategory->update($request->validated());

        return back()->with('success', 'Article category updated.');
    }

    public function destroy(ArticleCategory $articleCategory): RedirectResponse
    {
        abort_if($articleCategory->articles()->exists(), 422, 'Move the linked articles before deleting this category.');
        $articleCategory->delete();

        return redirect()->route('admin.article-categories.index')->with('success', 'Article category deleted.');
    }
}
