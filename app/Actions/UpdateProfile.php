<?php

namespace App\Actions;

use App\Models\Principal;
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
      'email' => $data['email'],
      'phone_number' => $data['phone_number'],
      'gender' => $data['gender'],
      'date_of_birth' => $data['date_of_birth'],
      'title' => $data['title'],
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