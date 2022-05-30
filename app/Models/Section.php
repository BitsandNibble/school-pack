<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static orderBy(string $sortBy, string $param)
 * @method static where(string $string, $id)
 * @method static find($section_id)
 * @method static create(array $array)
 * @method static get()
 */
class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'class_room_id', 'teacher_id'
    ];

    public function class_room(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class)->withDefault();
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class)->withDefault();
    }
}
