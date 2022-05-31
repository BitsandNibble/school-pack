<?php

namespace App\Models;

use Closure;
use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoticeBoard extends Model
{
    use HasFactory;
    use WithSearch;

    protected $guarded = [];

    public function principal(): BelongsTo
    {
        return $this->belongsTo(Principal::class, 'author_id')->withDefault();
    }
}
