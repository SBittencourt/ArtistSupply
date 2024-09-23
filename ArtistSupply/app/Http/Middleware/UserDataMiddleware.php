<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserDataMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            view()->share('user', Auth::user());
        }

        return $next($request);
    }
}

