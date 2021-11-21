<?php

namespace App\Actions;

use App\Models\ClassRoom;
use App\Models\ClassStudentSubject;
use App\Models\ClassType;
use App\Models\Exam;
use App\Models\ExamRecord;
use App\Models\Mark;
use App\Models\PaymentRecord;
use App\Models\Setting;
use App\Models\Skill;
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

//    need to return blank values from db or something
//    $d['af_skills'] = json_decode(ExamRecord::where($data)->first()->af, true, 512, JSON_THROW_ON_ERROR);
//    $d['ps_skills'] = json_decode(ExamRecord::where($data)->first()->ps, true, 512, JSON_THROW_ON_ERROR);

    $d['skills'] = Skill::get();

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
    $d['position'] = get_suffix($exr->position);

    $d['s'] = Setting::all()->flatMap(function ($s) {
      return [$s->type => $s->description];
    });

    $d['ca1_limit'] = $ca1 = get_setting('ca1') ?: null;
    $d['ca2_limit'] = $ca2 = get_setting('ca2') ?: null;
    $d['total_ca_limit'] = $tca = $ca1 + $ca2;
    $d['exam_limit'] = $ex = get_setting('exam') ?: null;
    $d['final_marks'] = $tca + $ex;

    return $d;
  }

  public function getTabulationsheetPrintView($exam_id, $class_id): array
  {
    $year = Exam::where('id', $exam_id)->first()->session;
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

  public function getReceiptPrintView($pr_id): array
  {
    $d['pr'] = $pr = PaymentRecord::orderBy('year', 'DESC')->where('id', $pr_id)->with('payment', 'receipt')->first();

    $d['receipts'] = $pr->receipt;
    $d['payment'] = $pr->payment;
    $d['sr'] = Student::where('id', $pr->student_id)->first();
    $d['s'] = Setting::all()->flatMap(function ($s) {
      return [$s->type => $s->description];
    });

    return $d;
  }
}