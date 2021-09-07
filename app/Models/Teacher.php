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

  public function getFullnameAttribute($value)
  {
    return ucwords($value);
  }
}
