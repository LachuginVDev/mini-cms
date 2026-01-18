<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'is_approved' => true,
        ]);

        return redirect()
            ->route('posts.show', $post->slug)
            ->with('success', 'Комментарий успешно добавлен');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        // Разрешаем удалять только свои комментарии или админу
        if (Auth::id() !== $comment->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $post = $comment->post;
        $comment->delete();

        return redirect()
            ->route('posts.show', $post->slug)
            ->with('success', 'Комментарий успешно удален');
    }
}
