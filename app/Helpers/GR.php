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
}