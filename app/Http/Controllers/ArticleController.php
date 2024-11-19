<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        if (isset(auth()->user()->role) && auth()->user()->role == 'admin') {
            $articles = Article::where('type', 'news');
        } else {
            $articles = Article::where('type', 'news');
        }

        $articles = $articles->latest()->limit(6)->paginate(6);

        return view('pages.main.news.list', compact('articles'));
    }

    public function show(Article $article)
    {
        if ((!isset(auth()->user()->role) || auth()->user()->role != 'admin') && $article->status == 0) {
            abort(404);
        }

        return view('pages.main.news.full', compact('article'));
    }

    public function more(Request $request)
    {
        $page = $request->page ?: 1;
        if (isset(auth()->user()->role) && auth()->user()->role == 'admin') {
            $articles = Article::where('type', 'news');
        } else {
            $articles = Article::where('type', 'news');
        }
        $articles = $articles->latest()->limit(6)->paginate(6, ['*'], 'page', $page);

        return view('pages.main.news.list-more', compact('articles'));
    }

}
