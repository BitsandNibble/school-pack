<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotPrincipal
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = "principal")
    {
        if (!auth()->guard($guard)->check()) {
            return redirect(route('login'));
        }
        return $next($request);
    }
}
