<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Section;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{

  public function index(): Factory|View|Application
  {
    $sections = Section::where('teacher_id', auth('teacher')->id())
      ->with('class_room', 'teacher')->get();

    return view('users.teacher.index', compact('sections'));
  }

  public function getStudentsPerClassOrSection(ClassRoom $class, Section $section): Factory|View|Application
  {
    return view('users.teacher.class-student', compact('class', 'section'));
  }
}
