<?php

namespace App\Actions;

use App\Http\Livewire\Pages\Principal\Subject;
use App\Models\ClassRoom;
use App\Models\ClassType;
use App\Models\Exam;
use App\Models\ExamRecord;
use App\Models\Mark;
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
    $d['exam'] = $ex = Exam::find($exam_id);
    $d['ts'] = 'total_score';
    $d['student'] = $sr = Student::where('id', $student_id)->first();
    $d['class_type'] = $ct = ClassType::find($cl->class_type_id);
    $d['subjects'] = Subject::where('class_room_id', $cl->id)->get();

    $d['ct'] = $ct->code;
    $d['year'] = $year;
    $d['student_id'] = $student_id;
    $d['exam_id'] = $exam_id;

    return $d;
  }
}