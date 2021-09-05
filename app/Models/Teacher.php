<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
  use HasFactory, WithSearch;

  protected $fillable = [
    'firstname', 'middlename', 'lastname',
    'title', 'gender', 'date_of_birth',
    'staff_id', 'email',
    'password', 'phone_number', 'profile_photo',
    'slug',
  ];

  // protected $search = [
  //   'firstname', 'middlename', 'lastname',
  // ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  // public function principal()
  // {
  //   return $this->belongsTo(Principal::class);
  // }

  public function classRooms()
  {
    return $this->belongsToMany(ClassRoom::class);
  }

  public function getFullnameAttribute()
  {
    return $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname;
  }

  public function getFirstnameAttribute($value)
  {
    return ucfirst($value);
  }

  public function getMiddlenameAttribute($value)
  {
    return ucfirst($value);
  }

  public function getLastnameAttribute($value)
  {
    return ucfirst($value);
  }
}
