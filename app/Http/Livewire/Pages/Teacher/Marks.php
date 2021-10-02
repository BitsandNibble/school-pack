<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\ClassRoom;
use App\Models\ClassStudentSubject;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Marks extends Component
{
  public $subject;
  public $class;
  public $exam;
  public $class_id;
  public $subject_id;
  public $class_room;

  protected $listeners = ['getValues'];

  public function render(): Factory|View|Application
  {
//    show students based on selected class and subject from grading
    if ($this->class_id) {
      $this->class_room = ClassStudentSubject::where('class_room_id', $this->class_id)
        ->where('subject_id', $this->subject_id)
        ->with('student', 'subject')
        ->get();
    }

    return view('livewire.pages.teacher.marks');
  }

  public function getValues($value): void
  {
    $this->class_id = $value['class'];
    $this->subject_id = $value['subject'];

    $this->subject = Subject::where('id', $value['subject'])->first()->name;
    $this->class = ClassRoom::where('id', $value['class'])->first()->name;
    $this->exam = Exam::where('id', $value['exam'])->first()->name;
  }
}
