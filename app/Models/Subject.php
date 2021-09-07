<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory, WithSearch;

    public $timestamps = false;

    protected $fillable = [
      'name',
    ];

  public function classRooms()
  {
    return $this->belongsToMany(ClassRoom::class);
  }
}
