<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Logout extends Component
{
  public function render()
  {
    return view('livewire.components.logout');
  }

  public function logout()
  {
    auth('principal')->logout();

    return redirect(route('login'));
  }
}
