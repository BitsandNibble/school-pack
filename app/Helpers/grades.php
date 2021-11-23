<?php

use App\Models\Grade;
use App\Models\Mark;


// list remarks to be displayed in a select option
if (!function_exists('get_remarks')) {
  function get_remarks(): array
  {
    return [
      'Average', 'Credit', 'Distinction', 'Excellent', 'Fail',
      'Fair', 'Good', 'Pass', 'Poor', 'Very Good', 'Very Poor',
    ];
  }
}


// list terms to be displayed in a select option
if (!function_exists('get_terms')) {
  function get_terms(): array
  {
    return [
      1 => 'First Term', 2 => 'Second Term', 3 => 'Third Term',
    ];
  }
}


// get grade
if (!function_exists('get_grade')) {
  function get_grade($total, $class_type_id)
  {
    if ($total < 1) {
      return NULL;
    }
    $grades = Grade::where('class_type_id', $class_type_id)->get();

    if ($grades->count() > 0) {
      $gr = $grades->where('mark_from', '<=', $total)->where('mark_to', '>=', $total);
      return $gr->count() > 0 ? $gr->first() : get_grade2($total);
    }
    return get_grade2($total);
  }
}


// get grade
if (!function_exists('get_grade2')) {
  function get_grade2($total)
  {
    $grades = Grade::whereNull('class_type_id')->get();

    if ($grades->count() > 0) {
      return $grades->where('mark_from', '<=', $total)->where('mark_to', '>=', $total)->first();
    }
    return NULL;
  }
}


// get mark for each subject per exam, class, student
if (!function_exists('get_subject_mark')) {
  function get_subject_mark($term_id, $class_id, $subject_id, $student_id, $year)
  {
    $d = [
      'term_id' => $term_id, 'class_room_id' => $class_id,
      'subject_id' => $subject_id, 'student_id' => $student_id, 'year' => $year
    ];
    $ts = 'total_score';

    return Mark::where($d)->select($ts)->get()->first()->$ts;
  }
}


// get position of the student in the selected subject
if (!function_exists('get_subject_position')) {
  function get_subject_position($student_id, $term_id, $class_id, $subject_id, $year): ?int
  {
    $d = [
      'term_id' => $term_id, 'class_room_id' => $class_id,
      'subject_id' => $subject_id, 'year' => $year
    ];
    $ts = 'total_score';

    $sub_mk = get_subject_mark($term_id, $class_id, $subject_id, $student_id, $year);
    $sub_mks = Mark::where($d)->whereNotNull($ts)->orderBy($ts, 'DESC')->select($ts)->get()->pluck($ts);

    return $sub_mks->count() > 0 ? $sub_mks->search($sub_mk) + 1 : NULL;
  }
}


// get the total score of all the exams written by a student
if (!function_exists('get_exam_total')) {
  function get_exam_total($term_id, $student_id, $class_id, $year)
  {
    $d = [
      'student_id' => $student_id, 'term_id' => $term_id,
      'class_room_id' => $class_id, 'year' => $year
    ];
    $ts = 'total_score';

    $mk = Mark::where($d);
    return $mk->select($ts)->sum($ts);
  }
}


// get average of the exam scores of all subjects the student is offering
if (!function_exists('get_exam_avg')) {
  function get_exam_avg($term_id, $student_id, $class_id, $year): float
  {
    $d = [
      'student_id' => $student_id, 'term_id' => $term_id,
      'class_room_id' => $class_id, 'year' => $year
    ];
    $ts = 'total_score';

    $mk = Mark::where($d)->where($ts, '>', 0);
    $avg = $mk->select($ts)->avg($ts);

    return round($avg, 1);
  }
}


// get average score of all the subjects the student is offering
if (!function_exists('get_class_avg')) {
  function get_class_avg($term_id, $class_id, $year): float
  {
    $d = ['term_id' => $term_id, 'class_room_id' => $class_id, 'year' => $year];
    $ts = 'total_score';

    $avg = Mark::where($d)->select($ts)->avg($ts);
    return round($avg, 1);
  }
}


// get student position in class
if (!function_exists('get_student_position')) {
  function get_student_position($term_id, $student_id, $class_id, $year): bool|int|string
  {
    $d = [
      'student_id' => $student_id, 'term_id' => $term_id,
      'class_room_id' => $class_id, 'year' => $year
    ];
    $all_mks = [];

    $ts = 'total_score';
    $my_mk = Mark::where($d)->select($ts)->sum($ts);

    unset($d['student_id']);
    $mk = Mark::where($d);
    $students = $mk->select('student_id')->distinct()->get();

    foreach ($students as $s) {
      $all_mks[] = get_exam_total($term_id, $s->student_id, $class_id, $year);
    }
    rsort($all_mks);

    return array_search($my_mk, $all_mks, true) + 1;
  }
}