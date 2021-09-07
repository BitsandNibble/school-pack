<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ClassRoom extends Model
{
  use HasFactory, WithSearch;

  protected $fillable = [
    'name',
  ];

  public function teachers(): BelongsToMany
  {
    return $this->belongsToMany(Teacher::class);
  }

  public function students(): BelongsToMany
  {
    return $this->belongsToMany(Student::class);
  }

  public function subjects(): MorphToMany
  {
    return $this->morphToMany(Subject::class, 'subjectable');
  }

  public function getNameAttribute($value)
  {
    return strtoupper($value);
  }
}
