<?php

namespace App\Helpers;

use App\Models\Grade;
use App\Models\Mark;

class GR
{
  public static function getRemarks(): array
  {
    return [
      'Average', 'Credit', 'Distinction', 'Excellent', 'Fail',
      'Fair', 'Good', 'Pass', 'Poor', 'Very Good', 'Very Poor',
    ];
  }

  public static function getTerms(): array
  {
    return [
      'First Term', 'Second Term', 'Third Term',
    ];
  }

  public static function getGrade($total, $class_type_id)
  {
    if ($total < 1) {
      return NULL;
    }

    $grades = Grade::where('class_type_id', $class_type_id)->get();

    if ($grades->count() > 0) {
      $gr = $grades->where('mark_from', '<=', $total)->where('mark_to', '>=', $total);
      return $gr->count() > 0 ? $gr->first() : self::getGrade2($total);
    }
    return self::getGrade2($total);
  }

  public static function getGrade2($total)
  {
    $grades = Grade::whereNull('class_type_id')->get();

    if ($grades->count() > 0) {
      return $grades->where('mark_from', '<=', $total)->where('mark_to', '>=', $total)->first();
    }
    return NULL;
  }

  public static function getSubjectMark($exam_id, $class_id, $subject_id, $student_id, $year)
  {
    $d = [
      'exam_id' => $exam_id, 'class_room_id' => $class_id,
      'subject_id' => $subject_id, 'student_id' => $student_id, 'year' => $year
    ];
    $ts = 'total_score';

    return Mark::where($d)->select($ts)->get()->first()->$ts;
  }

  public static function getSubjectPosition($student_id, $exam_id, $class_id, $subject_id, $year): ?int
  {
    $d = [
      'exam_id' => $exam_id, 'class_room_id' => $class_id,
      'subject_id' => $subject_id, 'year' => $year
    ];
    $ts = 'total_score';

    $sub_mk = self::getSubjectMark($exam_id, $class_id, $subject_id, $student_id, $year);

    $sub_mks = Mark::where($d)->whereNotNull($ts)->orderBy($ts, 'DESC')->select($ts)->get()->pluck($ts);

    return $sub_mks->count() > 0 ? $sub_mks->search($sub_mk) + 1 : NULL;
  }

//  get the total score of all the exams written by a student
  public static function getExamTotal($exam_id, $student_id, $class_id, $year)
  {
    $d = ['student_id' => $student_id, 'exam_id' => $exam_id, 'class_room_id' => $class_id, 'year' => $year];
    $ts = 'total_score';

    $mk = Mark::where($d);
    return $mk->select($ts)->sum($ts);
  }

  //  get average of the exam scores of all subjects the student is offering
  public static function getExamAvg($exam_id, $student_id, $class_id, $year): float
  {
    $d = ['student_id' => $student_id, 'exam_id' => $exam_id, 'class_room_id' => $class_id, 'year' => $year];
    $ts = 'total_score';

    $mk = Mark::where($d)->where($ts, '>', 0);
    $avg = $mk->select($ts)->avg($ts);
    return round($avg, 1);
  }

//  get average of all the subjects the student is offering
  public static function getClassAvg($exam_id, $class_id, $year): float
  {
    $d = ['exam_id' => $exam_id, 'class_room_id' => $class_id, 'year' => $year];
    $ts = 'total_score';

    $avg = Mark::where($d)->select($ts)->avg($ts);
    return round($avg, 1);
  }

//  get student position in class
  public static function getPosition($exam_id, $student_id, $class_id, $year): bool|int|string
  {
    $d = ['student_id' => $student_id, 'exam_id' => $exam_id, 'class_room_id' => $class_id, 'year' => $year];
    $all_mks = [];
    $ts = 'total_score';

    $my_mk = Mark::where($d)->select($ts)->sum($ts);

    unset($d['student_id']);
    $mk = Mark::where($d);
    $students = $mk->select('student_id')->distinct()->get();

    foreach ($students as $s) {
      $all_mks[] = self::getExamTotal($exam_id, $s->student_id, $class_id, $year);
    }
    rsort($all_mks);

    return array_search($my_mk, $all_mks, true) + 1;
  }
}