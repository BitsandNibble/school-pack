<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static get()
 * @method static when($q, \Closure $param)
 * @method static where(string $string, $id)
 * @method static find($subject_id)
 * @method static create(array $array)
 */
class Subject extends Model
{
    use HasFactory, WithSearch;

    public $timestamps = false;

    protected $fillable = [
      'name', 'slug',
    ];

  public function subjectTeachers(): BelongsToMany
  {
    return $this->belongsToMany(Teacher::class, 'class_room_subject_teacher', 'class_room_id');
//    return $this->belongsToMany(Teacher::class, 'class_room_subject_teacher', 'class_room_id', 'teacher_id')->withPivot('subject_id');
  }
}
