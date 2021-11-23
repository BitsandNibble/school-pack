<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\ClassRoom;
use App\Models\PaymentRecord;
use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StudentPayment extends Component
{
  public $class;
  public $year;
  public $students;
  public $payments;

  protected array $rules = [
    'class' => 'required|exists:class_rooms,id',
  ];

  public function render(): Factory|View|Application
  {
    $classes = ClassRoom::get();
    $this->year = get_setting('current_session');

    if ($this->class) {
      $this->students = Student::where('class_room_id', $this->class)->get();
      $this->payments = PaymentRecord::get();
    }

    return view('livewire.pages.accountant.student-payment', compact('classes'));
  }

  public function submit(): void
  {
    $this->validate();
  }
}
