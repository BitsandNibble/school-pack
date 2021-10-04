<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Helpers\GR;
use App\Helpers\SP;
use App\Models\ClassRoom;
use App\Models\ClassType;
use App\Models\Exam;
use App\Models\Mark;
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
  public $exam_id;
  public $class_id;
  public $subject_id;
  public $marks;
  public $get_marks;
  public $data;
  public $ca1_limit;
  public $ca2_limit;
  public $exam_limit;
  public bool $showEdit = false;

  protected $listeners = ['getValues'];
  protected array $rules;

  protected function rules()
  {
    return [
////    'student_id' => 'required|exists:students,id',
////    'marks.subject_id' => 'required|exists:subjects,id',
////    'marks.class_room_id' => 'required|exists:class_rooms,id',
////    'marks.exam_id' => 'required|exists:exams,id',
      'marks.ca1' => 'sometimes|numeric|max:' . $this->ca1_limit,
      'marks.ca2' => 'sometimes|numeric|max:' . $this->ca2_limit,
      'marks.exam_score' => 'sometimes|numeric|max:' . $this->exam_limit,
    ];
  }

  protected array $validationAttributes = [
    'marks.ca1' => 'first CA score',
    'marks.ca2' => 'second CA score',
    'marks.exam_score' => 'exam score',
  ];

  public function render(): Factory|View|Application
  {
    $this->ca1_limit = SP::getSetting('ca1');
    $this->ca2_limit = SP::getSetting('ca2');
    $this->exam_limit = SP::getSetting('exam');
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
    $this->class_id = $value['class_id'];
    $this->subject_id = $value['subject_id'];
    $this->exam_id = $value['exam_id'];

//    use this for where clause to avoid duplicates
    $this->data = [
      'exam_id' => $this->exam_id,
      'class_room_id' => $this->class_id,
      'subject_id' => $this->subject_id,
    ];

    $this->subject = Subject::where('id', $value['subject_id'])->first()->name;
    $this->class = ClassRoom::where('id', $value['class_id'])->first()->name;
    $this->exam = Exam::where('id', $value['exam_id'])->first()->name;
  }

  public function store(): void
  {
    $this->validate();

//    get class_type_id to use for assigning grades
    $get_class_id = ClassRoom::find($this->class_id)->class_type_id;
    $class_type_id = ClassType::find($get_class_id)->id;

    $year = SP::getSetting('current_session');

//    fetch data from mark table so that data can be inserted to specific students
    $marks = Mark::where($this->data)->with('grade')->get();

//    update records in mark table
    foreach ($marks as $mark) {
//    using $d[''] for future purpose, when we want to also update exam_records table as we assign marks
//    so, we're going to do something like ExamRecord->update($d)
      $d['ca1'] = $ca1 = $this->marks['ca1'] ?? null;
      $d['ca2'] = $ca2 = $this->marks['ca2'] ?? null;
      $d['tca'] = $tca = $ca1 + $ca2;
      $d['exam'] = $exam = $this->marks['exam_score'] ?? null;
      $d['total'] = $total = $tca + $exam;

      $grade = GR::getGrade($total, $class_type_id);
//      $d['grade_id'] = $grade ? $grade->id : NULL;
//      $d['grade_id'] = $grade?->id;

      $mark->update([
        'ca1' => $ca1,
        'ca2' => $ca2,
        'total_ca' => $tca,
        'exam_score' => $exam,
        'total_score' => $total,
        'grade_id' => $grade->id ?? null,
      ]);

    }

//    subject position
    foreach ($marks as $mark) {
      $d2['sub_pos'] = $sub_pos = GR::getSubjectPosition($mark->student_id, $this->exam_id, $this->class_id, $this->subject_id, $year);
      $mark->update(['subject_position' => $sub_pos]);
    }

    session()->flash('message', 'Mark Recorded Successfully');
  }
}
