<?php

namespace App\Http\Livewire\Pages\Accountant;

use App\Helpers\SP;
use App\Models\ClassRoom;
use App\Models\Payment;
use Exception;
use Livewire\Component;

class CreatePayment extends Component
{
  public $payment;

  protected array $rules = [
    'payment.title' => 'required|string',
    'payment.class' => 'sometimes',
    'payment.method' => 'sometimes',
    'payment.amount' => 'required',
    'payment.description' => 'sometimes|string',
  ];

  protected array $validationAttributes = [
    'payment.title' => 'title',
    'payment.class' => 'class',
    'payment.method' => 'method',
    'payment.amount' => 'amount',
    'payment.description' => 'description',
  ];

  public function render()
  {
    $classes = ClassRoom::get();

    return view('livewire.pages.accountant.create-payment', compact('classes'));
  }

  /**
   * @throws Exception
   */
  public function store(): void
  {
    $this->validate();

    Payment::create([
      'title' => $this->payment['title'] ?? '',
      'amount' => $this->payment['amount'] ?? '',
      'ref_no' => now()->year . '/' . random_int(100000, 999999),
      'method' => $this->payment['method'],
      'class_room_id' => $this->payment['class'] !== 'NULL' ? $this->payment['class'] : NULL,
      'description' => $this->payment['description'] ?? '',
      'year' => SP::getSetting('current_session') ?? '',
    ]);

    session()->flash('message', 'Payment Created Successfully');
    $this->reset();
  }
}
