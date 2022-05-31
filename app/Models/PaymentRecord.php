<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

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
