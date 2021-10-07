<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ExamRecord;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PrincipalsComment extends Component
{
  public $principals_comment;
  public $student_id;

  protected array $rules = [
    'principals_comment' => 'required|string',
  ];

  public function mount($id): void
  {
    $this->student_id = $id;
  }

  public function render(): Factory|View|Application
  {
    $this->principals_comment = ExamRecord::where(['student_id' => $this->student_id])
      ->first()
      ->principals_comment;

    return view('livewire.pages.principal.principals-comment');
  }

  public function store(): void
  {
    $this->validate();

    ExamRecord::where(['student_id' => $this->student_id])->update([
      'principals_comment' => $this->principals_comment,
    ]);

    session()->flash('message', 'Comment Added Successfully');
  }
}
