<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
  ];

  public function teachers()
  {
    return $this->belongsToMany(Teacher::class);
  }

  public function students()
  {
    return $this->belongsToMany(Student::class);
  }

  public function getNameAttribute($value)
  {
    return strtoupper($value);
  }
}
