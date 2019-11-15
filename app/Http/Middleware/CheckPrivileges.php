<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckPrivileges
{
    public function handle($request, Closure $next, ... $roles)
    {
        foreach ($roles as $role){
            if (Auth::user()->hasRole($role)){
                return $next($request);
            }
        }
        abort(403, "No tienes permiso para entrar");
    }
}
