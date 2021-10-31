<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\ClassRoom;
use App\Models\Payment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StudentPaymentClass extends Component
{
  public $class;

  public function render(): Factory|View|Application
  {
    $classes = ClassRoom::get();

    return view('livewire.pages.accountant.student-payment-class', compact('classes'));
  }

  public function submit(): void
  {
    $value = $this->validate(
      ['class' => 'required'],
    );
    $this->emit('selected_class', $value);
  }
}
