<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards): mixed
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }

            if ($guard === 'principal' && auth($guard)->check()) {
                return redirect(RouteServiceProvider::PRINCIPALHOME);
            }

            if ($guard === 'accountant' && auth($guard)->check()) {
                return redirect(RouteServiceProvider::ACCOUNTANTHOME);
            }

            if ($guard === 'teacher' && auth($guard)->check()) {
                return redirect(RouteServiceProvider::TEACHERHOME);
            }

            if ($guard === 'student' && auth($guard)->check()) {
                return redirect(RouteServiceProvider::STUDENTHOME);
            }

            if ($guard === 'parent' && auth($guard)->check()) {
                return redirect(RouteServiceProvider::PARENTHOME);
            }
        }

        return $next($request);
    }
}
