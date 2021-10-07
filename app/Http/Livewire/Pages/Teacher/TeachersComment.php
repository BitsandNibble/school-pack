<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\ExamRecord;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TeachersComment extends Component
{
  public $teachers_comment;
  public $student_id;

  protected array $rules = [
    'teachers_comment' => 'required|string',
  ];

  public function mount($id): void
  {
    $this->student_id = $id;
  }

  public function render(): Factory|View|Application
  {
    $this->teachers_comment = ExamRecord::where(['student_id' => $this->student_id])
      ->first()
      ->teachers_comment;

    return view('livewire.pages.teacher.teachers-comment');
  }

  public function store(): void
  {
    $this->validate();

    ExamRecord::where(['student_id' => $this->student_id])->update([
      'teachers_comment' => $this->teachers_comment,
    ]);

    session()->flash('message', 'Comment Added Successfully');
  }
}
