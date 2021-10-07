<?php

namespace App\Http\Controllers\Principal;

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

  public function getStudentsPerClass(ClassRoom $class): Factory|View|Application
  {
    return view('users.principal.class-student', compact('class'));
  }

  public function getSubjectsPerClass(ClassRoom $class): Factory|View|Application
  {
    return view('users.principal.class-subject', compact('class'));
  }

  public function getStudentsPerSection(ClassRoom $class, Section $section): Factory|View|Application
  {
    return view('users.principal.section-student', compact('class', 'section'));
  }

  public function getStudentId(Request $request): Factory|View|Application
  {
    $student_id = $request->id;

    return view('users.principal.select_year', compact('student_id'));
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

    return view('users.principal.student-marksheet', $d);
  }
}
