<?php

namespace App\Http\Controllers;

use App\Actions\GetMarkSheetYear;
use App\Actions\PrintView;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
  public function getStudentId($id): Factory|View|Application
  {
    $student_id = $id;

    return view('partials.select_year', compact('student_id'));
  }

  public function getMarksheetYear(Request $request, $id, GetMarkSheetYear $getMarkSheetYear): Factory|View|Application
  {
    $request->validate([
      'year' => 'required'
    ]);

    $year = $request->year;
    $student_id = $id;

    $d = $getMarkSheetYear->getMarkSheetYear($student_id, $year);

    return view('partials.student-marksheet', $d);
  }

  public function printMarkSheet($student_id, $exam_id, $year, PrintView $printView): Factory|View|Application
  {
    $d = $printView->getMarksheetPrintView($student_id, $exam_id, $year);

    return view('print.marksheet', $d);
  }

  public function printTabulationSheet($exam_id, $class_id, PrintView $printView): Factory|View|Application
  {
    $d = $printView->getTabulationsheetPrintView($exam_id, $class_id);

    return view('print.tabulation-sheet', $d);
  }
}
