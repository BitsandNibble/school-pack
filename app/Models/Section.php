<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'class_room_id', 'teacher_id'
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class)->withDefault();
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class)->withDefault();
    }
}