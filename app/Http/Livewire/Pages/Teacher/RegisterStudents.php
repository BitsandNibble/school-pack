<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\ClassStudentSubject;
use App\Models\ClassSubjectTeacher;
use App\Models\Student as StudentModel;
use App\Models\Subject;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class RegisterStudents extends Component
{
  use WithPagination;
  use LivewireAlert;

  public $class_id;
  public $section_id;
  public $subject_name;
  public $subject_id;
  public $fullname = [];
  public $q;
  public $sortBy = 'name';
  public $sortAsc = true;
  public $paginate = 10;
  public $selectAll = false;

  protected string $paginationTheme = 'bootstrap';

  protected array $rules = [
    'fullname' => 'required',
  ];

  public function mount($id): void
  {
    $this->class_id = $id[0] ?? $id;
    $this->section_id = $id[1] ?? null;
  }

  public function render(): Factory|View|Application
  {
    $cst = ClassSubjectTeacher::select('subject_id')->where('class_room_id', $this->class_id)->get();
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
    return StudentModel::where('class_room_id', $this->class_id)
      ->where('section_id', $this->section_id)
      ->get();
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

  public function registerStudents($value): void
  {
    $this->subject_id = $value;
    $sub = Subject::find($value);
    $this->subject_name = $sub['name'];
    $css = ClassStudentSubject::where('subject_id', $value)
      ->where('class_room_id', $this->class_id)
      ->pluck('student_id')->toArray();
    $this->fullname = StudentModel::whereIn('id', $css)->get()->pluck('id')->toArray();
  }

  public function store(): void
  {
    $this->validate();

    foreach ($this->fullname as $student_id) {
      ClassStudentSubject::updateOrCreate([
        'class_room_id' => $this->class_id,
        'student_id' => $student_id,
        'subject_id' => $this->subject_id,
      ]);
    }

    $this->alert('success', 'Student Registered Successfully');
    $this->cancel();
  }

  public function cancel(): void
  {
    $this->reset(['fullname', 'subject_name', 'selectAll']);
    $this->emit('closeModal');
  }
}
