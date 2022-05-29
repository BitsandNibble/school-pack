<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $credentials)
 * @method static where(string $string, $id)
 * @method static find($id)
 * @method static whereNull(string $string)
 */
class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'class_type_id', 'mark_from',
        'mark_to', 'remark'
    ];

    public function class_type(): BelongsTo
    {
        return $this->belongsTo(ClassType::class)->withDefault();
    }
}
