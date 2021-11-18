<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Helpers\SP;
use App\Models\ClassRoom;
use App\Models\Payment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ManagePayment extends Component
{
  use LivewireAlert;

  public $session_year;
  public $deleting;
  public $payment_id;
  public $payment;
  public $payments;
  public $classes;

  protected array $rules = [
    'session_year' => 'required',
    'payment.title' => 'required|string',
    'payment.class_room_id' => 'sometimes',
    'payment.method' => 'sometimes',
    'payment.amount' => 'required',
    'payment.description' => 'sometimes|string',
  ];

  protected array $validationAttributes = [
    'payment.title' => 'title',
    'payment.class_room_id' => 'class',
    'payment.method' => 'method',
    'payment.amount' => 'amount',
    'payment.description' => 'description',
  ];

  public function render(): Factory|View|Application
  {
    $years = Payment::select('year')->distinct()->get();

    if ($this->session_year) {

      $this->payments = Payment::where('year', $this->session_year)->with('class_room')->get();
      $this->classes = ClassRoom::get();
    }

    return view('livewire.pages.accountant.manage-payment', compact('years'));
  }

  public function submit(): void
  {
    $this->validate(
      ['session_year' => 'required'],
      [],
      ['session_year' => 'session/year']
    );
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset('deleting', 'payment_id');
  }

  public function edit($id): void
  {
    $this->payment = Payment::find($id);
    $this->payment_id = $id;
  }

  public function store(): void
  {
    $this->validate();

    if ($this->payment_id) {
      Payment::find($this->payment_id)->update([
        'title' => $this->payment['title'] ?? $this->payment->title,
        'amount' => $this->payment['amount'] ?? $this->payment->amount,
        'ref_no' => now()->year . '/' . random_int(100000, 999999),
        'method' => $this->payment['method'] ?? $this->payment->method,
        'class_room_id' => $this->payment['class'] !== 'NULL' ? $this->payment['class'] : NULL,
        'description' => $this->payment['description'] ?? $this->payment->desctiption,
        'year' => $this->payment->year ?? SP::getSetting('current_session'),
      ]);

      $this->cancel();
      $this->alert('success', 'Payment Updated Successfully');
    }
  }

  public function openDeleteModal($id): void
  {
    $del = Payment::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Payment $payment): void
  {
    $payment->delete();
    $this->cancel();
    $this->alert('success', 'Payment Deleted Successfully');
  }
}
