<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Classes extends Component
{
  use WithPagination;

  public $name, $deleting, $paginate = 6;
  public $class_id, $existingTeacher, $teacher_id;

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
    $classes = ClassRoom::orderBy('name')->with('teachers')->Paginate($this->paginate);
    $teachers = Teacher::whereDoesntHave('classes')->get();

    return view('livewire.pages.principal.classes', compact('classes', 'teachers'));
  }

  public function cancel()
  {
    $this->emit('closeModal');
    $this->reset();
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
    $teacher = Teacher::where('id', $id)->with('classes')->first();

    foreach ($teacher->classes()->get() as $teacherClass) {
      $teacher->classes()->detach($teacherClass->id);
    }

    $this->cancel();
  }

  public function openDeleteModal($id)
  {
    $del = ClassRoom::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(ClassRoom $class)
  {
    $class->teachers()->detach($this->teacher_id);
    $class->delete();
    $this->cancel();
  }
}
