<?php

namespace App\Helpers;

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
}