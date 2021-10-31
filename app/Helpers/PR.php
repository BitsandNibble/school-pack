<?php

namespace App\Helpers;

use App\Models\PaymentRecord;

class PR
{
  /************** PAYMENT RECORDS ***************/

//  check if year is null
  public static function getAllPaymentRecord($student_id, $year = NULL)
  {
//    if year isn't null, pass only student id, else, pass both student id and year
    return $year ? self::getRecord(['student_id' => $student_id, 'year' => $year]) :
      self::getRecord(['student_id' => $student_id]);
  }

  public static function getRecord($data, $order = 'year', $dir = 'DESC')
  {
    return PaymentRecord::orderBy($order, $dir)->where($data)->with('payment')->get();
  }
}