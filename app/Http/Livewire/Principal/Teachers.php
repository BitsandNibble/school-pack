<?php

namespace App\Http\Livewire\Principal;

use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Teachers extends Component
{
  use WithPagination;

  public $q;
  public $teacher, $teacherInfo, $teacherClassInfo, $deleting;
  public $selected_class_id, $teacher_id, $existingClass;
  protected $paginationTheme = 'bootstrap';

  protected $queryString = [
    // 'active' => ['except' => false],
    'q' => ['except' => ''],
    // 'sortBy' => ['except' => 'id'],
    // 'sortAsc' => ['except' => true],
  ];

  protected $rules = [
    'teacher.firstname' => 'required|string',
    'teacher.middlename' => 'sometimes|string',
    'teacher.lastname' => 'required|string',
    'teacher.title' => 'required',
    'teacher.gender' => 'sometimes',
    'teacher.class_id' => 'sometimes',
  ];

  protected $validationAttributes = [
    'teacher.firstname' => 'firstname',
    'teacher.middlename' => 'middlename',
    'teacher.lastname' => 'lastname',
    'teacher.title' => 'title',
    'teacher.gender' => 'gender',
    'teacher.class_id' => 'class Id',
  ];

  public function render()
  {
    $teachers = Teacher::when($this->q, function ($query) {
      return $query->search($this->q);
    })->with('classRooms')->Paginate(10);
    $classes = ClassRoom::whereDoesntHave('teachers')->get();

    return view('livewire.principal.teachers', compact('teachers', 'classes'));
  }

  public function updatingQ()
  {
    $this->resetPage();
  }

  public function cancel()
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id)
  {
    $teacher = Teacher::where('id', $id)->with('classRooms')->first();
    $this->teacher_id = $teacher['id'];
    $this->teacher = $teacher;

    foreach ($teacher->classRooms()->get() as $teacherClass) {
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
        'firstname' => $this->teacher['firstname'],
        'middlename' => $this->teacher['middlename'] ?? '',
        'lastname' => $this->teacher['lastname'],
        'title' => $this->teacher['title'],
        'gender' => $this->teacher['gender'] ?? '',
        'slug' => Str::slug($this->teacher['firstname'], '-'),
      ]);
      session()->flash('message', 'Teacher Updated Successfully');
    } else {
      $teacher = Teacher::create([
        'firstname' => $this->teacher['firstname'],
        'middlename' => $this->teacher['middlename'] ?? '',
        'lastname' => $this->teacher['lastname'],
        'title' => $this->teacher['title'],
        'gender' => $this->teacher['gender'] ?? '',
        'staff_id' => 'GS_' . mt_rand(500, 1000),
        'password' => Hash::make('password'),
        'slug' => Str::slug($this->teacher['firstname'], '-'),
      ]);
      session()->flash('message', 'Teacher Added Successfully');
    }

    if (!empty($this->teacher['class_id'])) {
      $teacher->classRooms()->sync($this->teacher['class_id']);
    }

    $this->cancel();
  }

  public function showInfo($id)
  {
    $teacher = Teacher::where('id', $id)->with('classRooms')->first();

    foreach ($teacher->classRooms()->get() as $teacherClass) {
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
    $teacher->classRooms()->detach($this->teacher_id);
    $teacher->delete();
    $this->cancel();
  }
}
