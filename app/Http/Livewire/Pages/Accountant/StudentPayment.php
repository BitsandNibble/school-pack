<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\PaymentRecord;
use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StudentPayment extends Component
{
  public $selected_class;
  protected $listeners = ['selected_class' => 'selectedClass'];

  public function render(): Factory|View|Application
  {
    $students = Student::where('class_room_id', $this->selected_class)->get();
    $payments = PaymentRecord::get();

    return view('livewire.pages.accountant.student-payment', compact('students', 'payments'));
  }

  public function selectedClass($value): void
  {
    $this->selected_class = $value['class'];
  }
}
