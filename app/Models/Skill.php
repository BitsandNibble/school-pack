<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static get()
 * @method static find(mixed $grade_id)
 * @method static create(array $array)
 * @method static where(string $string, $id)
 */
class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'skill_type', 'class_type_id'
    ];

    public function class_type(): BelongsTo
    {
        return $this->belongsTo(ClassType::class)->withDefault();
    }
}
