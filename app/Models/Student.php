<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
  use HasFactory, WithSearch;

  protected $fillable = [
    'fullname', 'gender', 'date_of_birth',
    'school_id', 'email', 'password',
    'phone_number', 'profile_photo', 'slug',
    'class_room_id', 'section_id'
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function class_room(): BelongsTo
  {
    return $this->belongsTo(ClassRoom::class);
  }

  public function section(): BelongsTo
  {
    return $this->belongsTo(Section::class);
  }

  public function getFullnameAttribute($value)
  {
    return ucwords($value);
  }
}
