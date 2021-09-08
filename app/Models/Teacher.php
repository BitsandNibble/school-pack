<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
  use HasFactory, WithSearch;

  protected $fillable = [
    'fullname', 'title', 'gender',
    'date_of_birth','staff_id', 'email',
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

  public function classRooms(): BelongsToMany
  {
    return $this->belongsToMany(ClassRoom::class);
  }

  public function subjects(): BelongsToMany
  {
//    return $this->belongsToMany(Subject::class, 'class_room_subject_teacher', 'class_room_id');
    return $this->belongsToMany(Subject::class, 'class_room_subject_teacher', 'class_room_id', 'subject_id')->withPivot('teacher_id');
  }

  public function getFullnameAttribute($value)
  {
    return ucwords($value);
  }
}
