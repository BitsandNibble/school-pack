<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\Subject;
use Livewire\Component;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Models\ClassStudentSubject;
use App\Models\ClassSubjectTeacher;
use Illuminate\Contracts\View\View;
use App\Models\Student as StudentModel;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @property mixed subjects
 * @property mixed rows
 * @property mixed subjectsQuery
 * @property mixed rowsQuery
 */
class RegisterStudents extends Component
{
  use WithPagination;
  use LivewireAlert;
  use WithSorting;

  public $class_id;
  public $section_id;
  public $subject_name;
  public $subject_id;
  public $fullname = [];
  public $q;
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

  public function getRowsQueryProperty()
  {
    return StudentModel::where('class_room_id', $this->class_id)
      ->where('section_id', $this->section_id);
  }

  public function getRowsProperty()
  {
    return $this->rowsQuery->get();
  }

  public function getSubjectsQueryProperty()
  {
    $cst = ClassSubjectTeacher::select('subject_id')->where('class_room_id', $this->class_id)->get();

    $query = Subject::whereIn('id', $cst)
      ->when($this->q, fn($query) => $query->search($this->q));

    return $this->applySorting($query); // apply sorting
  }

  public function getSubjectsProperty()
  {
    return $this->subjectsQuery->paginate($this->paginate);
  }

  public function render(): Factory|View|Application
  {
    $subjects = $this->subjects;

    $students = $this->rows;

    return view('livewire.pages.teacher.register-students', compact('subjects', 'students'));
  }

  public function updatedSelectAll($value): void
  {
    if ($value) {
      $this->fullname = $this->rows->pluck('id')->map(fn($item) => (string)$item);
    } else {
      $this->fullname = [];
    }
  }

  public function updatedFullname(): void
  {
    $this->selectAll = false;
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
