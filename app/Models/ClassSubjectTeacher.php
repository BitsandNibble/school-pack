<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $id)
 * @method static find($id)
 * @method static create(array $array)
 */
class ClassSubjectTeacher extends Model
{
  use HasFactory;

  protected $table = 'class_room_subject_teacher';
  public $timestamps = false;

  protected $fillable = [
    'class_room_id', 'subject_id', 'teacher_id'
  ];

  public function subject(): BelongsTo
  {
    return $this->belongsTo(Subject::class);
  }

  public function teacher(): BelongsTo
  {
    return $this->belongsTo(Teacher::class);
  }

  public function class_room(): BelongsTo
  {
    return $this->belongsTo(ClassRoom::class);
  }
}
