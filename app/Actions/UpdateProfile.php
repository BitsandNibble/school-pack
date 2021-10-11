<?php

namespace App\Actions;

use App\Models\Principal;
use App\Models\Student;
use App\Models\Teacher;
use Exception;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class UpdateProfile
{
  use WithFileUploads;

  /**
   * @throws Exception
   */
  public function updatePrincipalProfile(array $data, $profile_photo): void
  {
    $updatePrincipal = Principal::find(auth()->id());
    $updatePrincipal->update([
      'fullname' => $data['fullname'],
      'slug' => Str::slug($data['fullname']),
      'email' => $data['email'],
      'phone_number' => $data['phone_number'],
      'profile_photo' => $profile_photo ? $this->handleAvatarUpload($profile_photo, $data['slug']) : $data['profile_photo'],
    ]);
  }

  /**
   * @throws Exception
   */
  public function updateTeacherProfile(array $data, $profile_photo): void
  {
    $updateTeacher = Teacher::find(auth()->id());
    $updateTeacher->update([
      'fullname' => $data['fullname'],
      'slug' => Str::slug($data['fullname']),
      'address' => $data['address'],
      'email' => $data['email'],
      'phone_number' => $data['phone_number'],
      'gender' => $data['gender'],
      'nationality_id' => $data['nationality_id'],
      'state_id' => $data['state_id'],
      'lga_id' => $data['lga_id'],
      'date_of_birth' => $data['date_of_birth'],
      'title' => $data['title'],
      'profile_photo' => $profile_photo ? $this->handleAvatarUpload($profile_photo, $data['slug']) : $data['profile_photo'],
    ]);
  }

  /**
   * @throws Exception
   */
  public function updateStudentProfile(array $data, $profile_photo): void
  {
    $updateStudent = Student::find(auth()->id());
    $updateStudent->update([
      'fullname' => $data['fullname'],
      'slug' => Str::slug($data['fullname']),
      'address' => $data['address'],
      'email' => $data['email'],
      'phone_number' => $data['phone_number'],
      'gender' => $data['gender'],
      'nationality_id' => $data['nationality_id'],
      'state_id' => $data['state_id'],
      'lga_id' => $data['lga_id'],
      'date_of_birth' => $data['date_of_birth'],
      'profile_photo' => $profile_photo ? $this->handleAvatarUpload($profile_photo, $data['slug']) : $data['profile_photo'],
    ]);
  }

  /**
   * @throws Exception
   */
  public function handleAvatarUpload($profile_photo, $slug): string
  {
    $photo = $profile_photo;
    $name = $slug . '.' . $photo->getClientOriginalExtension();
    $photo->storeAs('public/profile-photos', $name);
    return $name;
  }
}