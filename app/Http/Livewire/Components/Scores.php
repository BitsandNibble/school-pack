<?php

namespace App\Http\Livewire\Components;

use App\Models\ClassRoom;
use App\Models\ClassStudentSubject;
use App\Models\ClassSubjectTeacher;
use App\Models\Exam;
use App\Models\ExamRecord;
use App\Models\Mark;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Scores extends Component
{
  public $exam_id;
  public $class_id;
  public $subject_id;
  public $classes = [];
  public $subjects = [];

  protected $listeners = ['create_marks'];
  protected array $rules = [
    'exam_id' => 'required',
    'class_id' => 'required',
    'subject_id' => 'required',
  ];

  protected array $validationAttributes = [
    'exam_id' => 'exam',
    'class_id' => 'class',
    'subject_id' => 'subject',
  ];

  public function render(): Factory|View|Application
  {
    // get exams for current session
    $exams = Exam::get();

    if (auth('teacher')->user()) {
      // show classes only when user has selected an exam
      if (!empty($this->exam_id)) {
        $this->classes = ClassSubjectTeacher::where('teacher_id', auth()->id())
          ->with('subject', 'class_room')
          ->select('class_room_id')
          ->distinct()
          ->get();
      }

//    show subjects specific to a class
      if (!empty($this->class_id)) {
        $this->subjects = ClassSubjectTeacher::where('teacher_id', auth()->id())
          ->where('class_room_id', $this->class_id)
          ->with('subject')
          ->get();
      }
    }

    if (auth('principal')->user()) {
      // show classes only when user has selected an exam
      if (!empty($this->exam_id)) {
        $this->classes = ClassRoom::get();
      }

//    show subjects specific to a class
      if (!empty($this->class_id)) {
        $this->subjects = ClassSubjectTeacher::where('teacher_id', auth()->id())
          ->where('class_room_id', $this->class_id)
          ->with('subject')
          ->get();
      }
    }

    return view('livewire.components.scores', compact('exams'));
  }

//  get values from select box
  public function manage(): void
  {
    $value = $this->validate();

    //  add records to mark table
    $student_id = ClassStudentSubject::where('subject_id', $this->subject_id)
      ->where('class_room_id', $this->class_id)
      ->get('student_id');

    $year = Exam::where('id', $this->exam_id)->first()->session;

    foreach ($student_id as $id) {
      Mark::firstOrCreate([
        'student_id' => $id->student_id,
        'subject_id' => $this->subject_id,
        'class_room_id' => $this->class_id,
        'exam_id' => $this->exam_id,
        'year' => $year,
      ]);

      ExamRecord::firstOrCreate([
        'student_id' => $id->student_id,
        'class_room_id' => $this->class_id,
        'exam_id' => $this->exam_id,
        'year' => $year,
      ]);
    }
    //  add records to mark table

    $this->emit('getValues', $value);
  }
}
