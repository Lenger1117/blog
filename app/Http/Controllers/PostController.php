<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получение всех опубликованных постов (сортировка по новизне)
        $posts = Post::where('is_published', true)
            ->with(['user', 'category'])
            ->latest()
            ->paginate(10);
        
            return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cover_imade' => 'nullable|imade|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Обработка картинка (если есть)
        $path = null;
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
        }

        // Создание поста
        Post::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'cover_image' => $path,
            'is_published' => true,
        ]);
        return redirect()->route('post.index') ->with('success', 'Статья успешно создана');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        // Поиск поста по slug
        $post = Post::where('slug', $slug)
            ->with(['user', 'category', 'comments.user'])
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
