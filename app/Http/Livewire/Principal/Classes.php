<?php

namespace App\Http\Livewire\Principal;

use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Classes extends Component
{
  use WithPagination;

  public $name;
  public $class_id, $existingTeacher, $teacher_id;
  public $reset = ['name', 'teacher_id', 'class_id']; // fields to reset
  protected $paginationTheme = 'bootstrap';

  protected $rules;
  protected function rules()
  {
    return [
      'name' => ['required', 'string', Rule::unique('class_rooms')->ignore($this->class_id)],
    ];
  }

  public function render()
  {
    $classes = ClassRoom::orderBy('name')->with('teachers')->Paginate(6);
    $teachers = Teacher::whereDoesntHave('classRooms')->get();

    return view('livewire.principal.classes', compact('classes', 'teachers'));
  }

  public function cancel()
  {
    $this->emit('closeModal');
    $this->reset($this->reset);
    // $this->reset(['name', 'teacher_id', 'class_id']);
  }

  public function edit($id)
  {
    $class = ClassRoom::where('id', $id)->with('teachers')->first();
    $this->class_id = $class['id'];

    $this->name = $class->name;
    foreach ($class->teachers()->get() as $classTeacher) {
      $this->teacher_id = $classTeacher->id;
      $this->existingTeacher = $classTeacher->title . ' ' . $classTeacher->fullname;
    }
  }

  public function store()
  {
    $validated = $this->validate();

    if ($this->class_id) {
      $class = ClassRoom::find($this->class_id);
      $class->update($validated);
      session()->flash('message', 'Class Updated Successfully');
    } else {
      $class = ClassRoom::create($validated);
      session()->flash('message', 'Class Added Successfully');
    }

    if (!empty($this->teacher_id)) {
      $class->teachers()->sync($this->teacher_id);
    }

    $this->cancel();
  }

  public function deleteExistingTeacher($id)
  {
    $teacher = Teacher::where('id', $id)->with('classRooms')->first();

    foreach ($teacher->classRooms()->get() as $teacherClass) {
      $teacher->classRooms()->detach($teacherClass->id);
    }

    $this->cancel();
  }

  public function delete(ClassRoom $class)
  {
    $class->teachers()->detach($this->teacher_id);
    $class->delete();
  }
}
