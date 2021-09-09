<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ClassRoom extends Model
{
  use HasFactory, WithSearch;

  protected $fillable = [
    'name',
  ];

  public function teachers(): MorphToMany
  {
    return $this->morphedByMany(Teacher::class, 'classable');
  }

  public function students(): MorphToMany
  {
    return $this->morphedByMany(Student::class, 'classable');
  }

  public function subjectTeachers(): BelongsToMany
  {
    return $this->belongsToMany(Teacher::class, 'class_room_subject_teacher', 'class_room_id');
//    return $this->belongsToMany(Teacher::class, 'class_room_subject_teacher', 'class_room_id', 'teacher_id')->withPivot('subject_id');
  }

  public function subjects(): BelongsToMany
  {
    return $this->belongsToMany(Subject::class, 'class_room_subject_teacher', 'class_room_id');
//    return $this->belongsToMany(Subject::class, 'class_room_subject_teacher', 'class_room_id', 'subject_id')->withPivot('teacher_id');
  }

  public function getNameAttribute($value)
  {
    return strtoupper($value);
  }
}
