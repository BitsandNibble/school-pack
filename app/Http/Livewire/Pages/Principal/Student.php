<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Student as ModelsStudent;
use Livewire\Component;
use Livewire\WithPagination;

class Student extends Component
{
  use WithPagination;

  public $q, $sortBy = 'fullname', $sortAsc = true, $paginate = 10;
  public $class_id, $parent, $title = 'All Students';
  protected $paginationTheme = 'bootstrap';
  protected $listeners = ['refresh', 'filterStudents', 'fetchAll'];

  protected $queryString = [
    'q' => ['except' => ''],
    'sortBy' => ['except' => 'fullname'],
    'sortAsc' => ['except' => true],
  ];

  public function mount($id, $type)
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

      $students = $class->students()->wherePivot('class_room_id', $this->class_id)
        ->when($this->q, function ($query) {
          return $query->search($this->q);
        })
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
        ->Paginate($this->paginate);
      $this->title = $class->name;
    } else {
      $students = ModelsStudent::when($this->q, function ($query) {
        return $query->search($this->q);
      })
        ->with('classes')
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
        ->Paginate($this->paginate);
    }

    return view('livewire.pages.principal.student', compact('students'));
  }

  public function updatingQ()
  {
    $this->resetPage();
  }

  public function sortBy($field)
  {
    if ($field == $this->sortBy) {
      $this->sortAsc = !$this->sortAsc;
    }
    $this->sortBy = $field;
  }

  public function filterStudents($id)
  {
    $this->class_id = $id;
  }

  public function fetchAll()
  {
    $this->class_id = '';
    $this->title = 'All Students';
  }

  public function refresh()
  {
    $this->render();
  }
}
