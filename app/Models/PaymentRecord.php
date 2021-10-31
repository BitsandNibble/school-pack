<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static firstOrCreate(array $array)
 */
class PaymentRecord extends Model
{
  use HasFactory;

  protected $fillable = [
    'student_id', 'payment_id', 'amount_paid',
    'year', 'paid', 'balance', 'ref_no'
  ];

  public function payment(): BelongsTo
  {
    return $this->belongsTo(Payment::class);
  }

  public function student(): BelongsTo
  {
    return $this->belongsTo(Student::class);
  }

  public function receipt(): HasMany
  {
    return $this->hasMany(Receipt::class, 'pr_id');
  }
}
