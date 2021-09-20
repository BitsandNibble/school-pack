<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Section;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;

class Sections extends Component
{
  use WithPagination;

  public $name, $class, $deleting, $paginate = 10;
  public $section_id, $teacher_id;

  protected $paginationTheme = 'bootstrap';
  protected $rules = [
    'name' => 'required|string',
    'class' => 'required',
  ];

  public function render()
  {
    $classes = ClassRoom::orderBy('name')->get();
    $teachers = Teacher::get();
    $sections = Section::paginate($this->paginate);

    return view('livewire.pages.principal.sections', compact('classes', 'teachers', 'sections'));
  }

  public function cancel()
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id)
  {
    $section = Section::where('id', $id)->first();
    $this->section_id = $section['id'];
    $this->name = $section->name;
    $this->class = $section->class_room_id;
    $this->teacher_id = $section->teacher_id;
  }

  public function store()
  {
    $this->validate();

    if ($this->section_id) {
      $section = Section::find($this->section_id);
      $section->update([
        'name' => $this->name,
        'class_room_id' => $this->class,
        'teacher_id' => $this->teacher_id !== "" ? $this->teacher_id : null,
      ]);
      session()->flash('message', 'Section Updated Successfully');
    } else {
      Section::create([
        'name' => $this->name,
        'class_room_id' => $this->class,
        'teacher_id' => $this->teacher_id
      ]);
      session()->flash('message', 'Section Added Successfully');
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
    $del = Section::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Section $section)
  {
    $section->delete();
    $this->cancel();
    session()->flash('message', 'Section Deleted Successfully');
  }
}
