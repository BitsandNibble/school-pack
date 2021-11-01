<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\ClassRoom;
use App\Models\PaymentRecord;
use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Debtors extends Component
{
  public $class_id;

  public function render(): Factory|View|Application
  {
    $debtors = PaymentRecord::where('paid', 0)
      ->with('student', 'payment')->get();

    foreach ($debtors as $debtor) {
      $this->class_id = $debtor->student->class_room_id;
    }

    $student_ids = PaymentRecord::where('paid', 0)->distinct()
      ->select('student_id')
      ->get()->pluck('student_id');

    $students = Student::whereIn('id', $student_ids)->distinct()
      ->select('class_room_id')
      ->get()->pluck('class_room_id');

    $classes = ClassRoom::whereIn('id', $students)->get();

    return view('livewire.pages.accountant.debtors', compact('debtors', 'classes'));
  }
}
