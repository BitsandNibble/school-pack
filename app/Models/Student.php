<?php

namespace App\Models;

use App\Traits\WithSearch;
use Closure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static where(string $string, $class_id)
 * @method static when($q, Closure $param)
 * @method static create(array $array)
 * @method static find($id)
 * @method static whereIn(string $string, $css)
 * @method static get()
 * @method static findOrFail($id)
 * @property mixed profile_photo
 */
class Student extends Authenticatable
{
  use HasFactory, WithSearch;

  protected $fillable = [
    'fullname', 'gender', 'date_of_birth',
    'school_id', 'email', 'password',
    'phone_number', 'profile_photo', 'slug',
    'class_room_id', 'section_id',
    'address', 'nationality_id', 'state_id', 'lga_id',
    'graduated', 'graduation_date', 'year_admitted'
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
