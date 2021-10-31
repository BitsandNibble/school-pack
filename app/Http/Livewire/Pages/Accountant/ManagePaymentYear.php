<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\Payment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ManagePaymentYear extends Component
{
  public $session_year;

  public function render(): Factory|View|Application
  {
    $years = Payment::select('year')->distinct()->get();

    return view('livewire.pages.accountant.manage-payment-year', compact('years'));
  }

  public function submit(): void
  {
    $value = $this->validate(
      ['session_year' => 'required'],
      [],
      ['session_year' => 'session/year']
    );
    $this->emit('selected_year', $value);
  }
}
