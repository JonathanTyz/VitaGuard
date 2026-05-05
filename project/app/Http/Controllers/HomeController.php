<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        $articles = Article::latest()->take(5)->get();

        return view('landing', compact('articles'));
    }
}
