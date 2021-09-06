<?php

namespace App\Http\Livewire\Components;

use App\Models\Principal;
use Livewire\Component;

class Profile extends Component
{
  public $principal;

  protected $rules = [
    'principal.fullname' => 'required|string',
    'principal.email' => 'sometimes|email',
    'principal.phone_number' => 'sometimes|numeric',
    'principal.profile_photo' => 'sometimes|image|max:2048',
  ];

  protected $validationAttributes = [
    'principal.fullname' => 'fullname',
    'principal.email' => 'email',
    'principal.phone_number' => 'phone number',
    'principal.profile_photo' => 'profile photo',
  ];

  public function render()
  {
    $this->principal = Principal::where('id', auth()->id())->first();

    return view('livewire.components.profile');
  }

  public function updatePrincipalProfile()
  {
    $this->validate();

    $updatePrincipal = Principal::find(auth()->id());
    $updatePrincipal->forceFill([
      'fullname' => $this->principal['fullname'],
      'email' => $this->principal['email'],
      'phone_number' => $this->principal['phone_number'],
      'profile_photo' => $this->principal['profile_photo'] ?? ''
    ])->save();

    session()->flash('message', 'Profile Updated Successfully');
  }
}
