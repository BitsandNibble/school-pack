<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Principal;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
  use WithFileUploads;

  public $principal;
  public $profile_photo;

  protected array $rules = [
    'principal.fullname' => 'required|string',
    'principal.email' => 'sometimes|email',
    'principal.phone_number' => 'sometimes|numeric',
    'profile_photo' => 'sometimes',
//    'profile_photo' => 'sometimes|image|max:2048',
  ];

  protected array $validationAttributes = [
    'principal.fullname' => 'fullname',
    'principal.email' => 'email',
    'principal.phone_number' => 'phone number',
    'profile_photo' => 'profile photo',
  ];

  public function render(): Factory|View|Application
  {
    $this->principal = Principal::where('id', auth()->id())->first();

    return view('livewire.pages.principal.profile');
  }

  public function updatePrincipalProfile(): void
  {
    $this->validate();

    $updatePrincipal = Principal::find(auth()->id());
    $updatePrincipal->update([
      'fullname' => $this->principal['fullname'],
      'email' => $this->principal['email'],
      'phone_number' => $this->principal['phone_number'],
      'profile_photo' => $this->profile_photo ? $this->handleAvatarUpload() : $this->principal['profile_photo'],
    ]);
    $this->reset();

    session()->flash('message', 'Profile Updated Successfully');
  }

  /**
   * @throws Exception
   */
  public function handleAvatarUpload(): string
  {
    $photo = $this->profile_photo;
    $name = random_int(1000, 9999) . '_' . $photo->getClientOriginalName();
    $photo->storeAs('public/profile-photos', $name);
    return $name;
  }
}
