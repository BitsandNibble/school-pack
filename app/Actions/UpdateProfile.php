<?php

namespace App\Actions;

use App\Models\Accountant;
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
      'address' => $data['address'],
      'email' => $data['email'],
      'phone_number' => $data['phone_number'],
      'nationality_id' => $data['nationality_id'],
      'state_id' => $data['state_id'],
      'lga_id' => $data['lga_id'],
      'profile_photo' => $profile_photo ? $this->handleAvatarUpload($profile_photo, $data['slug']) : $data['profile_photo'],
    ]);
  }

  /**
   * @throws Exception
   */
  public function updateAccountantProfile(array $data, $profile_photo): void
  {
    $updateAccountant = Accountant::find(auth()->id());
    $this->getUpdate($updateAccountant, $data, $profile_photo);
  }

  /**
   * @throws Exception
   */
  public function updateTeacherProfile(array $data, $profile_photo): void
  {
    $updateTeacher = Teacher::find(auth()->id());
    $this->getUpdate($updateTeacher, $data, $profile_photo);
  }

  /**
   * @throws Exception
   */
  public function updateStudentProfile(array $data, $profile_photo): void
  {
    $updateStudent = Student::find(auth()->id());
    $updateStudent->update([
      'fullname' => $data[0]['fullname'],
      'slug' => Str::slug($data[0]['fullname']),
      'address' => $data[0]['address'],
      'email' => $data[0]['email'],
      'phone_number' => $data[0]['phone_number'],
      'gender' => $data[0]['gender'],
      'nationality_id' => $data[0]['nationality_id'],
      'state_id' => $data[1],
      'lga_id' => $data[2],
      'date_of_birth' => $data[0]['date_of_birth'],
      'profile_photo' => $profile_photo ? $this->handleAvatarUpload($profile_photo, $data[0]['slug']) : $data[0]['profile_photo'],
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

  /**
   * @param $updateUser
   * @param array $data
   * @param $profile_photo
   * @throws Exception
   */
  public function getUpdate($updateUser, array $data, $profile_photo): void
  {
    $updateUser->update([
      'fullname' => $data[0]['fullname'],
      'slug' => Str::slug($data[0]['fullname']),
      'address' => $data[0]['address'],
      'email' => $data[0]['email'],
      'phone_number' => $data[0]['phone_number'],
      'gender' => $data[0]['gender'],
      'nationality_id' => $data[0]['nationality_id'],
      'state_id' => $data[1],
      'lga_id' => $data[2],
      'date_of_birth' => $data[0]['date_of_birth'],
      'title' => $data[0]['title'],
      'profile_photo' => $profile_photo ? $this->handleAvatarUpload($profile_photo, $data[0]['slug']) : $data[0]['profile_photo'],
    ]);
  }
}