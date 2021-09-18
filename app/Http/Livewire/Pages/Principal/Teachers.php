<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\ClassSubjectTeacher;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Teachers extends Component
{
  use WithPagination;

  public $q, $sortBy = 'fullname', $sortAsc = true, $paginate = 10;
  public $teacher, $teacherInfo, $teacherClassInfo, $deleting;
  public $selected_class_id, $teacher_id, $existingClass;
  public $assigned_subject_id;
  protected $paginationTheme = 'bootstrap';

  protected $queryString = [
    'q' => ['except' => ''],
    'sortBy' => ['except' => 'fullname'],
    'sortAsc' => ['except' => true],
  ];

  protected $rules = [
    'teacher.fullname' => 'sometimes|string',
    'teacher.title' => 'required',
    'teacher.gender' => 'sometimes',
    'teacher.class_id' => 'sometimes',
  ];

  protected $validationAttributes = [
    'teacher.fullname' => 'fullname',
    'teacher.title' => 'title',
    'teacher.gender' => 'gender',
    'teacher.class_id' => 'class Id',
  ];

  public function render()
  {
    $teachers = Teacher::when($this->q, function ($query) {
      return $query->search($this->q);
    })->with('classes')
      ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
      ->Paginate($this->paginate);

    $classes = ClassRoom::whereDoesntHave('teachers')->get();

    return view('livewire.pages.principal.teachers', compact('teachers', 'classes'));
  }

  public function updatingQ()
  {
    $this->resetPage();
  }

  public function sortBy($field)
  {
    if ($field == $this->sortBy) {
      $this->sortAsc = !$this->sortAsc;
    }
    $this->sortBy = $field;
  }

  public function cancel()
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id)
  {
    $teacher = Teacher::where('id', $id)->with('classes')->first();
    $this->teacher_id = $teacher['id'];
    $this->teacher = $teacher;

    foreach ($teacher->classes()->get() as $teacherClass) {
      $this->selected_class_id = $teacherClass->id;
      $this->existingClass = $teacherClass->name;
    }
  }

  public function store()
  {
    $this->validate();

    if ($this->teacher_id) {
      $teacher = Teacher::find($this->teacher_id);
      $teacher->update([
        'fullname' => $this->teacher['fullname'],
        'title' => $this->teacher['title'],
        'gender' => $this->teacher['gender'] ?? '',
        'slug' => Str::slug($this->teacher['fullname']),
      ]);
      session()->flash('message', 'Teacher Updated Successfully');
    } else {
      $teacher = Teacher::create([
        'fullname' => $this->teacher['fullname'],
        'title' => $this->teacher['title'],
        'gender' => $this->teacher['gender'] ?? '',
        'school_id' => 'GS_' . mt_rand(500, 1000),
        'password' => Hash::make('password'),
        'slug' => Str::slug($this->teacher['fullname']),
      ]);
      session()->flash('message', 'Teacher Added Successfully');
    }

    if (!empty($this->teacher['class_id'])) {
      $teacher->classes()->sync($this->teacher['class_id']);
    }

    $this->cancel();
  }

  public function showInfo($id)
  {
    $teacher = Teacher::where('id', $id)->with('classes')->first();
//    $assignedSubjects = ClassSubjectTeacher::where('teacher_id', $id)->get();
    $this->assigned_subject_id = ClassSubjectTeacher::where('teacher_id', $id)->get();

    foreach ($teacher->classes()->get() as $teacherClass) {
      $this->teacherClassInfo = $teacherClass->name;
    }

    $this->teacherInfo = $teacher;
  }

  public function deleteExistingClass($id)
  {
    $class = ClassRoom::where('id', $id)->with('teachers')->first();

    foreach ($class->teachers()->get() as $classTeacher) {
      $class->teachers()->detach($classTeacher->id);
    }

    $this->cancel();
  }

  public function openDeleteModal($id)
  {
    $del = Teacher::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Teacher $teacher)
  {
    $teacher->classes()->detach($this->teacher_id);
    $teacher->delete();
    $this->cancel();
  }
}
