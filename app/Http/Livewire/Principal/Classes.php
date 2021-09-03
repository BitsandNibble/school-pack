<?php

namespace App\Http\Livewire\Principal;

use App\Models\StudentClass;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;

class Classes extends Component
{
  use WithPagination;

  public $class;
  protected $paginationTheme = 'bootstrap';

  protected $rules = [
    'class.name' => 'required|string|unique:classes,name',
  ];

  public function render()
  {
    $classes = StudentClass::Paginate(10);
    $teachers = Teacher::where('class_teacher', '')->get();

    return view('livewire.principal.classes', compact('classes', 'teachers'));
  }

  public function saveClass(StudentClass $student)
  {
    $this->validate();

    $student->create([
      'name' => $this->class['name'],
      'teacher_id' => $this->class['teacher_id'] ?? '',
    ]);

    session()->flash('message', 'Class Added Successfully');
    $this->reset(['class']);
    $this->emit('closeModal');
  }

  public function close()
  {
    $this->reset(['class']);
    $this->emit('closeModal');
  }
}
