<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Определить, может ли пользователь обновить модель.
     */
    public function update(User $user, Post $post): bool
    {
        // Редактировать может только автор или админ
        return $user->id === $post->user_id || $user->is_admin;
    }

    /**
     * Определить, может ли пользователь удалить модель.
     */
    public function delete(User $user, Post $post): bool
    {
        // Удалять может только автор или админ
        return $user->id === $post->user_id || $user->is_admin;
    }
}
