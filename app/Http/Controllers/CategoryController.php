<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Список всех категорий
    public function index() {
        $categories = Category::withCount('posts')->get();
        return view('categories.index', compact('categories'));
    }
    // Получение постов конкретной категории с пагинацией
    public function show(Category $category) {
        $posts = $category->posts()
                          ->where('is_published', true)
                          ->with(['user', 'category'])
                          ->latest()
                          ->paginate(10);
        
        return view('categories.show', compact('category', 'posts'));
    }
}
