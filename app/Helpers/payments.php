<?php

use App\Models\PaymentRecord;


// check if year is null
if (!function_exists('get_all_payment_record')) {
  function get_all_payment_record($student_id, $session = NULL)
  {
    // if year isn't null, pass only student id, else, pass both student id and year
    return $session ? get_payment_record(['student_id' => $student_id, 'session' => $session]) :
      get_payment_record(['student_id' => $student_id]);
  }
}

// get payment record based on the above function
if (!function_exists('get_payment_record')) {
  function get_payment_record($data, $order = 'session', $dir = 'DESC')
  {
    return PaymentRecord::orderBy($order, $dir)->where($data)->with('payment')->get();
  }
}