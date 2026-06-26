<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    // Разрешение заполнять эти поля через create()
    protected $fillable = [
        'title',
        'slug',
        'body',
        'category_id',
        'user_id',
        'cover_image',
        'is_published',
    ];
    
    // Пост принадлежит пользователю (автору)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Пост принадлежит категории
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // У поста много комментариев
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // У поста много тегов
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
