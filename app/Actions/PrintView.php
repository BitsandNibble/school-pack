<?php

namespace App\Actions;

use App\Helpers\SP;
use App\Models\ClassRoom;
use App\Models\ClassStudentSubject;
use App\Models\ClassType;
use App\Models\Exam;
use App\Models\ExamRecord;
use App\Models\Mark;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Subject;

class PrintView
{

  public function getMarksheetPrintView($student_id, $exam_id, $year): array
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

  public function getTabulationsheetPrintView($exam_id, $class_id): array
  {
    $year = SP::getSetting('current_session');
    $data = ['exam_id' => $exam_id, 'class_room_id' => $class_id, 'year' => $year];

    $subject_ids = Mark::where($data)->distinct()
      ->select('subject_id')
      ->get()->pluck('subject_id');

    $student_ids = Mark::where($data)->distinct()
      ->select('student_id')
      ->get()->pluck('student_id');

//    if (count($subject_ids) < 1 || count($student_ids) < 1) {
//      return redirect()->to(route('re'))
//    }

    $d['subjects'] = Subject::whereIn('id', $subject_ids)->orderBy('name')->get();
    $d['students'] = Student::whereIn('id', $student_ids)->get();
    $d['class_id'] = $class_id;
    $d['exam_id'] = $exam_id;
    $d['year'] = $year;

    $data2 = ['exam_id' => $exam_id, 'class_room_id' => $class_id];
    $d['marks'] = Mark::where($data2)->with('grade')->get();
    $d['exam_record'] = ExamRecord::where($data2)->first();

    $d['class'] = ClassRoom::find($class_id);
//    $d['section'] = Section::find($section_id);
    $d['exam'] = Exam::find($exam_id);
    $d['ts'] = 'total_score';

    $d['s'] = Setting::all()->flatMap(function ($s) {
      return [$s->type => $s->description];
    });

    return $d;
  }
}