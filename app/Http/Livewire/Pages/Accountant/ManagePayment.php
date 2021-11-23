<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\ClassRoom;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Term;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ManagePayment extends Component
{
  use LivewireAlert;

  public $session;
  public $deleting;
  public $payment_id;
  public $payment;
  public $classes = [];
  public $student;
  public $students = [];
  public $general;
  public $individual;
  public $term_id;
  public $terms = [];
  public $class_id;
  public $student_id;


  protected array $rules = [
    'session' => 'required',
    'term_id' => 'required',
    'payment.title' => 'required|string',
    'payment.class_room_id' => 'sometimes',
    'payment.student_id' => 'sometimes',
    'payment.method' => 'required',
    'payment.amount' => 'required|int',
    'payment.description' => 'sometimes|string',
  ];

  protected array $validationAttributes = [
    'term_id' => 'term',
    'payment.title' => 'title',
    'payment.class_room_id' => 'class',
    'payment.student_id' => 'student',
    'payment.method' => 'payment method',
    'payment.amount' => 'amount',
    'payment.description' => 'description',
  ];

  public function render(): Factory|View|Application
  {
    if ($this->session) {
      $this->terms = Term::where('session', $this->session)->get();
    }

    if ($this->session) {
      $payments = Payment::where('session', $this->session)->with('class_room', 'student')->get();
      $this->classes = ClassRoom::get();

      $this->general = $payments->whereNull('student_id');
      $this->individual = $payments->whereNotNull('student_id', $this->session);
    }

    return view('livewire.pages.accountant.manage-payment');
  }

  public function submit(): void
  {
    $this->validate([
      'session' => 'required'
    ]);
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset('deleting', 'payment_id', 'payment', 'term_id');
  }

  public function edit($id): void
  {
    $this->payment = $pay = Payment::find($id);
    $this->payment_id = $id;
    $this->term_id = $pay->term_id;
    $this->students = Student::where('class_room_id', $pay->class_room_id)->get();
    $this->student = $pay->student_id;
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
}
