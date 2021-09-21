<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Student as StudentModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Student extends Component
{
  use WithPagination;

  public $q, $sortBy = 'fullname', $sortAsc = true, $paginate = 10;
  public $class_id, $parent, $title = 'All Students';
  public $student, $class;
  protected $paginationTheme = 'bootstrap';
  protected $listeners = ['refresh', 'filterStudents', 'fetchAll'];

  protected $rules = [
    'student.fullname' => 'required|string',
    'student.gender' => 'sometimes',
  ];

  protected $validationAttributes = [
    'student.fullname' => 'fullname',
    'student.gender' => 'gender',
  ];

  protected $queryString = [
    'q' => ['except' => ''],
    'sortBy' => ['except' => 'fullname'],
    'sortAsc' => ['except' => true],
  ];

  public function mount($id, $type): void
  {
    $this->class_id = $id;
    $this->parent = $type;

    // fetching from parent component which gets value from coontroller
    // type 1 = student
    // type 2 = class
  }

  public function render()
  {
    if ($this->class_id) {
      $class = ClassRoom::findOrFail($this->class_id);
      $this->class = $class;

      $students = $class->students()->wherePivot('class_room_id', $this->class_id)
        ->when($this->q, function ($query) {
          return $query->search($this->q);
        })
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
        ->Paginate($this->paginate);
      $this->title = $class->name;
    } else {
      $students = StudentModel::when($this->q, function ($query) {
        return $query->search($this->q);
      })
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
        ->Paginate($this->paginate);
    }

    return view('livewire.pages.principal.student', compact('students'));
  }

  public function updatingQ(): void
  {
    $this->resetPage();
  }

  public function sortBy($field): void
  {
    if ($field === $this->sortBy) {
      $this->sortAsc = !$this->sortAsc;
    }
    $this->sortBy = $field;
  }

  public function filterStudents($id): void
  {
    $this->class_id = $id;
  }

  public function fetchAll(): void
  {
    $this->class_id = '';
    $this->title = 'All Students';
  }

  public function refresh(): void
  {
    $this->render();
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset(['student']);
  }

  public function store(): void
  {
    $this->validate();

    $student = StudentModel::create([
      'fullname' => $this->student['fullname'],
      'gender' => $this->student['gender'] ?? '',
      'school_id' => 'GS_' . random_int(500, 1000),
      'password' => Hash::make('password'),
      'slug' => Str::slug($this->student['fullname']),
    ]);
    $student->classes()->sync($this->class);
    $this->cancel();

    session()->flash('message', 'Student Added Successfully');
  }
}
