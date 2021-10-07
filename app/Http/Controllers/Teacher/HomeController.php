<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\SP;
use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\ExamRecord;
use App\Models\Mark;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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

  public function getStudentId(Request $request): Factory|View|Application
  {
    $student_id = $request->id;

    return view('users.teacher.select_year', compact('student_id'));
  }

  public function getMarksheetYear(Request $request): Factory|View|Application
  {
    $year = $request->year;
    $student_id = $request->id;

    $d['student'] = Student::where('id', $student_id)
      ->with('class_room', 'section')
      ->first();

    $d['exam'] = ExamRecord::where(['year' => $year, 'student_id' => $student_id])
      ->with('exam')
      ->first();

    $d['marks'] = Mark::where(['student_id' => $student_id])
      ->with('subject', 'grade')
      ->get();

    $d['ca1_limit'] = SP::getSetting('ca1');
    $d['ca2_limit'] = SP::getSetting('ca2');
    $d['exam_limit'] = SP::getSetting('exam');
    $d['total'] = $d['ca1_limit'] + $d['ca2_limit'] + $d['exam_limit'];

    return view('users.teacher.student-marksheet', $d);
  }
}
