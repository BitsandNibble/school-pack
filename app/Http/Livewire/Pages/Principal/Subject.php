<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\ClassSubjectTeacher;
use App\Models\Subject as SubjectModel;
use App\Models\Teacher;
use Livewire\Component;

class Subject extends Component
{
  public $q;
  public $class_id, $deleting, $class_subject_teacher;
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
    $classes = ClassSubjectTeacher::where('class_room_id', $this->class_id)
      ->with('subject', 'teacher')
      ->get();

    return view('livewire.pages.principal.subject', compact('availableSubjects', 'classes', 'allTeachers', 'class'));
  }

  public function edit($id)
  {
    $class = ClassSubjectTeacher::find($id);
    $this->class_subject_teacher = $id;

    $this->subject = $class->subject->id;
    $this->teacher = $class->teacher->id;
  }

  public function store(): void
  {
    $this->validate();

    if ($this->class_subject_teacher) {
      $class = ClassSubjectTeacher::find($this->class_subject_teacher);
      $class->update([
        'class_room_id' => $this->class_id,
        'subject_id' => $this->subject,
        'teacher_id' => $this->teacher,
      ]);
    } else {
      ClassSubjectTeacher::create([
        'class_room_id' => $this->class_id,
        'subject_id' => $this->subject,
        'teacher_id' => $this->teacher,
      ]);
    }

    session()->flash('message', 'Added Successfully');
    $this->cancel();
  }

  public function openDeleteModal($id)
  {
    $del = ClassSubjectTeacher::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(ClassSubjectTeacher $cst)
  {
    $cst->delete();
    session()->flash('message', 'Deleted Successfully');
    $this->cancel();
  }

}
