<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static get()
 * @method static find($id)
 * @method static select(string $string)
 */
class Payment extends Model
{
  use HasFactory;

  protected $fillable = [
    'title', 'amount', 'class_room_id',
    'description', 'year', 'ref_no'
  ];

  public function class_room(): BelongsTo
  {
    return $this->belongsTo(ClassRoom::class);
  }
}
