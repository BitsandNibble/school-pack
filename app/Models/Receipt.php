<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receipt extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payment_record(): BelongsTo
    {
        return $this->belongsTo(PaymentRecord::class, 'pr_id')->withDefault();
    }
}
