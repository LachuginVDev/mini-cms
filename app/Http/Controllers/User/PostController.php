<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('user.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('user.posts.create', compact('categories'));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $data['image'] = Storage::url($imagePath);
        }

        Post::create([
            ...$data,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('user.posts.index')
            ->with('success', 'Пост успешно создан');
    }

    public function show(Post $post): View
    {
        if (Auth::id() !== $post->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $post->load('category', 'comments.user');
        return view('user.posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        if (Auth::id() !== $post->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        return view('user.posts.edit', compact('post', 'categories'));
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        if (Auth::id() !== $post->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image) {
                $oldPath = str_replace('/storage/', '', parse_url($post->image, PHP_URL_PATH));
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $imagePath = $request->file('image')->store('posts', 'public');
            $data['image'] = Storage::url($imagePath);
        }

        $post->update($data);

        return redirect()->route('user.posts.index')
            ->with('success', 'Пост успешно обновлен');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if (Auth::id() !== $post->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('user.posts.index')
            ->with('success', 'Пост успешно удален');
    }
}
