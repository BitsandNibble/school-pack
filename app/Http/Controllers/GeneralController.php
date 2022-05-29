<?php

namespace App\Http\Controllers;

use App\Models\NoticeBoard;
use App\Services\PrintService;
use App\Services\MarkSheetService;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class GeneralController extends Controller
{
    public function getMarksheetYear($student_id, $session, $term, MarkSheetService $markSheetService): Factory|View|Application
    {
        $d = $markSheetService->getMarkSheetYear($student_id, $session, $term);

        return view('partials.student-marksheet', $d);
    }

    public function printMarkSheet($student_id, $term_id, $year, PrintService $printService): Factory|View|Application
    {
        $d = $printService->getMarksheetPrintView($student_id, $term_id, $year);

        return view('print.marksheet', $d);
    }

    public function printTabulationSheet($term_id, $class_id, PrintService $printService): Factory|View|Application
    {
        $d = $printService->getTabulationsheetPrintView($term_id, $class_id);

        return view('print.tabulation-sheet', $d);
    }

    public function printReceipt($pr_id, PrintService $printService): Factory|View|Application
    {
        $d = $printService->getReceiptPrintView($pr_id);

        return view('print.receipt', $d);
    }

    public function notice($id): Factory|View|Application
    {
        $notice = NoticeBoard::find($id);
        return view('partials.notice', compact('notice'));
    }
}
