<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Actions\UpdateProfile;
use App\Models\Lga;
use App\Models\Nationality;
use App\Models\Principal;
use App\Models\State;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
  use WithFileUploads;
  use LivewireAlert;

  public $principal;
  public $profile_photo;

  protected array $rules = [
    'principal.fullname' => 'required|string',
    'principal.email' => 'sometimes|email',
    'principal.address' => 'sometimes',
    'principal.phone_number' => 'sometimes|numeric',
    'principal.nationality_id' => 'sometimes',
    'principal.state_id' => 'sometimes',
    'principal.lga_id' => 'sometimes',
    'profile_photo' => 'sometimes',
//    'profile_photo' => 'sometimes|image|max:2048',
  ];

  protected array $validationAttributes = [
    'principal.nationality_id' => 'nationality',
    'principal.state_id' => 'state',
    'principal.lga_id' => 'lga',
  ];

  public function render(): Factory|View|Application
  {
    $this->principal = Principal::where('id', auth()->id())->first();
    $d['nationalities'] = Nationality::get();
    $d['states'] = State::get();
    $d['lgas'] = Lga::get();

    return view('livewire.pages.principal.profile', $d);
  }

  /**
   * @throws Exception
   */
  public function update(UpdateProfile $updateProfile): void
  {
    $this->validate();
    $updateProfile->updatePrincipalProfile($this->principal->toArray(), $this->profile_photo);

    $this->reset();
    $this->alert('success', 'Profile Updated Successfully');
  }
}
