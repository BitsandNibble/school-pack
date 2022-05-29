<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $promote)
 */
class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_class', 'from_section', 'to_class', 'to_section',
        'grad', 'student_id', 'from_session', 'to_session', 'status'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id')->withDefault();
    }

    public function fc(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'from_class')->withDefault();
    }

    public function fs(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'from_section')->withDefault();
    }

    public function ts(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'to_section')->withDefault();
    }

    public function tc(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'to_class')->withDefault();
    }
}
