<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\Payment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ManagePayment extends Component
{
  public $exam_year;

  protected $listeners = ['selected_year'];

  protected array $rules = [
    'exam_year' => 'required'
  ];

  public function render(): Factory|View|Application
  {
    $payments = Payment::with('class_room')->get();

    return view('livewire.pages.accountant.manage-payment', compact('payments'));
  }

  public function selected_year($value): void
  {
    $this->exam_year = $value['exam_year'];
  }

  public function submit()
  {
  }
}
