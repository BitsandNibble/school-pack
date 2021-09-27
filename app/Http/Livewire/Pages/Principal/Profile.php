<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Actions\UpdateProfile;
use App\Models\Principal;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Profile extends Component
{
  public $principal;
  public $profile_photo;

  protected array $rules = [
    'principal.fullname' => 'required|string',
    'principal.email' => 'sometimes|email',
    'principal.phone_number' => 'sometimes|numeric',
    'profile_photo' => 'sometimes',
//    'profile_photo' => 'sometimes|image|max:2048',
  ];

  public function render(): Factory|View|Application
  {
    $this->principal = Principal::where('id', auth()->id())->first();

    return view('livewire.pages.principal.profile');
  }

  /**
   * @throws Exception
   */
  public function update(UpdateProfile $updateProfile): void
  {
    $val = $this->validate();
    $updateProfile->updatePrincipalProfile($val, $this->profile_photo);

    $this->reset();
    session()->flash('message', 'Profile Updated Successfully');
  }
}
