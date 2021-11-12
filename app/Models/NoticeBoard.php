<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static when($q, \Closure $param)
 * @method static find(mixed $teacher_id)
 * @method static create(array $array)
 * @method static where(string $string, $id)
 */
class NoticeBoard extends Model
{
  use HasFactory;
  use WithSearch;

  protected $fillable = [
    'title', 'message', 'author_id',
  ];

  public function principal(): BelongsTo
  {
    return $this->belongsTo(Principal::class, 'author_id')->withDefault();
  }
}
