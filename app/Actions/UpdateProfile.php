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
      'fullname' => $data['principal']['fullname'],
      'slug' => Str::slug($data['principal']['fullname']),
      'email' => $data['principal']['email'],
      'phone_number' => $data['principal']['phone_number'],
      'profile_photo' => $profile_photo ? $this->handleAvatarUpload($profile_photo, $data['principal']) : $data['profile_photo'],
    ]);
  }

  /**
   * @throws Exception
   */
  public function updateTeacherProfile(array $data, $profile_photo): void
  {
    $updateTeacher = Teacher::find(auth()->id());
    $updateTeacher->update([
      'fullname' => $data['teacher']['fullname'],
      'slug' => Str::slug($data['teacher']['fullname']),
      'email' => $data['teacher']['email'],
      'phone_number' => $data['teacher']['phone_number'],
      'gender' => $data['teacher']['gender'],
      'date_of_birth' => $data['teacher']['date_of_birth'],
      'title' => $data['teacher']['title'],
      'profile_photo' => $profile_photo ? $this->handleAvatarUpload($profile_photo, $data['teacher']) : '',
    ]);
  }

  /**
   * @throws Exception
   */
  public function handleAvatarUpload($profile_photo, $user): string
  {
    $slug = Str::slug($user['fullname']);
    $photo = $profile_photo;
    $name = $slug . '.' . $photo->getClientOriginalExtension();
    $photo->storeAs('public/profile-photos', $name);
    return $name;
  }
}