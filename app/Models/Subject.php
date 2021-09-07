<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Subject extends Model
{
    use HasFactory, WithSearch;

    public $timestamps = false;

    protected $fillable = [
      'name',
    ];

  public function teachers(): MorphToMany
  {
    return $this->morphedByMany(Teacher::class, 'subjectable');
  }

  public function classes(): MorphToMany
  {
    return $this->morphedByMany(ClassRoom::class, 'subjectable');
  }
}
