<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $fillable = [
    'name',
    'address',
    'phone_number1',
    'phone_number2',
    'school_logo',
  ];
}
