<?php

namespace App\Http\Livewire\Components;

use App\Models\ClassRoom;
use App\Models\ClassSubjectTeacher;
use App\Models\Exam;
use App\Models\ExamRecord;
use App\Models\Mark;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TabulationSheet extends Component
{
  public $exam_id;
  public $class_id;
  public $subject_id;
  public $classes = [];
//  public $subjects = [];
  public $data;
  public $marks;
  public $subjects;
  public $students;
  public $exam_record;
  public $class_name;
  public $exam_name;
  public $selected_year;

  protected array $rules = [
    'exam_id' => 'required',
    'class_id' => 'required',
//    'subject_id' => 'required',
  ];

  protected array $validationAttributes = [
    'exam_id' => 'exam',
    'class_id' => 'class',
//    'subject_id' => 'subject',
  ];

  public function render(): Factory|View|Application
  {
    check_teacher_tabulationsheet_access(); // check if teacher has access to view this page

    // get all exams
    $exams = Exam::get();

    // show classes only when user has selected an exam
    if (!empty($this->exam_id)) {
      if (auth('teacher')->user()) {
        $this->classes = ClassSubjectTeacher::where('teacher_id', auth()->id())
          ->with('class_room')
          ->select('class_room_id')
          ->distinct()
          ->get();
      }

      if (auth('principal')->user()) {
        $this->classes = ClassRoom::get();
      }
    }

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

      $this->exam_record = ExamRecord::where($this->data)
        ->get(['student_id', 'total', 'average', 'position']);
    }

    return view('livewire.components.tabulation-sheet', compact('exams'));
  }

//  get values from select box
  public function view(): void
  {
    $this->validate();

//    use this for where clause to avoid duplicates
    $this->data = [
      'exam_id' => $this->exam_id,
      'class_room_id' => $this->class_id,
      'year' => $this->selected_year,
    ];

    $this->selected_year = Exam::where('id', $this->exam_id)->first()->session;
    $this->class_name = ClassRoom::where('id', $this->class_id)->first()->name;
    $this->exam_name = Exam::where('id', $this->exam_id)->first()->name;
  }
}
