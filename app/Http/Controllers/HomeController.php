<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $bannerTitle = Setting::get('banner_title', 'Добро пожаловать');
        $bannerSubtitle = Setting::get('banner_subtitle', 'Начните создавать удивительные посты');
        $bannerImage = Setting::get('banner_image');
        $posts = Post::published()->latest()->limit(9)->get();

        return view('home', compact('posts', 'bannerTitle', 'bannerSubtitle', 'bannerImage'));
    }
}
