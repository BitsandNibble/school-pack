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
    'term_id', 'class_room_id', 'student_id',
    'total', 'average', 'class_average', 'position',
    'af', 'ps',
    'year', 'teachers_comment', 'principals_comment',
  ];

  public function term(): BelongsTo
  {
    return $this->belongsTo(Term::class)->withDefault();
  }

  protected $casts = [
    'af' => 'array',
    'ps' => 'array'
  ];
}
