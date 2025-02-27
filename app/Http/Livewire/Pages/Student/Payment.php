<?php

namespace App\Http\Livewire\Pages\Student;

use Livewire\Component;
use App\Models\PaymentRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class Payment extends Component
{
    public $session;
    public $payments;
    public $uncleared;
    public $cleared;

    public function render(): Factory|View|Application
    {
        $sessions = PaymentRecord::where('student_id', auth('student')->id())
            ->select('session')
            ->distinct()
            ->get();

        if ($this->session) {
            $this->payments = $pay = PaymentRecord::where('student_id', auth('student')->id())
                ->where('session', $this->session)
                ->get(); // get payment record based on authenticated student

            $this->uncleared = $pay->where('paid', 0);
            $this->cleared = $pay->where('paid', 1);
        }

        return view('livewire.pages.student.payment', compact('sessions'));
    }

    public function submit(): void
    {
        $this->validate([
            'session' => 'required',
        ]);
    }
}
