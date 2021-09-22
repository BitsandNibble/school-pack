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

  public static function getFirstWord(String $string): String
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
}