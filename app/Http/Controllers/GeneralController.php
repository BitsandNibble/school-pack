<?php

namespace App\Http\Controllers;

use App\Actions\GetMarkSheetYear;
use App\Actions\PrintView;
use App\Models\NoticeBoard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class GeneralController extends Controller
{
  public function getMarksheetYear($student_id, $year, GetMarkSheetYear $getMarkSheetYear): Factory|View|Application
  {
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

  public function printReceipt($pr_id, PrintView $printView): Factory|View|Application
  {
    $d = $printView->getReceiptPrintView($pr_id);

    return view('print.receipt', $d);
  }

  public function notice(NoticeBoard $notice): Factory|View|Application
  {
    return view('partials.notice', compact('notice'));
  }
}
