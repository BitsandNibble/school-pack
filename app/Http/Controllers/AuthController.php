<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function create()
  {
    return view('auth.login');
  }

  public function store(LoginRequest $request)
  {
//    $credentials = $request->only(['username', 'password']);

    $credentials = $request->validated();
//    $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    switch ($request->user_type) {
      case 'principal':
        auth('principal')->attempt($credentials);
        return redirect()->intended(RouteServiceProvider::PRINCIPALHOME);
        break;

      case 'teacher':
        auth('teacher')->attempt($credentials);
        return redirect()->intended(RouteServiceProvider::TEACHERHOME);
        break;

      case 'student':
        auth('student')->attempt($credentials);
        return redirect()->intended(RouteServiceProvider::STUDENTHOME);
        break;

      case 'parent':
        auth('parent')->attempt($credentials);
        return redirect()->intended(RouteServiceProvider::PARENTHOME);
        break;

      default:
        return back()->withErrors([
          'email' => 'The provided credentials do not match our records.',
        ]);
        break;
    }

  }

  public function destroy(Request $request)
  {
    if (auth('principal')->logout()) {
      $request->session()->invalidate();
      $request->session()->regenerateToken();
    } else if (auth('teacher')->logout()) {
      $request->session()->invalidate();
      $request->session()->regenerateToken();
    } else if (auth('student')->logout()) {
      $request->session()->invalidate();
      $request->session()->regenerateToken();
//    } else if (auth('parent')->logout()) {
//      $request->session()->invalidate();
//      $request->session()->regenerateToken();
    }

    return redirect(route('login'));
  }
}
