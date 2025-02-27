<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class AuthController extends Controller
{
    public function create(): Factory|View|Application
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if ($request->user_type === 'principal' && auth('principal')->attempt($credentials)) {
            return redirect()->intended(RouteServiceProvider::PRINCIPALHOME);
        }

        if ($request->user_type === 'accountant' && auth('accountant')->attempt($credentials)) {
            return redirect()->intended(RouteServiceProvider::ACCOUNTANTHOME);
        }

        if ($request->user_type === 'teacher' && auth('teacher')->attempt($credentials)) {
            return redirect()->intended(RouteServiceProvider::TEACHERHOME);
        }

        if ($request->user_type === 'student' && auth('student')->attempt($credentials)) {
            return redirect()->intended(RouteServiceProvider::STUDENTHOME);
        }

        if ($request->user_type === 'parent' && auth('parent')->attempt($credentials)) {
            return redirect()->intended(RouteServiceProvider::PARENTHOME);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy(Request $request): Redirector|Application|RedirectResponse
    {
        if (auth('principal')?->logout()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if (auth('accountant')?->logout()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if (auth('teacher')?->logout()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if (auth('student')?->logout()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
//    } else if (auth('parent')->logout()) {
//      $request->session()->invalidate();
//      $request->session()->regenerateToken();
        }

        return redirect(route('login'));
    }
}
