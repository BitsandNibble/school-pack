<?php

namespace App\Models;

use App\Traits\WithSearch;
use Closure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static where(string $string, $id)
 * @method static find($id)
 * @method static create(array $array)
 * @method static get()
 * @method static when($q, Closure $param)
 * @property mixed profile_photo
 */
class Teacher extends Authenticatable
{
  use HasFactory, WithSearch;

  protected $fillable = [
    'fullname', 'title', 'gender',
    'date_of_birth', 'school_id', 'email',
    'password', 'phone_number', 'profile_photo',
    'slug', 'address', 'nationality_id',
    'state_id', 'lga_id', 'date_of_employment'
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

  public function subjects(): BelongsToMany
  {
//    return $this->belongsToMany(Subject::class, 'class_room_subject_teacher', 'class_room_id');
    return $this->belongsToMany(Subject::class, 'class_room_subject_teacher', 'class_room_id', 'subject_id')->withPivot('teacher_id');
  }

  public function nationality(): BelongsTo
  {
    return $this->belongsTo(Nationality::class);
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo(State::class);
  }

  public function lga(): BelongsTo
  {
    return $this->belongsTo(Lga::class);
  }

  public function getFullnameAttribute($value): string
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
