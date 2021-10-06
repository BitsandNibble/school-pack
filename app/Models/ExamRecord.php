<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static firstOrCreate(array $array)
 * @method static where(array $array)
 */
class ExamRecord extends Model
{
  use HasFactory;

  protected $fillable = [
    'exam_id', 'class_room_id', 'student_id',
    'total', 'average', 'class_average', 'position',
    'year', 'teachers_comment', 'principals_comment',
  ];

  public function grade(): BelongsTo
  {
    return $this->belongsTo(Grade::class);
  }
}
