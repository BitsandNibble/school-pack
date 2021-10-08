<?php

namespace App\Actions;

use App\Helpers\SP;
use App\Models\ClassRoom;
use App\Models\ClassStudentSubject;
use App\Models\ClassSubjectTeacher;
use App\Models\ClassType;
use App\Models\Exam;
use App\Models\ExamRecord;
use App\Models\Mark;
use App\Models\Setting;
use App\Models\Student;

class PrintView
{

  public function getPrintView($student_id, $exam_id, $year): array
  {
    $data = ['student_id' => $student_id, 'exam_id' => $exam_id, 'year' => $year];

    $d['marks'] = Mark::where($data)
      ->with('grade')
      ->get();

    $d['exam_record'] = $exr = ExamRecord::where($data)->first();

    $d['class'] = $cl = ClassRoom::find($exr->class_room_id);
//    $d['section'] = $exr->section_id;
    $d['exam'] = Exam::find($exam_id);
    $d['ts'] = 'total_score';
    $d['student_record'] = Student::where('id', $student_id)->first();
    $d['class_type'] = ClassType::find($cl->class_type_id);
    $d['subjects'] = ClassStudentSubject::where('class_room_id', $cl->id)
      ->where('student_id', $student_id)
      ->with('subject')
      ->get();

    $d['year'] = $year;
    $d['student_id'] = $student_id;
    $d['exam_id'] = $exam_id;

    $d['s'] = Setting::all()->flatMap(function ($s) {
      return [$s->type => $s->description];
    });

    $d['ca1_limit'] = $ca1 = SP::getSetting('ca1');
    $d['ca2_limit'] = $ca2 = SP::getSetting('ca2');
    $d['total_ca_limit'] = $tca = $ca1 + $ca2;
    $d['exam_limit'] = $ex = SP::getSetting('exam');
    $d['final_marks'] = $tca + $ex;

    return $d;
  }
}