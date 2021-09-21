<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
  use HasFactory;

  protected $fillable = [
    'name', 'class_room_id', 'teacher_id'
  ];

  public function class_room(): BelongsTo
  {
    return $this->belongsTo(ClassRoom::class);
  }

  public function teacher(): BelongsTo
  {
    return $this->belongsTo(Teacher::class);
  }
}
