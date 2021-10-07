<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassSubjectTeacher;
use App\Models\Exam;
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

  protected $listeners = ['create_marks'];
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
    // get all exams
    $exams = Exam::get();

    // show classes only when user has selected an exam
    if (!empty($this->exam_id)) {
      $this->classes = ClassSubjectTeacher::where('teacher_id', auth()->id())
        ->with('class_room')
        ->select('class_room_id')
        ->distinct()
        ->get();
    }

    return view('livewire.pages.principal.tabulation-sheet', compact('exams'));
  }


//  get values from select box
  public function view(): void
  {
    $value = $this->validate();
    $this->emit('getValues', $value);
  }
}
