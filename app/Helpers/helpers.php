<?php

use App\Models\ClassSubjectTeacher;
use App\Models\Section;

if (!function_exists('check_teacher_tabulationsheet_access')) {
  function check_teacher_tabulationsheet_access(): void
  {
    if (empty(ClassSubjectTeacher::where('teacher_id', auth('teacher')->id())
      ->get()->toArray())) {
      abort(403);
    }
  }
}


if (!function_exists('check_teacher_marksheet_access')) {
  function check_teacher_marksheet_access(): void
  {
    if (empty(Section::where('teacher_id', auth()->id())
      ->get()->toArray())) {
      abort(403);
    }
  }
}