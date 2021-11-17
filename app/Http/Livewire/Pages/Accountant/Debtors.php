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
  public $selected_year;
  public $debtors;
  public $class_id;
  public $student_ids;
  public $students;
  public $classes;

  public function render(): Factory|View|Application
  {
    $years = PaymentRecord::where('paid', 0)
      ->select('year')->distinct()->get();

    if ($this->selected_year) {
      $this->debtors = PaymentRecord::where('paid', 0)
        ->where('year', $this->selected_year)
        ->with('student', 'payment')->get();

      foreach ($this->debtors as $debtor) {
        $this->class_id = $debtor->student->class_room_id;
      }

      $this->student_ids = PaymentRecord::where('paid', 0)->distinct()
        ->select('student_id')
        ->get()->pluck('student_id');

      $this->students = Student::whereIn('id', $this->student_ids)->distinct()
        ->select('class_room_id')
        ->get()->pluck('class_room_id');

      $this->classes = ClassRoom::whereIn('id', $this->students)->get();
    }

    return view('livewire.pages.accountant.debtors', compact('years'));
  }

  public function submit()
  {
    $value = $this->validate(
      ['selected_year' => 'required']
    );
  }
}
