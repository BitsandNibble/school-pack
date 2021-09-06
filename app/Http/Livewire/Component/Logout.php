<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class Logout extends Component
{
  public function render()
  {
    return view('livewire.component.logout');
  }

  public function logout()
  {
    auth('principal')->logout();

    return redirect(route('login'));
  }
}
