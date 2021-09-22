<?php

namespace App\Helpers;

use App\Models\Setting;

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
}