<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::latest()->paginate(15);
        return view('user.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('user.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->route('user.categories.index')
            ->with('success', 'Категория успешно создана');
    }

    public function edit(Category $category): View
    {
        return view('user.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->route('user.categories.index')
            ->with('success', 'Категория успешно обновлена');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->posts()->count() > 0) {
            return redirect()->route('user.categories.index')
                ->with('error', 'Нельзя удалить категорию, в которой есть посты');
        }

        $category->delete();

        return redirect()->route('user.categories.index')
            ->with('success', 'Категория успешно удалена');
    }
}
