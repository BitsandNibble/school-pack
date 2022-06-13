<?php

namespace App\Http\Livewire\Pages\Principal;

use Exception;
use App\Models\Lga;
use App\Models\State;
use Livewire\Component;
use App\Models\Principal;
use App\Models\Nationality;
use Livewire\WithFileUploads;
use App\Actions\UserProfileAction;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

class Profile extends Component
{
	use LivewireAlert;
	use WithFileUploads;

	public $principal;
	public $profile_photo;

	protected array $rules = [
		'principal.fullname'       => 'required|string',
		'principal.email'          => 'sometimes|email',
		'principal.address'        => 'sometimes',
		'principal.phone_number'   => 'sometimes|numeric',
		'principal.nationality_id' => 'sometimes',
		'principal.state_id'       => 'sometimes',
		'principal.lga_id'         => 'sometimes',
		'profile_photo'            => 'sometimes',
		//    'profile_photo' => 'sometimes|image|max:2048',
	];

	protected array $validationAttributes = [
		'principal.nationality_id' => 'nationality',
		'principal.state_id'       => 'state',
		'principal.lga_id'         => 'lga',
	];

	public function render(): Factory|View|Application
	{
		$this->principal 	= Principal::query()->find(auth()->id());
		$d['nationalities'] = Nationality::query()->get();
		$d['states']        = State::query()->get();
		$d['lgas']          = Lga::query()->get();

		return view('livewire.pages.principal.profile', $d);
	}

	/**
	 * @throws Exception
	 */
	public function update(UserProfileAction $userProfileAction): void
	{
		$this->validate();
		$userProfileAction->updatePrincipalProfile($this->principal->toArray(), $this->profile_photo);

		$this->reset();
		$this->alert('success', 'Profile Updated Successfully');
	}
}
