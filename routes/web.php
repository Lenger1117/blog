<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Роуты для постов
    Route::resource('posts', PostController::class)->only([
        'create', 
        'store', 
        'index', 
        'show', 
        'edit',
        'update',
        'destroy'
    ]);

    // Роуты для комментариев
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Роуты для категорий
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

    // Роуты для админов
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function (){
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::delete('/users/{user}', [DashboardController::class, 'banUser'])->name('admin.banUser');
    });
});

require __DIR__.'/auth.php';
