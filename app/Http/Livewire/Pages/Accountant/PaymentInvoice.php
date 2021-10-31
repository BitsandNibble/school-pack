<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\PaymentRecord;
use App\Models\Student;
use Livewire\Component;

class PaymentInvoice extends Component
{
  public $student;

  public function mount($id)
  {
    $this->student = Student::findOrFail($id)->fullname;
  }

  public function render()
  {
    $payment_records = PaymentRecord::with('payment')->get();

    return view('livewire.pages.accountant.payment-invoice', compact('payment_records'));
  }
}
