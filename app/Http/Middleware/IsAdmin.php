<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Проверка: авторизован ли пользователь и является ли он админом
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Доступ только для администраторов.');
        }

        return $next($request);
    }
}
