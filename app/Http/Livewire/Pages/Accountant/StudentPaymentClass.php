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
use Livewire\Component;

class StudentPaymentClass extends Component
{
  public $class;
  public $year;

  public function render(): Factory|View|Application
  {
    $classes = ClassRoom::get();
    $this->year = SP::getSetting('current_session');

    return view('livewire.pages.accountant.student-payment-class', compact('classes'));
  }

  /**
   * @throws Exception
   */
  public function submit(): void
  {
    $value = $this->validate(
      ['class' => 'required|exists:class_rooms,id'],
    );
    $this->emit('selected_class', $value);

    $pay1 = Payment::where([
      'class_room_id' => $this->class,
      'year' => $this->year
    ])->with('class_room')->get();

    $pay2 = Payment::whereNull('class_room_id')
      ->where('year', $this->year)
      ->with('class_room')
      ->get();

    $payments = $pay2->count() ? $pay1->merge($pay2) : $pay1;
    $students = Student::where('class_room_id', $value['class'])->get();

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
    }
  }
}
