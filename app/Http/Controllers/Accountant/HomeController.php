<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
  public function getStudentId($id): Factory|View|Application
  {
    $student_id = $id;

    return view('users.accountant.invoice.index', compact('student_id'));
  }
}
