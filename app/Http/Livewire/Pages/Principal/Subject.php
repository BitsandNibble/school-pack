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

  public function mount($id)
  {
    $this->class_id = $id;
  }

  public function render()
  {
    $teachers = Teacher::get();
    $class = ClassRoom::findOrFail($this->class_id);
    $availableSubjects = SubjectModel::get();

    $subjects = $class->subjects()->wherePivot('class_room_id', $this->class_id)
      ->when($this->q, function ($query) {
        return $query->search($this->q);
      })->get();

    $this->title = $class->name;

    return view('livewire.pages.principal.subject', compact('availableSubjects', 'subjects', 'class', 'teachers'));
  }

  public function store(): void
  {
    $this->validate();
  }

}
