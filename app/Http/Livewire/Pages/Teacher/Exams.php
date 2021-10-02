<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\ClassSubjectTeacher;
use App\Models\Exam;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Exams extends Component
{
  public $exam;
  public $class;
  public $subject;
  public $classes = [];
  public $subjects = [];
  public $value;

  protected array $rules = [
    'exam' => 'required',
    'class' => 'required',
    'subject' => 'required',
  ];

  public function render(): Factory|View|Application
  {
    // get all exams
    $exams = Exam::get();

    // show classes only when user has selected an exam
    if (!empty($this->exam)) {
      $this->classes = ClassSubjectTeacher::where('teacher_id', auth()->id())
        ->with('subject', 'class_room')
        ->select('class_room_id')
        ->distinct()
        ->get();
    }

//    show subjects specific to a class
    if (!empty($this->class)) {
      $this->subjects = ClassSubjectTeacher::where('teacher_id', auth()->id())
        ->where('class_room_id', $this->class)
        ->with('subject')
        ->get();
    }

    return view('livewire.pages.teacher.exams', compact('exams'));
  }

//  public function manage(): void
//  {
//    $this->value = $this->validate();
//  }
}
