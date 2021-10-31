<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Helpers\SP;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Models\Receipt;
use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PaymentInvoice extends Component
{
  public $student;
  public $student_id;
  public $amount_paid = [];
  public $year;
  public $limit;

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

    $this->year = SP::getSetting('current_session');

    return view('livewire.pages.accountant.payment-invoice', compact('uncleared', 'cleared'));
  }

  public function pay($pr_id): void
  {
    $pr = PaymentRecord::findOrFail($pr_id);
    $payment = Payment::find($pr->payment_id);
    $this->limit = $pr->balance ?: $pr->payment->amount;

    $this->validate(
      ['amount_paid.*' => 'required|numeric|min:1|max:' . $this->limit],
      [],
      ['amount_paid.*' => 'amount paid']
    );

    $values = array_values($this->amount_paid);

    foreach ($values as $amt_paid) {
//    $d['amount_paid'] = $amt_p = $pr->amount_paid + $this->amount_paid;
      $d['amount_paid'] = $amt_p = $pr->amount_paid + $amt_paid;
      $d['balance'] = $bal = $payment->amount - $amt_p;
      $d['paid'] = $bal < 1 ? 1 : 0;

      PaymentRecord::find($pr_id)->update($d);

      $d2['pr_id'] = $pr_id;
//    $d2['amount_paid'] = $this->amount_paid;
      $d2['amount_paid'] = $amt_paid;
      $d2['balance'] = $bal;
      $d2['year'] = $this->year;

      Receipt::create($d2);
    }

    $this->reset('amount_paid');
    session()->flash('message', 'Payment Recorded Successfully');
  }
}
