<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Отобразить список постов
     */
    public function index()
    {
        // Получение всех опубликованных постов (сортировка по новизне)
        $posts = Post::where('is_published', true)
            ->with(['user', 'category', 'tags'])
            ->latest()
            ->paginate(10);
        
            return view('posts.index', compact('posts'));
    }

    /**
     * Отобразить форму для создания нового поста
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Сохранить созданный пост в хранилище
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
        // Обработка изображения (если есть)
        $path = null;
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
        }

        // Создание поста
        Post::create([
            'title' => $validated['title'],
            'slug' => $this->generateUniqueSlug($validated['title']),
            'body' => $validated['body'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'cover_image' => $path,
            'is_published' => true,
        ]);
        return redirect()->route('posts.index') ->with('success', 'Статья успешно создана');
    }

    /**
     * Отобразить указанный пост
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
     * Отобразить форму для редактирования указанного поста
     */
    public function edit(Post $post)
    {
        // Проверка прав: может ли текущий пользователь редактировать этот пост?
        $this->authorize('update', $post);

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Обновить указанный пост
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Если загружена новое изображение
        if ($request->hasFile('cover_image')) {
            // Удаляем старое изображение, если оно есть
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        // Обновление slug, если изменился заголовок
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        $post->update($validated);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Статья обновлена!');
    }

    /**
     * Удалить указанный пост
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        // Удаляем изображение при удалении поста
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Статья удалена.');
    }

    /**
     * Генерация уникального slug
     */
    private function generateUniqueSlug(string $title): string
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Проверка, есть ли уже такой slug в базе
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
