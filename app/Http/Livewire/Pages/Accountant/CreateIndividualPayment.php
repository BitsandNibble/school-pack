<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\ClassRoom;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Models\Student;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CreateIndividualPayment extends Component
{
  use LivewireAlert;

  public $payment;
  public $class_id;
  public $student_id;
  public $students = [];
  public $year;

  protected array $rules = [
    'payment.title' => 'required|string',
    'class_id' => 'required',
    'student_id' => 'required',
    'payment.method' => 'required',
    'payment.amount' => 'required|int',
    'payment.description' => 'sometimes|string',
  ];

  protected array $validationAttributes = [
    'payment.title' => 'title',
    'class_id' => 'class',
    'student_id' => 'student',
    'payment.method' => 'method',
    'payment.amount' => 'amount',
    'payment.description' => 'description',
  ];

  public function render(): Factory|View|Application
  {
    $classes = ClassRoom::get();
    $this->year = get_setting('current_session');

    if ($this->class_id) {
      $this->students = Student::where('class_room_id', $this->class_id)->get();
    }

    return view('livewire.pages.accountant.create-individual-payment', compact('classes'));
  }

  /**
   * @throws Exception
   */
  public function store(): void
  {
    $this->validate();

    Payment::create([
      'title' => $this->payment['title'] ?? '',
      'amount' => $this->payment['amount'] ?? '',
      'ref_no' => now()->year . '/' . random_int(100000, 999999),
      'method' => $this->payment['method'],
      'class_room_id' => $this->class_id,
      'student_id' => $this->student_id,
      'description' => $this->payment['description'] ?? '',
      'year' => get_setting('current_session') ?? '',
    ]);

    $payment = Payment::where('class_room_id', $this->class_id)
      ->whereNotNull('student_id')
      ->get();

    $student = Student::where('id', $this->student_id)->first();

    if ($payment->count() && $student->count()) {
      foreach ($payment as $p) {
        $pr['student_id'] = $student->id;
        $pr['payment_id'] = $p->id;
        $pr['year'] = $this->year;
        $rec = PaymentRecord::firstOrCreate($pr);
        $rec->ref_no ?: $rec->update(['ref_no' => random_int(100000, 99999999)]);
      }
    }

    $this->alert('success', 'Payment Created Successfully');
    $this->reset();
  }
}
