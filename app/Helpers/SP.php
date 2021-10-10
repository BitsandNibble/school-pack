<?php

namespace App\Helpers;

use App\Models\Setting;
use App\Models\Student;
use App\Models\Teacher;

class SP
{
  public static function count($value): int
  {
    return count($value);
  }

  public static function getSetting($type)
  {
    return Setting::where('type', $type)->first()->description;
  }

  public static function getFirstWord(string $string): string
  {
    return explode(' ', ucfirst(trim($string)))[0];
  }

  public static function totalStudents()
  {
    return Student::get()->count();
  }

  public static function totalTeachers()
  {
    return Teacher::get()->count();
  }

  /** ADD ORDINAL SUFFIX TO POSITION **/
  public static function getSuffix($number): ?string
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

  public static function getSchoolLogo(): string
  {
    $logo = Setting::get()->toArray()[10]['description'];

    if ($logo !== "") {
      return asset('storage/logos/' . $logo);
    }
    return asset('assets/_images/school_logo.jpg');
  }
}