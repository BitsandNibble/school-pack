<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class Students extends Component
{
  public $student, $studentInfo, $studentClassInfo, $deleting;
  public $student_id;

  protected $listeners = ['edit', 'showInfo', 'openDeleteModal'];

  protected $rules = [
    'student.fullname' => 'required|string',
    'student.current_class' => 'required',
    'student.gender' => 'sometimes',
  ];

  protected $validationAttributes = [
    'student.fullname' => 'fullname',
    'student.current_class' => 'current class',
    'student.gender' => 'gender',
  ];

  public function render()
  {
    $classes = ClassRoom::orderBy('name')->with('students')->get();

    return view('livewire.pages.principal.students', compact('classes'));
  }

  public function cancel()
  {
    $this->emit('closeModal');
    $this->reset(['student', 'student_id', 'studentInfo', 'studentClassInfo']);
  }

  public function edit($id)
  {
    $student = Student::where('id', $id)->with('classes')->first();
    $this->student_id = $student['id'];
    $this->student  = $student;

    foreach ($student->classes()->get() as $studentClass) {
      $this->student['current_class'] = $studentClass->id;
    }
  }

  public function store()
  {
    $this->validate();

    if ($this->student_id) {
      $student = Student::find($this->student_id);
      $student->update([
        'fullname' => $this->student['fullname'],
        'gender' => $this->student['gender'] ?? '',
        'slug' => Str::slug($this->student['fullname']),
      ]);
      session()->flash('message', 'Student Updated Successfully');
    } else {
      $student = Student::create([
        'fullname' => $this->student['fullname'],
        'gender' => $this->student['gender'] ?? '',
        'school_id' => 'GS_' . mt_rand(500, 1000),
        'password' => Hash::make('password'),
        'slug' => Str::slug($this->student['fullname']),
      ]);
      session()->flash('message', 'Student Added Successfully');
    }

    if (!empty($this->student['current_class'])) {
      $student->classes()->sync($this->student['current_class']);
    }

    $this->emit('refresh');
    $this->cancel();
  }

  public function showInfo($id)
  {
    $student = Student::where('id', $id)->with('classes')->first();

    foreach ($student->classes()->get() as $studentClass) {
      $this->studentClassInfo = $studentClass->name;
    }

    $this->studentInfo = $student;
  }

  public function openDeleteModal($id)
  {
    $del = Student::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Student $student)
  {
    $student->classes()->detach($this->student_id);
    $student->delete();
    $this->emit('refresh');
    $this->cancel();
  }
}
