<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

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
