<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
  use HasFactory, WithSearch;

  protected $fillable = [
    'fullname', 'gender', 'date_of_birth',
    'admission_no', 'email', 'previous_class',
    'password', 'phone_number', 'profile_photo',
    'slug',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function classRooms()
  {
    return $this->belongsToMany(ClassRoom::class);
  }

  public function getFullnameAttribute($value)
  {
    return ucfirst($value);
  }
}
