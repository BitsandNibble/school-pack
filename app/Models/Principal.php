<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static where(string $string, int|string|null $id)
 * @method static find(int|string|null $id)
 * @method static create(array $array)
 * @method static first()
 * @property mixed profile_photo
 */
class Principal extends Authenticatable
{
  use HasApiTokens;
  use HasFactory;
  use Notifiable;

  protected $fillable = [
    'fullname', 'slug', 'email', 'phone_number',
    'password', 'profile_photo', 'school_id',
    'address', 'nationality_id', 'state_id', 'lga_id'
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
