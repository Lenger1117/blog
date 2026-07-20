<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Сохранение нового комментария
    public function store(Request $request, Post $post) {
        // Валидация
        $validated = $request->validate([
            'body' => 'required|string|min:5',
        ]);

        // Создание комментария
        Comment::create([
            'body' => $validated['body'],
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return redirect()->back()->with('success', 'Комментария добавлен.');
    }

    // Удаление комментария
    public function destroy(Comment $comment) {
        // Проверка прав на удаление (пока только автор комментария)
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий удален.');
    }
}
