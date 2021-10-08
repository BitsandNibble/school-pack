<?php

namespace App\Http\Livewire\Components;

use App\Models\ExamRecord;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Comment extends Component
{
  public $teachers_comment;
  public $principals_comment;
  public $student_id;
  public $user_comment;

  public function mount($id): void
  {
    $this->student_id = $id;
  }

  public function render(): Factory|View|Application
  {
    if (auth('teacher')->user()) {
      $this->teachers_comment = ExamRecord::where(['student_id' => $this->student_id])
        ->first()
        ->teachers_comment;
    }

    if (auth('principal')->user()) {
      $this->principals_comment = ExamRecord::where(['student_id' => $this->student_id])
        ->first()
        ->principals_comment;
    }

    return view('livewire.components.comment');
  }

  public function store(): void
  {
    if (auth('teacher')->user()) {
      $this->validate([
        'teachers_comment' => 'required|string',
      ]);

      $this->user_comment = 'teachers_comment';
    }

    if (auth('principal')->user()) {
      $this->validate([
        'principals_comment' => 'required|string',
      ]);

      $this->user_comment = 'principals_comment';
    }

    ExamRecord::where(['student_id' => $this->student_id])->update([
      $this->user_comment => ($this->user_comment === 'teachers_comment' ? $this->teachers_comment : $this->principals_comment),
    ]);

    session()->flash('message', 'Comment Added Successfully');
  }
}
