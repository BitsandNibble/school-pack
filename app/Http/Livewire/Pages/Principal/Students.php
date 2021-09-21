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
      'section' => 'required_if:class,required',
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

  public function cancel()
  {
    $this->emit('closeModal');
    $this->reset(['student', 'student_id', 'studentInfo', 'studentClassInfo']);
  }

  public function edit($id)
  {
    $student = Student::where('id', $id)->first();
    $this->student_id = $student['id'];
    $this->student = $student;
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

    if (!empty($this->class)) {
      $student->sections()->sync($this->class);
    }

    $this->emit('refresh');
    $this->cancel();
  }

  public function showInfo($id): void
  {
    $student = Student::findOrFail($id);
    $section_id = $student->sections;

    foreach ($section_id as $s_id) {
      $current_class = $s_id->class_room->name . ' ' . $s_id->name;
    }

    $this->current_class = $current_class ?? '';
    $this->studentInfo = $student;
  }

  public function openDeleteModal($id): void
  {
    $del = Student::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Student $student): void
  {
    $student->classes()->detach($this->student_id);
    $student->delete();
    $this->emit('refresh');
    $this->cancel();
  }
}
