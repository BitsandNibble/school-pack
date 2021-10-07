<?php

namespace App\Http\Controllers\Principal;

use App\Actions\GetMarkSheetYear;
use App\Actions\PrintView;
use App\Http\Controllers\Controller;
use App\Http\Livewire\Pages\Principal\Subject;
use App\Models\ClassRoom;
use App\Models\ClassType;
use App\Models\Exam;
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

  public function getMarksheetYear(Request $request, GetMarkSheetYear $getMarkSheetYear): Factory|View|Application
  {
    $year = $request->year;
    $student_id = $request->id;

    $d = $getMarkSheetYear->getMarkSheetYear($student_id, $year);

    return view('users.principal.student-marksheet', $d);
  }

  public function print($student_id, $exam_id, $year, PrintView $printView): Factory|View|Application
  {
    $d = $printView->getPrintView($student_id, $exam_id, $year);

    return view('print.marksheet', $d);
  }
}
