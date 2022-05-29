<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Models\Payment;
use App\Models\Receipt;
use App\Models\Student;
use Livewire\Component;
use App\Models\PaymentRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

class PaymentInvoice extends Component
{
    use LivewireAlert;

    public $student;
    public $student_id;
    public $amount_paid = [];
    public $current_session;
    public $selected_session;
    public $limit;

    public function mount($id, $session): void
    {
        $this->student_id = $id;
        $this->selected_session = $session;
    }

    public function render(): Factory|View|Application
    {
        $invoice = $this->selected_session ? get_all_payment_record($this->student_id, $this->selected_session) :
            get_all_payment_record($this->student_id);

        $this->student = Student::findOrFail($this->student_id)->fullname;
        $uncleared = $invoice->where('paid', 0);
        $cleared = $invoice->where('paid', 1);

        $this->current_session = get_setting('current_session');

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
            $d2['session'] = $this->current_session;

            Receipt::create($d2);
        }

        $this->reset('amount_paid');
        $this->alert('success', 'Payment Recorded Successfully');
    }

    public function reset_record($id): void
    {
        $pr['amount_paid'] = $pr['paid'] = $pr['balance'] = 0;
        PaymentRecord::find($id)->update($pr);
        Receipt::where('pr_id', $id)->delete();
    }
}
