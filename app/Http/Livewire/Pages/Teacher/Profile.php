<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Actions\UpdateProfile;
use App\Models\Teacher;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
  use WithFileUploads;

  public $teacher;
  public $profile_photo;

  protected array $rules = [
    'teacher.fullname' => 'required|string',
    'teacher.email' => 'sometimes|email',
    'teacher.phone_number' => 'sometimes|numeric',
    'teacher.gender' => 'required',
    'teacher.title' => 'required',
    'teacher.date_of_birth' => 'sometimes',
    'profile_photo' => 'sometimes',
//    'profile_photo' => 'sometimes|image|max:2048',
  ];

  protected array $validationAttributes = [
    'teacher.fullname' => 'fullname',
    'teacher.email' => 'email',
    'teacher.phone_number' => 'phone number',
    'teacher.gender' => 'gender',
    'teacher.title' => 'title',
    'teacher.date_of_birth' => 'date of birth',
    'profile_photo' => 'profile photo',
  ];

  public function render(): Factory|View|Application
  {
    $this->teacher = Teacher::where('id', auth()->id())->first();

    return view('livewire.pages.teacher.profile');
  }

  /**
   * @throws Exception
   */
  public function update(UpdateProfile $updateProfile): void
  {
    $val = $this->validate();
    $updateProfile->updateTeacherProfile($val, $this->profile_photo);

    $this->reset();
    session()->flash('message', 'Profile Updated Successfully');
  }
}
