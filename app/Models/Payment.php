<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static get()
 * @method static find($id)
 * @method static select(string $string)
 * @method static whereNull(string $string)
 * @method static where(string $string, $session_year)
 * @method static create(array $array)
 */
class Payment extends Model
{
  use HasFactory;

  protected $fillable = [
    'title', 'amount', 'class_room_id',
    'student_id', 'description', 'session',
    'ref_no', 'term_id',
  ];

  public function class_room(): BelongsTo
  {
    return $this->belongsTo(ClassRoom::class)->withDefault(
      ['name' => 'All Classes']
    );
  }

  public function student(): BelongsTo
  {
    return $this->belongsTo(Student::class)->withDefault();
  }

  public function term(): BelongsTo
  {
    return $this->belongsTo(Term::class)->withDefault();
  }
}
