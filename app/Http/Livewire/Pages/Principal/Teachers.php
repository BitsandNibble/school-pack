<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\ClassSubjectTeacher;
use App\Models\Section;
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
  public $teacher_id;
  public $assigned_subject_id;
  protected $paginationTheme = 'bootstrap';

  protected $queryString = [
    'q' => ['except' => ''],
    'sortBy' => ['except' => 'fullname'],
    'sortAsc' => ['except' => true],
  ];

  protected $rules = [
    'teacher.title' => 'required',
    'teacher.fullname' => 'required|string',
    'teacher.email' => 'sometimes|email',
    'teacher.gender' => 'sometimes',
  ];

  protected $validationAttributes = [
    'teacher.title' => 'title',
    'teacher.fullname' => 'fullname',
    'teacher.email' => 'email',
    'teacher.gender' => 'gender',
  ];

  public function render()
  {
    $teachers = Teacher::when($this->q, function ($query) {
      return $query->search($this->q);
    })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
      ->Paginate($this->paginate);

    $classes = ClassRoom::get();
    if (!empty($this->class)) {
      $this->sections = Section::where('class_room_id', $this->class)->get();
    }

    return view('livewire.pages.principal.teachers', compact('teachers', 'classes'));
  }

  public function updatingQ(): void
  {
    $this->resetPage();
  }

  public function sortBy($field): void
  {
    if ($field == $this->sortBy) {
      $this->sortAsc = !$this->sortAsc;
    }
    $this->sortBy = $field;
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $teacher = Teacher::where('id', $id)->first();
    $this->teacher_id = $teacher['id'];
    $this->teacher = $teacher;
  }

  public function store(): void
  {
    $this->validate();

    if ($this->teacher_id) {
      $teacher = Teacher::find($this->teacher_id);
      $teacher->update([
        'fullname' => $this->teacher['fullname'],
        'title' => $this->teacher['title'],
        'email' => $this->teacher['email'] ?? '',
        'gender' => $this->teacher['gender'] ?? '',
        'slug' => Str::slug($this->teacher['fullname']),
      ]);
      session()->flash('message', 'Teacher Updated Successfully');
    } else {
      $teacher = Teacher::create([
        'fullname' => $this->teacher['fullname'],
        'title' => $this->teacher['title'],
        'email' => $this->teacher['email'] ?? '',
        'gender' => $this->teacher['gender'] ?? '',
        'school_id' => 'GS_' . mt_rand(500, 1000),
        'password' => Hash::make('password'),
        'slug' => Str::slug($this->teacher['fullname']),
      ]);
      session()->flash('message', 'Teacher Added Successfully');
    }

    $this->cancel();
  }

  public function showInfo($id): void
  {
    $teacher = Teacher::where('id', $id)->first();
//    $assignedSubjects = ClassSubjectTeacher::where('teacher_id', $id)->get();
    $this->assigned_subject_id = ClassSubjectTeacher::where('teacher_id', $id)->get();

    $this->teacherInfo = $teacher;
  }

  public function deleteExistingClass($id): void
  {
    $class = ClassRoom::where('id', $id)->with('teachers')->first();

    foreach ($class->teachers()->get() as $classTeacher) {
      $class->teachers()->detach($classTeacher->id);
    }

    $this->cancel();
  }

  public function openDeleteModal($id): void
  {
    $del = Teacher::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Teacher $teacher): void
  {
    $teacher->classes()->detach($this->teacher_id);
    $teacher->delete();
    $this->cancel();
  }
}
