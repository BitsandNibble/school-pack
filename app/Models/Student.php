<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
  use HasFactory;

  protected $fillable = [
    'firstname', 'middlename', 'lastname',
    'gender', 'date_of_birth', 'admission_no',
    'email', 'previous_class', 'current_class',
    'password', 'phone_number', 'profile_photo',
    'slug',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];
}
