<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $d2)
 * @method static where(string $string, $id)
 */
class Receipt extends Model
{
  use HasFactory;

  protected $fillable = ['pr_id', 'session', 'balance', 'amount_paid'];

  public function payment_record(): BelongsTo
  {
    return $this->belongsTo(PaymentRecord::class, 'pr_id')->withDefault();
  }
}
