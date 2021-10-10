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
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
  use WithFileUploads;

  public $student;
  public $profile_photo;

  protected array $rules = [
    'student.fullname' => 'required|string',
    'student.email' => 'sometimes|email',
    'student.address' => 'sometimes',
    'student.phone_number' => 'sometimes|numeric',
    'student.gender' => 'required',
    'student.nationality_id' => 'sometimes',
    'student.state_id' => 'sometimes',
    'student.lga_id' => 'sometimes',
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
    'student.state_id' => 'state',
    'student.lga_id' => 'lga',
    'student.date_of_birth' => 'date of birth',
    'profile_photo' => 'profile photo',
  ];

  public function render(): Factory|View|Application
  {
    $this->student = Student::where('id', auth()->id())->first();
    $d['nationalities'] = Nationality::get();
    $d['states'] = State::get();
    $d['lgas'] = Lga::get();

    return view('livewire.pages.student.profile', $d);
  }

  /**
   * @throws Exception
   */
  public function update(UpdateProfile $updateProfile): void
  {
    $this->validate();
    $updateProfile->updateStudentProfile($this->student->toArray(), $this->profile_photo);

    $this->reset();
    session()->flash('message', 'Profile Updated Successfully');
  }
}
