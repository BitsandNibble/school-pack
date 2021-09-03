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
    $teachers = Teacher::where('class_id', NULL)->get();

    return view('livewire.principal.classes', compact('classes', 'teachers'));
  }

  public function close()
  {
    $this->reset(['class']);
    $this->emit('closeModal');
  }

  public function store(StudentClass $class)
  {
    $this->validate();

    $class->create([
      'name' => $this->class['name'],
      'teacher_id' => $this->class['teacher_id'] ?? null,
    ]);

    $id = StudentClass::latest()->first();
    $teach = Teacher::where('id', $this->class['teacher_id'])->first();
    $teach->class_id = $id['id'];
    $teach->save();

    session()->flash('message', 'Class Added Successfully');
    $this->reset(['class']);
    $this->emit('closeModal');
  }

  public function delete(StudentClass $class)
  {
    $class->delete();
  }
}
