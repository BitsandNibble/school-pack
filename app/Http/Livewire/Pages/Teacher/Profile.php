<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\Teacher;
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

  public function updateTeacherProfile(): void
  {
    $this->validate();

    $updateTeacher = Teacher::find(auth()->id());
    $updateTeacher->update([
      'fullname' => $this->teacher['fullname'],
      'email' => $this->teacher['email'],
      'phone_number' => $this->teacher['phone_number'],
      'gender' => $this->teacher['gender'],
      'date_of_birth' => $this->teacher['date_of_birth'],
      'title' => $this->teacher['title'],
      'profile_photo' => $this->profile_photo ? $this->handleAvatarUpload() : $this->teacher['profile_photo'],
    ]);
    $this->reset();

    session()->flash('message', 'Profile Updated Successfully');
    $this->reset();

  }

  public function handleAvatarUpload(): string
  {
    $photo = $this->profile_photo;
    $name = $this->teacher['slug'] . '.' . $photo->getClientOriginalExtension();
    $photo->storeAs('public/profile-photos', $name);
    return $name;
  }
}
