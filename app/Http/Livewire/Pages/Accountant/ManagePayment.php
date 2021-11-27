<?php

namespace App\Http\Livewire\Pages\Accountant;

use Exception;
use App\Models\Term;
use App\Models\Payment;
use App\Models\Student;
use Livewire\Component;
use App\Models\ClassRoom;
use App\Traits\WithBulkActions;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @property mixed rowsQuery
 * @property mixed rows
 * @property mixed selectedRowsQuery
 */
class ManagePayment extends Component
{
  use LivewireAlert;
  use WithBulkActions;

  public $selected_session;
  public $selected_term;
  public $deleting;
  public $payment_id;
  public $payment;
  public $classes = [];
  public $students = [];
  public $general;
  public $individual;
  public $terms = [];
  public $student_id;
  public $term_name;
  public $total;


  protected array $rules = [
    'payment.session' => 'required',
    'payment.term_id' => 'required',
    'payment.title' => 'required|string',
    'payment.class_room_id' => 'sometimes',
    'payment.student_id' => 'sometimes',
    'payment.method' => 'required',
    'payment.amount' => 'required|int',
    'payment.description' => 'sometimes|string',
  ];

  protected array $validationAttributes = [
    'payment.session' => 'session',
    'payment.term_id' => 'term',
    'payment.title' => 'title',
    'payment.class_room_id' => 'class',
    'payment.student_id' => 'student',
    'payment.method' => 'payment method',
    'payment.amount' => 'amount',
    'payment.description' => 'description',
  ];

  public function getRowsQueryProperty()
  {
    return Payment::where('session', $this->selected_session)
      ->where('term_id', $this->selected_term)
      ->with('class_room', 'student');
  }

  public function getRowsProperty()
  {
    return $this->rowsQuery->get();
  }

  public function render(): Factory|View|Application
  {
    if ($this->selectAll) $this->selectPageRows(); // for checkbox

    if ($this->selected_session) {
      $this->terms = Term::where('session', $this->selected_session)->get();
    }

    if ($this->selected_term) {
      $payments = $this->rows;
      $this->total = $this->rows->count();

      $this->term_name = Term::find($this->selected_term)->name;
      $this->classes = ClassRoom::get();
      $this->general = $payments->whereNull('student_id');
      $this->individual = $payments->whereNotNull('student_id', $this->selected_session);
    }

    return view('livewire.pages.accountant.manage-payment');
  }

  public function submit(): void
  {
    $this->validate(
      [
        'selected_session' => 'required',
        'selected_term' => 'required',
      ], [], [
        'selected_session' => 'session',
        'selected_term' => 'term',
      ]
    );
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset('deleting', 'payment_id', 'payment');
  }

  public function edit($id): void
  {
    $this->payment = $pay = Payment::find($id);
    $this->payment_id = $id;
    $this->students = Student::where('class_room_id', $pay->class_room_id)->get();
  }

  /**
   * @throws Exception
   */
  public function store(): void
  {
    $this->validate();

    if ($this->payment_id) {
      Payment::find($this->payment_id)->update([
        'title' => $this->payment['title'] ?? $this->payment->title,
        'amount' => $this->payment['amount'] ?? $this->payment->amount,
        'ref_no' => now()->year . '/' . random_int(100000, 999999),
        'method' => $this->payment['method'] ?? $this->payment->method,
        'class_room_id' => $this->payment['class_room_id'] !== 'NULL' ? $this->payment['class_room_id'] : NULL,
        'student_id' => $this->students ? $this->payment['student_id'] : NULL,
        'description' => $this->payment['description'] ?? $this->payment->desctiption,
        'session' => $this->payment['session'] ?? $this->payment->session,
        'term_id' => $this->payment['term_id'] ?? $this->payment->term_id,
      ]);

      $this->cancel();
      $this->alert('success', 'Payment Updated Successfully');
    }
  }

  public function openDeleteModal($id): void
  {
    $del = Payment::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Payment $payment): void
  {
    $payment->delete();
    $this->cancel();
    $this->alert('success', 'Payment Deleted Successfully');
  }

  // delete checked/selected rows
  public function deleteSelected(): void
  {
    $this->selectedRowsQuery->delete();

    $this->cancel();
    $this->alert('success', 'Payments Deleted Successfully');
  }
}
