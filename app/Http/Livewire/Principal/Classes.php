<?php

namespace App\Http\Livewire\Principal;

use App\Models\ClassRoom;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;

class Classes extends Component
{
  use WithPagination;

  public $class;
  protected $paginationTheme = 'bootstrap';

  protected $rules = [
    'class.name' => 'required|string|unique:class_rooms,name',
  ];

  public function render()
  {
    $classes = ClassRoom::with('teachers')->Paginate(10);
    $teachers = Teacher::whereDoesntHave('classRooms')->get();

    return view('livewire.principal.classes', compact('classes', 'teachers'));
  }

  public function close()
  {
    $this->reset(['class']);
    $this->emit('closeModal');
  }

  public function store()
  {
    $this->validate();

    $class = ClassRoom::create([
      'name' => $this->class['name'],
      'teacher_id' => $this->class['teacher_id'] ?? null,
    ]);

    if (!empty($this->class['teacher_id'])) {
      $class->teachers()->sync($this->class['teacher_id']);
    }

    session()->flash('message', 'Class Added Successfully');
    $this->reset(['class']);
    $this->emit('closeModal');
  }

  public function delete(ClassRoom $class)
  {
    $class->delete();
  }
}
