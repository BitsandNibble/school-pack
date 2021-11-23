<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\ClassRoom;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Debtors extends Component
{
  public $selected_session;
  public $terms = [];
  public $selected_term;
  public $debtors;
  public $class_id;
  public $student_ids;
  public $students;
  public $classes;
  public $payments;

  protected array $rules = [
    'selected_session' => 'required',
    'selected_term' => 'required',
  ];

  protected array $validationAttributes = [
    'selected_session' => 'session',
    'selected_term' => 'term',
  ];

  public function render(): Factory|View|Application
  {
    $sessions = PaymentRecord::where('paid', 0)
      ->select('session')->distinct()->get();

    if ($this->selected_session) {
      $this->terms = Term::where('session', $this->selected_session)->get();
    }

    if ($this->selected_term) {
      $this->payments = Payment::where('session', $this->selected_session)
        ->where('term_id', $this->selected_term)
        ->get();

      // get debtors per session & term
      $this->debtors = PaymentRecord::whereHas('payment', function ($q) {
        $q->where('term_id', $this->selected_term); // get term from 'payment' relation
      })->where('paid', 0)
        ->where('session', $this->selected_session)
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

    return view('livewire.pages.accountant.debtors', compact('sessions'));
  }

  public function submit(): void
  {
    $this->validate();
  }
}
