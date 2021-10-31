<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
  public function getStudentId($id, $year = NULL): Factory|View|Application
  {
    $d['student_id'] = $id;
    $d['year'] = $year;

    return view('users.accountant.invoice.index', $d);
  }
}