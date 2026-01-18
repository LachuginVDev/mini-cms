<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\User\PostController as UserPostController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Комментарии
Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');
        Route::resource('posts', AdminPostController::class);
        Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::patch('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });

/*
|--------------------------------------------------------------------------
| User Dashboard / Личный кабинет
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Личный кабинет - управление постами и категориями пользователя
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', fn () => redirect()->route('user.posts.index'))->name('dashboard');
        Route::resource('posts', UserPostController::class);
        Route::resource('categories', UserCategoryController::class);
    });

    // Профиль пользователя
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
