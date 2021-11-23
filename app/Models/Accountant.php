<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static create(array $array)
 * @method static find(int|string|null $id)
 * @method static where(string $string, int|string|null $id)
 */
class Accountant extends Authenticatable
{
  use HasApiTokens;
  use HasFactory;
  use Notifiable;

  protected $fillable = [
    'fullname', 'slug', 'gender', 'email',
    'date_of_birth', 'school_id', 'password',
    'phone_number', 'profile_photo',
    'address', 'nationality_id',
    'state_id', 'lga_id', 'date_of_employment'
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getThumbnailAttribute(): string
  {
    if ($this->profile_photo) {
      return asset('storage/profile-photos/' . $this->profile_photo);
    }
    return asset('assets/_images/avatars/avatar-10.png');
  }
}
