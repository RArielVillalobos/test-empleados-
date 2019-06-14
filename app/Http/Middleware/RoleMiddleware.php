<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //si el usuario es administrador
        if(auth()->user()->has_role(1)){
            return $next($request);
        }
        else{
            abort(401);
        }

    }
}
