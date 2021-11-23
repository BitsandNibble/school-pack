<?php

namespace App\Http\Livewire\Pages\Student;

use App\Models\Mark;
use App\Models\PaymentRecord;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Payment extends Component
{
  public $session;
  public $payments;
  public $uncleared;
  public $cleared;

  public function render(): Factory|View|Application
  {
    $years = Mark::where(['student_id' => auth('student')->id()])->select('year')->distinct()->get();

    if ($this->session) {
      $this->payments = $pay = PaymentRecord::where('student_id', auth('student')->id())
        ->where('year', $this->session)
        ->get(); // get payment record based on authenticated student

      $this->uncleared = $pay->where('paid', 0);
      $this->cleared = $pay->where('paid', 1);
    }

    return view('livewire.pages.student.payment', compact('years'));
  }

  public function submit(): void
  {
    $this->validate([
      'session' => 'required',
    ]);
  }
}
