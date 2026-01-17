<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');
        Route::resource('posts', AdminPostController::class);
    });
