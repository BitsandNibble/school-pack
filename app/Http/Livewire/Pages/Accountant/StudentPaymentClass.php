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

  protected array $rules = [
    'class' => 'required|exists:class_rooms,id',
  ];

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
    $value = $this->validate();
    $this->emit('selected_class', $value);
  }
}
