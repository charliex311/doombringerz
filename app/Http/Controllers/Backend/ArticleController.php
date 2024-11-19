<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $articles->where('title_', 'LIKE', "%{$search}%");
        }

        $articles = $articles->latest()->paginate();

        return view('backend.pages.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.articles.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['image'] = $request->image->store('images', 'public');
        if ($request->add_image !== NULL) $data['add_image'] = $request->add_image->store('images', 'public');
        $this->alert('success', __('Новость успешно добавлена'));

        Article::create($data);
        return redirect()->route('articles.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('backend.pages.articles.form', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            Storage::disk('public')->delete($article->image);
            Storage::disk('public')->delete($article->add_image);
            $data['image'] = $request->image->store('images', 'public');
            if ($request->add_image !== NULL) $data['add_image'] = $request->add_image->store('images', 'public');
        }

        $this->alert('success', __('Новость успешно обновлена'));
        $article->update($data);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->alert('success', __('Новость успешно удалена'));
        Storage::disk('public')->delete($article->image);
        Storage::disk('public')->delete($article->add_image);
        $article->delete();
        return back();
    }
}
