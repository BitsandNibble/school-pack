<?php

namespace App\Http\Livewire\Pages\Student;

use App\Actions\UpdateProfile;
use App\Models\Lga;
use App\Models\Nationality;
use App\Models\State;
use App\Models\Student;
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

  public $student;
  public $state;
  public $lga;
  public $lgas = [];
  public $profile_photo;

  protected array $rules = [
    'student.fullname' => 'required|string',
    'student.email' => 'sometimes|email',
    'student.address' => 'sometimes',
    'student.phone_number' => 'sometimes|numeric',
    'student.gender' => 'required',
    'student.nationality_id' => 'sometimes',
    'state' => 'sometimes',
    'lga' => 'sometimes',
    'student.date_of_birth' => 'sometimes',
    'profile_photo' => 'sometimes',
//    'profile_photo' => 'sometimes|image|max:2048',
  ];

  protected array $validationAttributes = [
    'student.fullname' => 'fullname',
    'student.address' => 'address',
    'student.email' => 'email',
    'student.phone_number' => 'phone number',
    'student.gender' => 'gender',
    'student.nationality_id' => 'nationality',
    'student.date_of_birth' => 'date of birth',
    'profile_photo' => 'profile photo',
  ];

  public function render(): Factory|View|Application
  {
    $this->student = Student::where('id', auth()->id())->first();
    $d['nationalities'] = Nationality::get();
    $d['states'] = State::get();

    $this->state = State::where('id', $this->student->state_id)->first()->id;
    $this->lga = Lga::where('id', $this->student->lga_id)->first()->id;

    if ($this->state) {
      $this->lgas = Lga::where('state_id', $this->state)->get();
    }

    return view('livewire.pages.student.profile', $d);
  }

  /**
   * @throws Exception
   */
  public function update(UpdateProfile $updateProfile): void
  {
    $this->validate();
    $updateProfile->updateStudentProfile([$this->student->toArray(), $this->state, $this->lga], $this->profile_photo);

    $this->reset();
    $this->alert('success', 'Profile Updated Successfully');
  }
}
