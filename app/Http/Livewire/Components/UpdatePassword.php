<?php

namespace App\Http\Livewire\Components;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Principal;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UpdatePassword extends Component
{
  use PasswordValidationRules;

  public $principal;

  public $validationAttributes = [
    'principal.current_password' => 'current password',
    'principal.password' => 'password',
    'principal.password_confirmation' => 'password',
  ];

  public function render()
  {
    return view('livewire.components.update-password');
  }

  public function updatePrincipalPassword()
  {
    $this->validate([
      'principal.current_password' => 'required',
      'principal.password' => 'required|min:6',
      'principal.password_confirmation' => 'required',
    ]);

    $principal = Principal::where('id', auth()->id());
    $principal->update([
      'password' => Hash::make($this->principal['password_confirmation'])
    ]);
    session()->flash('message', 'Password Updated Successfully');
  }
}
