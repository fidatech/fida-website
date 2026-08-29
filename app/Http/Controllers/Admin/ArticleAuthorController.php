<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleAuthorRequest;
use App\Models\ArticleAuthor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ArticleAuthorController extends Controller
{
    public function index(): View
    {
        $authors = ArticleAuthor::query()
            ->withCount(['articles' => fn ($query) => $query->where('type', 'article')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.article-authors.index', compact('authors'));
    }

    public function create(): View
    {
        return view('admin.article-authors.create', ['articleAuthor' => new ArticleAuthor]);
    }

    public function store(ArticleAuthorRequest $request): RedirectResponse
    {
        $author = ArticleAuthor::query()->create($request->validated());

        return redirect()->route('admin.article-authors.edit', $author)->with('success', 'Article author created.');
    }

    public function edit(ArticleAuthor $articleAuthor): View
    {
        return view('admin.article-authors.edit', compact('articleAuthor'));
    }

    public function update(ArticleAuthorRequest $request, ArticleAuthor $articleAuthor): RedirectResponse
    {
        $articleAuthor->update($request->validated());

        return back()->with('success', 'Article author updated.');
    }

    public function destroy(ArticleAuthor $articleAuthor): RedirectResponse
    {
        abort_if($articleAuthor->articles()->exists(), 422, 'Move the linked articles before deleting this author.');
        $articleAuthor->delete();

        return redirect()->route('admin.article-authors.index')->with('success', 'Article author deleted.');
    }
}
