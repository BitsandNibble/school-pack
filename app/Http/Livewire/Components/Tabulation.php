<?php

namespace App\Http\Livewire\Components;

use App\Models\ClassRoom;
use App\Models\Exam;
use App\Models\ExamRecord;
use App\Models\Mark;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Tabulation extends Component
{
  public $exam_id;
  public $class_id;
  public $data;
  public $marks;
  public $subjects;
  public $students;
  public $exam;
  public $class;
  public $exam_name;
  public $selected_year;

  protected $listeners = ['getValues'];

  public function render(): Factory|View|Application
  {
    if ($this->class_id) {
//      get distinct subjects per class and show in table head
      $this->subjects = Mark::where($this->data)
        ->select('subject_id')
        ->distinct()
        ->with('subject')
        ->get(['subject_id']);

//      get students along with the subjects they're registered with to show in table body
      $this->students = Mark::where($this->data)
        ->select('student_id')
        ->distinct()
        ->with('student')
        ->get(['student_id']);

      $this->marks = Mark::where($this->data)
        ->get(['student_id', 'subject_id', 'total_score']);

      $this->exam = ExamRecord::where($this->data)
        ->get(['student_id', 'total', 'average', 'position']);
    }

    return view('livewire.components.tabulation');
  }

  public function getValues($value): void
  {
    $this->class_id = $value['class_id'];
    $this->exam_id = $value['exam_id'];
    $this->selected_year = Exam::where('id', $this->exam_id)->first()->session;

//    use this for where clause to avoid duplicates
    $this->data = [
      'exam_id' => $this->exam_id,
      'class_room_id' => $this->class_id,
      'year' => $this->selected_year,
    ];

    $this->class = ClassRoom::where('id', $value['class_id'])->first()->name;
    $this->exam_name = Exam::where('id', $value['exam_id'])->first()->name;
  }
}
