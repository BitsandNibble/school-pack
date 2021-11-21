<?php

use App\Models\ClassSubjectTeacher;
use App\Models\PaymentRecord;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Teacher;

// check if teacher has access to view tabulationsheet page
if (!function_exists('check_teacher_tabulationsheet_access')) {
  function check_teacher_tabulationsheet_access(): void
  {
    if (auth('teacher')->user() && empty(ClassSubjectTeacher::where('teacher_id', auth('teacher')->id())
      ->get()->toArray())) {
      abort(403);
    }
  }
}


// check if teacher has access to view marksheet page
if (!function_exists('check_teacher_marksheet_access')) {
  function check_teacher_marksheet_access(): void
  {
    if (auth('teacher')->user() && empty(Section::where('teacher_id', auth()->id())
      ->get()->toArray())) {
      abort(403);
    }
  }
}


// get all settings from DB
if (!function_exists('get_setting')) {
  function get_setting($type)
  {
    return Setting::where('type', $type)->first()->description;
  }
}


// get first word from a sentence/string
if (!function_exists('get_first_word')) {
  function get_first_word(string $string): string
  {
    return explode(' ', ucfirst(trim($string)))[0];
  }
}


// get total number of students from DB
if (!function_exists('total_students')) {
  function total_students()
  {
    return Student::get()->count();
  }
}


// get total number of teachers from DB
if (!function_exists('total_teachers')) {
  function total_teachers()
  {
    return Teacher::get()->count();
  }
}


// add suffix to position(subject or student)
if (!function_exists('get_suffix')) {
  function get_suffix($number): ?string
  {
    if ($number < 1) {
      return NULL;
    }
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');

    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
      return $number . '<sup>th</sup>';
    }
    return $number . '<sup>' . $ends[$number % 10] . '</sup>';
  }
}


// get school logo from DB or return default one
if (!function_exists('get_school_logo')) {
  function get_school_logo(): string
  {
    $logo = Setting::get()->toArray()[10]['description'];

    if ($logo !== "") {
      return asset('storage/logos/' . $logo);
    }
    return asset('assets/_images/school_logo.jpg');
  }
}


/************** PAYMENT RECORDS ***************/

// check if year is null
if (!function_exists('get_all_payment_record')) {
  function get_all_payment_record($student_id, $year = NULL)
  {
    // if year isn't null, pass only student id, else, pass both student id and year
    return $year ? get_payment_record(['student_id' => $student_id, 'year' => $year]) :
      get_payment_record(['student_id' => $student_id]);
  }
}

// get payment record based on the above function
if (!function_exists('get_payment_record')) {
  function get_payment_record($data, $order = 'year', $dir = 'DESC')
  {
    return PaymentRecord::orderBy($order, $dir)->where($data)->with('payment')->get();
  }
}