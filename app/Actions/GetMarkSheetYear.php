<?php

namespace App\Actions;

use App\Models\ExamRecord;
use App\Models\Mark;
use App\Models\Student;

class GetMarkSheetYear
{

  public function getMarkSheetYear($student_id, $session, $term): array
  {
    $d['year'] = $session;
    $d['term'] = $term;

    $d['student'] = Student::where('id', $student_id)
      ->with('class_room', 'section')
      ->first();

    $d['exam_record'] = $exr = ExamRecord::where(['year' => $session, 'student_id' => $student_id, 'term_id' => $term])
      ->with('term')
      ->first();

    $d['marks'] = Mark::where(['year' => $session, 'student_id' => $student_id, 'term_id' => $term])
      ->where('year', $session)
      ->with('subject', 'grade')
      ->get();

    $d['position'] = get_suffix($exr->position);

    $d['ca1_limit'] = get_setting('ca1') ?: null;
    $d['ca2_limit'] = get_setting('ca2') ?: null;
    $d['exam_limit'] = get_setting('exam') ?: null;
    $d['total'] = $d['ca1_limit'] + $d['ca2_limit'] + $d['exam_limit'];

    return $d;
  }
}