<?php

namespace App\Actions;

use App\Helpers\SP;
use App\Models\ExamRecord;
use App\Models\Mark;
use App\Models\Student;

class GetMarkSheetYear
{

  public function getMarkSheetYear($student_id, $year): array
  {
    $d['student'] = Student::where('id', $student_id)
      ->with('class_room', 'section')
      ->first();

    $d['exam'] = ExamRecord::where(['year' => $year, 'student_id' => $student_id])
      ->with('exam')
      ->first();

    $d['marks'] = Mark::where(['student_id' => $student_id])
      ->with('subject', 'grade')
      ->get();

    $d['ca1_limit'] = SP::getSetting('ca1');
    $d['ca2_limit'] = SP::getSetting('ca2');
    $d['exam_limit'] = SP::getSetting('exam');
    $d['total'] = $d['ca1_limit'] + $d['ca2_limit'] + $d['exam_limit'];

    return $d;
  }
}