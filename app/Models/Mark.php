<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(string[] $array)
 * @method static firstOrCreate(array $array)
 * @method static where(array $data)
 */
class Mark extends Model
{
  use HasFactory;

  protected $fillable = [
    'student_id', 'subject_id', 'class_room_id',
    'exam_id', 'ca1', 'ca2', 'total_ca',
    'exam_score', 'total_score',
    'subject_position', 'grade_id', 'year',
  ];

  public function class_room(): BelongsTo
  {
    return $this->belongsTo(ClassRoom::class)->withDefault();
  }

  public function student(): BelongsTo
  {
    return $this->belongsTo(Student::class)->withDefault();
  }

  public function subject(): BelongsTo
  {
    return $this->belongsTo(Subject::class)->withDefault();
  }

  public function grade(): BelongsTo
  {
    return $this->belongsTo(Grade::class)->withDefault();
  }
}
