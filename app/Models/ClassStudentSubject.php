<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static updateOrCreate(array $array)
 * @method static select(string $string)
 * @method static where(string $string, $value)
 */
class ClassStudentSubject extends Model
{
  use HasFactory;

  protected $table = 'class_student_subjects';

  public $timestamps = false;

  protected $fillable = [
    'class_room_id', 'student_id', 'subject_id'
  ];

  public function student(): BelongsTo
  {
    return $this->belongsTo(Student::class)->withDefault();
  }

  public function subject(): BelongsTo
  {
    return $this->belongsTo(Subject::class)->withDefault();
  }
}
