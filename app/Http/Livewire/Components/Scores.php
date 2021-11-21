<?php

namespace App\Http\Livewire\Components;

use App\Models\ClassRoom;
use App\Models\ClassStudentSubject;
use App\Models\ClassSubjectTeacher;
use App\Models\ExamRecord;
use App\Models\Mark;
use App\Models\Term;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Scores extends Component
{
  public $term_id;
  public $class_id;
  public $subject_id;
  public $classes = [];
  public $subjects = [];

  protected $listeners = ['create_marks'];
  protected array $rules = [
    'term_id' => 'required',
    'class_id' => 'required',
    'subject_id' => 'required',
  ];

  protected array $validationAttributes = [
    'term_id' => 'term',
    'class_id' => 'class',
    'subject_id' => 'subject',
  ];

  public function render(): Factory|View|Application
  {
    // get terms for current session
    $terms = Term::get();

    if (auth('teacher')->user()) {
      // show classes only when user has selected an term
      if (!empty($this->term_id)) {
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
      // show classes only when user has selected an term
      if (!empty($this->term_id)) {
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

    return view('livewire.components.scores', compact('terms'));
  }

//  get values from select box
  public function manage(): void
  {
    $value = $this->validate();

    //  add records to mark table
    $student_id = ClassStudentSubject::where('subject_id', $this->subject_id)
      ->where('class_room_id', $this->class_id)
      ->get('student_id');

    $year = Term::where('id', $this->term_id)->first()->session;

    foreach ($student_id as $id) {
      Mark::firstOrCreate([
        'student_id' => $id->student_id,
        'subject_id' => $this->subject_id,
        'class_room_id' => $this->class_id,
        'term_id' => $this->term_id,
        'year' => $year,
      ]);

      ExamRecord::firstOrCreate([
        'student_id' => $id->student_id,
        'class_room_id' => $this->class_id,
        'term_id' => $this->term_id,
        'year' => $year,
      ]);
    }
    //  add records to mark table

    $this->emit('getValues', $value);
  }
}
