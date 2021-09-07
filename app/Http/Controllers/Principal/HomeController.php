<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class HomeController extends Controller
{

  public function getStudentsPerClass(ClassRoom $class)
  {
    return view('users.principal.class-student', compact('class'));
  }

  public function getSubjectsPerClass(ClassRoom $class) {
    return view('users.principal.class-subject', compact('class'));
  }
}
