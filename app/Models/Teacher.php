<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
  use HasFactory;

  protected $fillable = [
    'firstname', 'middlename', 'lastname',
    'title', 'gender', 'date_of_birth',
    'class_teacher', 'staff_id', 'email',
    'password', 'phone_number', 'profile_photo',
    'slug',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  // public function principal()
  // {
  //   return $this->belongsTo(Principal::class);
  // }


}
