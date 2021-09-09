<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectTeacher extends Model
{
  use HasFactory;

  protected $table = 'class_room_subject_teacher';
  public $timestamps = false;

  protected $fillable = [
    'class_room_id', 'subject_id', 'teacher_id'
  ];
}
