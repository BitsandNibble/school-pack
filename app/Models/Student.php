<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $class_id)
 * @method static when($q, \Closure $param)
 * @method static create(array $array)
 * @method static find($id)
 * @method static whereIn(string $string, $css)
 * @method static get()
 * @property mixed profile_photo
 */
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

  public function getThumbnailAttribute(): string
  {
    if ($this->profile_photo) {
      return asset('storage/profile-photos/' . $this->profile_photo);
    }
    return asset('assets/_images/avatars/avatar-10.png');
  }
}
