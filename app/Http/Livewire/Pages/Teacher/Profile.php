<?php

namespace App\Http\Livewire\Pages\Teacher;

use Exception;
use App\Models\Lga;
use App\Models\State;
use App\Models\Teacher;
use Livewire\Component;
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

    public $teacher;
    public $state;
    public $lga;
    public $lgas = [];
    public $profile_photo;

    protected array $rules = [
        'teacher.fullname' => 'required|string',
        'teacher.email' => 'sometimes|email',
        'teacher.address' => 'sometimes',
        'teacher.phone_number' => 'sometimes|numeric',
        'teacher.gender' => 'required',
        'teacher.title' => 'required',
        'teacher.date_of_birth' => 'sometimes',
        'teacher.nationality_id' => 'sometimes',
        'state' => 'sometimes',
        'lga' => 'sometimes',
        'profile_photo' => 'sometimes',
//    'profile_photo' => 'sometimes|image|max:2048',
    ];

    protected array $validationAttributes = [
        'teacher.fullname' => 'fullname',
        'teacher.email' => 'email',
        'teacher.address' => 'address',
        'teacher.phone_number' => 'phone number',
        'teacher.gender' => 'gender',
        'teacher.title' => 'title',
        'teacher.date_of_birth' => 'date of birth',
        'teacher.nationality_id' => 'nationality',
        'profile_photo' => 'profile photo',
    ];

    public function render(): Factory|View|Application
    {
        $this->teacher = Teacher::where('id', auth()->id())->first();
        $d['nationalities'] = Nationality::get();
        $d['states'] = State::get();

        $this->state = !is_null($this->teacher->state_id) ? State::where('id', $this->teacher->state_id)->first()->id : '';
        $this->lga = !is_null($this->teacher->lga_id) ? Lga::where('id', $this->teacher->lga_id)->first()->id : '';

        if ($this->state) {
            $this->lgas = Lga::where('state_id', $this->state)->get();
        }

        return view('livewire.pages.teacher.profile', $d);
    }

    /**
     * @throws Exception
     */
    public function update(UpdateProfile $updateProfile): void
    {
        $this->validate();
        $updateProfile->updateTeacherProfile([$this->teacher->toArray(), $this->state, $this->lga], $this->profile_photo);

        $this->reset();
        $this->alert('success', 'Profile Updated Successfully');
    }
}
