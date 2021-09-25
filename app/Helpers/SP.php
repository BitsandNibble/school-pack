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

  public static function get_setting($type)
  {
    return Setting::where('type', $type)->first()->description;
  }

  public static function get_first_word(String $string): String
  {
    return explode(' ', ucfirst(trim($string)))[0];
  }

  public static function total_students()
  {
    return Student::get()->count();
  }

  public static function total_teachers()
  {
    return Teacher::get()->count();
  }
}