<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);
        $posts = Post::with('user')->latest()->paginate(15);
        $comments = Comment::with(['user', 'post'])->latest()->paginate(15);

        return view('admin.dashboard', compact('users', 'posts', 'comments'));
    }

    public function banUser(User $user)
    {
        // Простая логика "бана": делаем пользователя не-админом или блокируем
        // Для примера просто удалим его (в реальном проекте лучше поле is_banned)
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Нельзя забанить самого себя!');
        }
        
        $user->delete(); 
        return back()->with('success', 'Пользователь удален/забанен.');
    }
}