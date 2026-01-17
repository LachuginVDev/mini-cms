<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{

    public function index()
    {
        $posts = Post::published()->latest()->limit(6)->get();
        return view('home', compact('posts'));
    }
}
