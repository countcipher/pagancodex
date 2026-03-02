<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        abort_if(request()->user()->role < 10, 403, 'Unauthorized action.');

        $articles = request()->user()->articles()->latest()->get();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        abort_if(request()->user()->role < 10, 403, 'Unauthorized action.');

        return view('articles.create');
    }
}
