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
  public $class_id, $deleting;
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
    $classes = ClassSubjectTeacher::where('class_room_id', $this->class_id)->get();

//    fetching individual models from pivot table
//    $class = ClassRoom::with('subjectTeachers', 'subjects')
//      ->where('id', $this->class_id)
//      ->first();
//    $w = $class->subjects()->get();
//    $z = $class->subjectTeachers()->get();

    return view('livewire.pages.principal.subject', compact('availableSubjects', 'classes', 'allTeachers', 'class'));
  }

  public function edit($id)
  {
//    $teacher = Teacher::where('id', $id)->with('classRooms')->first();
//    $class = ClassRoom::find($id);
//    $class = ClassRoom::with('subjectTeachers', 'subjects')
    $class = ClassRoom::find($this->class_id);


//      ->find($this->class_id);
//    $this->teacher_id = $teacher['id'];

//    dd($class->subjects()->get());
    foreach ($class->subjects()->get() as $sub) {
//      $this->selected_class_id = $teacherClass->id;
      $this->subject = $sub->id;
//    dd($this->subject);
    }

    foreach ($class->subjectTeachers()->get() as $subT) {
//      $this->selected_class_id = $teacherClass->id;
      $this->teacher = $subT->id;
//    dd($this->teacher);
    }
  }

  public function store(): void
  {
    $this->validate();

    $class = ClassRoom::find($this->class_id);

//    $subject = SubjectModel::find($this->subject);
//    $teacher = Teacher::find($this->teacher);
//
//    $well = $subject->classes()->sync($this->class_id);
//    $well2 = $teacher->classes()->sync($this->class_id);

    if ($this->class_id) {
      $well = $class->subjects()->sync($this->subject,
        [
//      'subject_id' => $this->subject,
          'teacher_id' => $this->teacher
        ]);
    } else {

      $well = $class->subjects()->attach($this->subject,
        [
//      'subject_id' => $this->subject,
          'teacher_id' => $this->teacher
        ]);
//    $well2 = $teacher->subjects()->sync($this->subject);
    }

    session()->flash('message', 'Added Successfully');
    $this->cancel();
  }

  public function openDeleteModal($id)
  {
//    dd($id);
    $del = ClassSubjectTeacher::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(ClassSubjectTeacher $cst)
  {
//    $cst->subjects()->detach($this->class_id);
//    dd($cst);
    $cst->delete();
    session()->flash('message', 'Deleted Successfully');
    $this->cancel();
  }

}
