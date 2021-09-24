<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Student as StudentModel;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Student extends Component
{
  use WithPagination;

  public $q;
  public $sortBy = 'fullname';
  public $sortAsc = true;
  public $paginate = 10;
  public $class_id;
  public $parent;
  public $title = 'All Students';
  public $student;
  public $class_name;

  protected string $paginationTheme = 'bootstrap';
  protected $listeners = ['refresh', 'filterStudents', 'fetchAll'];

  protected array $rules = [
    'student.fullname' => 'required|string',
    'student.gender' => 'sometimes',
  ];

  protected array $validationAttributes = [
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

    // fetching from parent component which gets value from controller
    // type 1 = student
    // type 2 = class
  }

  public function render(): Factory|View|Application
  {
    if ($this->class_id) {
      $this->title = ClassRoom::where('id', $this->class_id)->first()->name;

      $students = StudentModel::where('class_room_id', $this->class_id)
        ->when($this->q, function ($query) {
          return $query->search($this->q);
        })
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
        ->paginate(10);
      foreach ($students as $student) {
        $this->class_name = $student->class_room->name;
      }
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

  /**
   * @throws Exception
   */
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
