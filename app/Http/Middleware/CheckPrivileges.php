<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckPrivileges
{
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->isAdmin()){
            abort(403, "No tienes permiso para entrar");
        }
        return $next($request);
    }
}
