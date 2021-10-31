<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\PaymentRecord;
use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PaymentInvoice extends Component
{
  public $student;
  public $student_id;

  public function mount($id): void
  {
    $this->student_id = $id;
    $this->student = Student::findOrFail($id)->fullname;
  }

  public function render(): Factory|View|Application
  {
    $invoice = PaymentRecord::where('student_id', $this->student_id)->with('payment')->get();

    $uncleared = $invoice->where('paid', 0);
    $cleared = $invoice->where('paid', 1);

    return view('livewire.pages.accountant.payment-invoice', compact('uncleared', 'cleared'));
  }
}
