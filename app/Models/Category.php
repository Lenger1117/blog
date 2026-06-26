<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Разрешение массового заполнения этих полей
    protected $fillable = [
        'name',
        'slug',
    ];
    // У категории много постов
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
