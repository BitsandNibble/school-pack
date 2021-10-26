<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $promote)
 */
class Promotion extends Model
{
  use HasFactory;

  protected $fillable = [
    'from_class', 'from_section', 'to_class', 'to_section',
    'grad', 'student_id', 'from_session', 'to_session', 'status'
  ];

  public function student(): BelongsTo
  {
    return $this->belongsTo(User::class, 'student_id');
  }

  public function from_class(): BelongsTo
  {
    return $this->belongsTo(ClassRoom::class, 'from_class');
  }

  public function from_section(): BelongsTo
  {
    return $this->belongsTo(Section::class, 'from_section');
  }

  public function to_section(): BelongsTo
  {
    return $this->belongsTo(Section::class, 'to_section');
  }

  public function to_class(): BelongsTo
  {
    return $this->belongsTo(ClassRoom::class, 'to_class');
  }
}
