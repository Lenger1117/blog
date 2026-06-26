<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
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
