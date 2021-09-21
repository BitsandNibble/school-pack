<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Students extends Component
{
  public $student, $studentInfo, $studentClassInfo, $deleting;
  public $student_id, $current_class;
  public $class, $sections = [], $section;

  protected $listeners = ['edit', 'showInfo', 'openDeleteModal'];

  protected $rules;

  protected function rules()
  {
    return [
      'student.fullname' => ['required', 'string', Rule::unique('students', 'fullname')->ignore($this->student_id)],
      'class' => 'required',
      'section' => 'required',
      'student.gender' => 'sometimes',
    ];
  }

  protected $validationAttributes = [
    'student.fullname' => 'fullname',
    'student.gender' => 'gender',
  ];

  public function render()
  {
    if (!empty($this->class)) {
      $this->sections = Section::where('class_room_id', $this->class)->get();
    }
    $classes = ClassRoom::orderBy('name')->get();

    return view('livewire.pages.principal.students', compact('classes'));
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $student = Student::find($id);
    $this->student_id = $student['id'];
    $this->student = $student;
  }

  public function store(): void
  {
    $this->validate();

    if ($this->student_id) {
      $student = Student::find($this->student_id);
      $student->update([
        'fullname' => $this->student['fullname'],
        'class_room_id' => $this->class ?? '',
        'section_id' => $this->section ?? '',
        'gender' => $this->student['gender'] ?? '',
        'slug' => Str::slug($this->student['fullname']),
      ]);
      session()->flash('message', 'Student Updated Successfully');
    } else {
      Student::create([
        'fullname' => $this->student['fullname'],
        'class_room_id' => $this->class,
        'section_id' => $this->section,
        'gender' => $this->student['gender'] ?? '',
        'school_id' => 'GS_' . mt_rand(500, 1000),
        'password' => Hash::make('password'),
        'slug' => Str::slug($this->student['fullname']),
      ]);
      session()->flash('message', 'Student Added Successfully');
    }

    $this->emit('refresh');
    $this->cancel();
  }

  public function showInfo($id): void
  {
    $student = Student::findOrFail($id);
    $this->studentInfo = $student;
    $this->current_class = $student->class_room->name . ' ' . $student->section->name ?? '';
  }

  public function openDeleteModal($id): void
  {
    $del = Student::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Student $student): void
  {
    $student->delete();
    $this->emit('refresh');
    $this->cancel();
  }
}
