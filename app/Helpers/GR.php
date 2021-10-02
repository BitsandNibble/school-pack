<?php

namespace App\Helpers;

class GR
{
  public static function get_remarks(): array
  {
    return [
      'Average', 'Credit', 'Distinction', 'Excellent', 'Fail',
      'Fair', 'Good', 'Pass', 'Poor', 'Very Good', 'Very Poor',
    ];
  }

  public static function get_terms(): array
  {
   return [
     'First Term', 'Second Term', 'Third Term',
   ];
  }
}