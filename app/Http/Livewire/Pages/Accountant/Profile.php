<?php

namespace App\Http\Livewire\Pages\Accountant;

use Exception;
use App\Models\Lga;
use App\Models\State;
use Livewire\Component;
use App\Models\Accountant;
use App\Models\Nationality;
use Livewire\WithFileUploads;
use App\Actions\UpdateProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

class Profile extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $accountant;
    public $state;
    public $lga;
    public $lgas = [];
    public $profile_photo;

    protected array $rules = [
        'accountant.fullname' => 'required|string',
        'accountant.email' => 'sometimes|email',
        'accountant.address' => 'sometimes',
        'accountant.phone_number' => 'sometimes|numeric',
        'accountant.gender' => 'required',
        'accountant.title' => 'required',
        'accountant.date_of_birth' => 'sometimes',
        'accountant.nationality_id' => 'sometimes',
        'state' => 'sometimes',
        'lga' => 'sometimes',
        'profile_photo' => 'sometimes',
//    'profile_photo' => 'sometimes|image|max:2048',
    ];

    protected array $validationAttributes = [
        'accountant.fullname' => 'fullname',
        'accountant.email' => 'email',
        'accountant.address' => 'address',
        'accountant.phone_number' => 'phone number',
        'accountant.gender' => 'gender',
        'accountant.title' => 'title',
        'accountant.date_of_birth' => 'date of birth',
        'accountant.nationality_id' => 'nationality',
        'profile_photo' => 'profile photo',
    ];

    public function render(): Factory|View|Application
    {
        $this->accountant = Accountant::where('id', auth()->id())->first();
        $d['nationalities'] = Nationality::get();
        $d['states'] = State::get();

        $this->state = !is_null($this->accountant->state_id) ? State::where('id', $this->accountant->state_id)->first()->id : '';
        $this->lga = !is_null($this->accountant->lga_id) ? Lga::where('id', $this->accountant->lga_id)->first()->id : '';

        if ($this->state) {
            $this->lgas = Lga::where('state_id', $this->state)->get();
        }

        return view('livewire.pages.accountant.profile', $d);
    }

    /**
     * @throws Exception
     */
    public function update(UpdateProfile $updateProfile): void
    {
        $this->validate();
        $updateProfile->updateAccountantProfile([$this->accountant->toArray(), $this->state, $this->lga], $this->profile_photo);

        $this->reset();
        $this->alert('success', 'Profile Updated Successfully');
    }
}
