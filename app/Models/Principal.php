<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Principal extends Authenticatable
{
  use HasApiTokens;
  use HasFactory;
  use Notifiable;

  protected $fillable = [
    'firstname', 'middlename', 'lastname',
    'email', 'phone_number', 'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  protected $appends = [
    'profile_photo',
  ];
}
