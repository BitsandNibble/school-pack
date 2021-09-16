<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStudentSubject extends Model
{
  use HasFactory;

  protected $table = 'class_student_subjects';

  public $timestamps = false;

  protected $fillable = [
    'class_room_id', 'student_id', 'subject_id'
  ];
}
