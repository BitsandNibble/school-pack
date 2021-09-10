<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Principal;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
  use WithFileUploads;

  public $principal, $profile_photo;

  protected $rules = [
    'principal.fullname' => 'required|string',
    'principal.email' => 'sometimes|email',
    'principal.phone_number' => 'sometimes|numeric',
    'profile_photo' => 'sometimes',
//    'profile_photo' => 'sometimes|image|max:2048',
  ];

  protected $validationAttributes = [
    'principal.fullname' => 'fullname',
    'principal.email' => 'email',
    'principal.phone_number' => 'phone number',
    'profile_photo' => 'profile photo',
  ];

  public function render()
  {
    $this->principal = Principal::where('id', auth()->id())->first();

    return view('livewire.pages.principal.profile');
  }

  public function updatePrincipalProfile(): void
  {
    $this->validate();

    $updatePrincipal = Principal::find(auth()->id());
    $updatePrincipal->update([
      'profile_photo' => $this->handleAvatarUpload(),
      'fullname' => $this->principal['fullname'],
      'email' => $this->principal['email'],
      'phone_number' => $this->principal['phone_number'],
    ]);
    $this->reset();

    session()->flash('message', 'Profile Updated Successfully');
  }

  public function handleAvatarUpload()
  {
    $photo = $this->profile_photo;
    $name = mt_rand(1000, 9999) . '_' . $photo->getClientOriginalName();
    $photo->storeAs('public/profile-photos', $name);
    return $name;
  }
}
