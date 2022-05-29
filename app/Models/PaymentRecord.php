<?php

namespace App\Models;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static firstOrCreate(array $array)
 * @method static where(string $string, $student_id)
 * @method static findOrFail($pr_id)
 * @method static find($pr_id)
 * @method static get()
 * @method static orderBy(mixed $order, mixed $dir)
 * @method static whereHas(string $string, Closure $param)
 */
class PaymentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'payment_id', 'amount_paid',
        'session', 'paid', 'balance', 'ref_no'
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class)->withDefault();
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class)->withDefault();
    }

    public function receipt(): HasMany
    {
        return $this->hasMany(Receipt::class, 'pr_id');
    }
}
