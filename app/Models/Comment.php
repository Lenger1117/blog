<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Разрешение заполнения полей
    protected $fillable = [
        'body',
        'user_id',
        'post_id'
    ];
    
    // Комментарий принадлежит пользователю
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Комментарий принадлежит посту
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
