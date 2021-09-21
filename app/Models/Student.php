<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Student extends Model
{
  use HasFactory, WithSearch;

  protected $fillable = [
    'fullname', 'gender', 'date_of_birth',
    'school_id', 'email', 'password',
    'phone_number', 'profile_photo', 'slug',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function sections(): MorphToMany
  {
    return $this->morphToMany(Section::class, 'sectionable');
  }

  public function getFullnameAttribute($value)
  {
    return ucwords($value);
  }
}
