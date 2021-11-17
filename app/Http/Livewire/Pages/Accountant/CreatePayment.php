<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Helpers\SP;
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

class CreatePayment extends Component
{
  use LivewireAlert;

  public $payment;
  public $year;

  protected array $rules = [
    'payment.title' => 'required|string',
    'payment.class' => 'required',
    'payment.method' => 'required',
    'payment.amount' => 'required|int',
    'payment.description' => 'sometimes|string',
  ];

  protected array $validationAttributes = [
    'payment.title' => 'title',
    'payment.class' => 'class',
    'payment.method' => 'method',
    'payment.amount' => 'amount',
    'payment.description' => 'description',
  ];

  public function render(): Factory|View|Application
  {
    $classes = ClassRoom::get();
    $this->year = SP::getSetting('current_session');

    return view('livewire.pages.accountant.create-payment', compact('classes'));
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
      'class_room_id' => $this->payment['class'] !== 'NULL' ? $this->payment['class'] : NULL,
      'description' => $this->payment['description'] ?? '',
      'year' => SP::getSetting('current_session') ?? '',
    ]);

    $pay1 = Payment::where('year', $this->year)
      ->where('class_room_id', $this->payment['class'])
      ->whereNull('student_id')
      ->with('class_room')
      ->get();

    $pay2 = Payment::where('year', $this->year)
      ->whereNull('class_room_id')
      ->whereNull('student_id')
      ->with('class_room')
      ->get();

    $payments = $pay2->count() ? $pay1->merge($pay2) : $pay1;

    if ($this->payment['class'] === "NULL") {
      $students = Student::get();
    } else {
      $students = Student::where('class_room_id', $this->payment['class'])->get();
    }

    if ($payments->count() && $students->count()) {
      foreach ($payments as $p) {
        foreach ($students as $st) {
          $pr['student_id'] = $st->id;
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
}
