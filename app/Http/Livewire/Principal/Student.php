<?php

namespace App\Http\Livewire\Principal;

use App\Models\ClassRoom;
use App\Models\Student as ModelsStudent;
use Livewire\Component;
use Livewire\WithPagination;

class Student extends Component
{
  use WithPagination;

  public $class_id, $parent;

  protected $paginationTheme = 'bootstrap';

  protected $listeners = ['refresh', 'filterStudents', 'fetchAll'];

  public function mount($id, $type)
  {
    $this->class_id = $id;
    $this->parent = $type;

    // type 1 = student
    // type 2 = class
  }

  public function render()
  {
    if ($this->class_id) {
      $class = ClassRoom::findOrFail($this->class_id);
      $students = $class->students()->wherePivot('class_room_id', $this->class_id)->Paginate(10);
      $this->emit('changeTitle', $class->name);
    } else {
      $students = ModelsStudent::with('classRooms')->Paginate(10);
    }

    return view('livewire.principal.student', compact('students'));
  }

  public function filterStudents($id)
  {
    $this->class_id = $id;
  }

  public function fetchAll()
  {
    $this->class_id = '';
  }

  public function refresh()
  {
    $this->render();
  }

  public function edit($id)
  {
    $this->emit('edit', $id);
  }

  public function showInfo($id)
  {
    $this->emit('showInfo', $id);
  }

  public function openDeleteModal($id)
  {
    $this->emit('openDeleteModal', $id);
  }
}
