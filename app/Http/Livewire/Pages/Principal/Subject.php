<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher;
use Livewire\Component;

class Subject extends Component
{
  public $q;
  public $class_id;
  public $subject, $teacher;

  public $rules = [
    'subject' => 'required',
    'teacher' => 'required'
  ];

  public function cancel()
  {
    $this->emit('closeModal');
    $this->reset(['teacher', 'subject']);
  }

  public function mount($id): void
  {
    $this->class_id = $id;
  }

  public function render()
  {
    $allTeachers = Teacher::get();
    $class = ClassRoom::findOrFail($this->class_id);
    $availableSubjects = SubjectModel::get();

//    $subjects = $class->subject()->wherePivot('class_room_id', $this->class_id)
//      ->when($this->q, function ($query) {
//        return $query->search($this->q);
//      })->get();
    $subjects = SubjectModel::get();

    $this->title = $class->name;

    return view('livewire.pages.principal.subject', compact('availableSubjects', 'subjects', 'class', 'allTeachers'));
  }

  public function store(): void
  {
    $this->validate();

//    $class = ClassRoom::find($this->class_id);

//    $subject = SubjectModel::find($this->subject);
//    $teacher = Teacher::find($this->teacher);
//
//    $well = $subject->classes()->sync($this->class_id);
//    $well2 = $teacher->classes()->sync($this->class_id);

//    $well = $class->subjects()->sync($this->subject);
//    $well2 = $teacher->subjects()->sync($this->subject);

    session()->flash('message', 'Teacher Added Successfully');
    $this->cancel();
  }

}
