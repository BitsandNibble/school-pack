<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\ClassStudentSubject;
use App\Models\ClassSubjectTeacher;
use App\Models\Student as StudentModel;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class RegisterStudents extends Component
{
  use WithPagination;

  public $class_id, $subject_id, $subject_name, $fullname = [];
  public $q, $sortBy = 'name', $sortAsc = true, $paginate = 10;
  public $selectAll = false;
  protected $paginationTheme = 'bootstrap';

  protected $rules = [
    'fullname' => 'required',
  ];

  public function mount($id): void
  {
    $this->class_id = $id;
  }

  public function render()
  {
    $cst = ClassSubjectTeacher::select('subject_id')->whereClassRoomId($this->class_id)->get();
    $subjects = Subject::whereIn('id', $cst)
      ->when($this->q, function ($query) {
        return $query->search($this->q);
      })
      ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
      ->Paginate($this->paginate);

    $students = $this->students;

    return view('livewire.pages.teacher.register-students', compact('subjects', 'students'));
  }

  public function updatedSelectAll($value): void
  {
    if ($value) {
      $this->fullname = $this->students->pluck('id')->map(fn($item) => (string)$item);
    } else {
      $this->fullname = [];
    }
  }

  public function getStudentsProperty()
  {
    return StudentModel::where('class_room_id', $this->class_id)->get();
  }

  public function updatedFullname(): void
  {
    $this->selectAll = false;
  }

  public function sortBy($field): void
  {
    if ($field === $this->sortBy) {
      $this->sortAsc = !$this->sortAsc;
    }
    $this->sortBy = $field;
  }

  public function subjectName($value): void
  {
    $this->subject_id = $value;
    $sub = Subject::find($this->subject_id);
    $this->subject_name = $sub['name'];
  }

  public function store(): void
  {
    $this->validate();

    foreach ($this->fullname as $student_id) {
      ClassStudentSubject::updateOrCreate([
        'class_room_id' => $this->class_id,
        'student_id' => $student_id,
//        'student_id' => $this->fullname,
        'subject_id' => $this->subject_id,
      ]);
    }

    session()->flash('message', 'Student Registered Successfully');
    $this->cancel();
  }

  public function cancel(): void
  {
    $this->reset(['fullname', 'subject_name', 'selectAll']);
    $this->emit('closeModal');
  }
}
