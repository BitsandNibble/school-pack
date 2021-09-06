<?php

namespace App\Http\Livewire\Component;

use App\Providers\RouteServiceProvider;
use Livewire\Component;

class Login extends Component
{
  public $auth, $type;

  public $validationAttributes = [
    'auth.email' => 'email',
    'auth.password' => 'password'
  ];

  public function render()
  {
    return view('livewire.component.login')->layout('layouts.guest');
  }

  public function login()
  {
    $this->validate([
      'auth.email' => 'required|email',
      'auth.password' => 'required',
    ]);

    // dd($this->auth);
    switch ($this->type) {
      case 'principal':
        auth('principal')->attempt($this->auth);
        return redirect()->intended(RouteServiceProvider::PRINCIPALHOME);
        break;

      case 'teacher':
        auth('teacher')->attempt($this->auth);
        return redirect()->intended(RouteServiceProvider::TEACHERHOME);
        break;

      case 'student':
        auth('student')->attempt($this->auth);
        return redirect()->intended(RouteServiceProvider::STUDENTHOME);
        break;

      case 'parent':
        auth('parent')->attempt($this->auth);
        return redirect()->intended(RouteServiceProvider::PARENTHOME);
        break;

      default:
        return back()->withErrors([
          'email' => 'The provided credentials do not match our records.',
        ]);
        break;
    }
  }
}
