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
    $section = Section::where('teacher_id', auth('teacher')->id())
      ->with('class_room', 'teacher')->first();
    $sec = is_null($section) ? null : $section->class_room->name . ' ' . $section->name;

    return view('users.teacher.index', compact('sec'));
  }

  public function getStudentsPerClass(ClassRoom $class): Factory|View|Application
  {
    $section = Section::where('teacher_id', auth('teacher')->id())
        ->with('class_room', 'teacher')->first();
    return view('users.teacher.class-student', compact('class', 'section'));
  }
}
