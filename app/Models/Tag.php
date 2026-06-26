<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // У тега много постов (и наоборот)
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
