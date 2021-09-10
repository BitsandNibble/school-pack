<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class HomeController extends Controller
{

  public function getStudentsPerClass(ClassRoom $class)
  {
    return view('users.teacher.class-student', compact('class'));
  }

//  public function getSubjectsPerClass(ClassRoom $class) {
//    return view('users.teacher.class-subject', compact('class'));
//  }
}
