<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static where(string $string, int|string|null $id)
 * @method static find(int|string|null $id)
 */
class Principal extends Authenticatable
{
  use HasApiTokens;
  use HasFactory;
  use Notifiable;

  protected $fillable = [
    'fullname', 'email', 'phone_number',
    'password', 'profile_photo', 'school_id'
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getThumbnailAttribute()
  {
    if ($this->profile_photo) {
      return asset('storage/profile-photos/' . $this->profile_photo);
    }
    return asset('assets/_images/avatars/avatar-10.png');
  }
}
