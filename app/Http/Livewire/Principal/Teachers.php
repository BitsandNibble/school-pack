<?php

namespace App\Http\Livewire\Principal;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class Teachers extends Component
{
  public $teacher, $teachers;

  protected $rules = [
    'teacher.firstname' => 'required|string',
    'teacher.middlename' => 'string',
    'teacher.lastname' => 'required|string',
    'teacher.title' => 'required',
  ];

  public function render()
  {
    $this->teachers = Teacher::get();

    return view('livewire.principal.teachers');
  }

  public function saveTeacher()
  {
    $this->validate();

    Teacher::create([
      'firstname' => $this->teacher['firstname'],
      'middlename' => $this->teacher['middlename'],
      'lastname' => $this->teacher['lastname'],
      'title' => $this->teacher['title'],
      'gender' => $this->teacher['gender'],
      'class_teacher' => $this->teacher['class_teacher'],
      'staff_id' => 'GS_' . mt_rand(500, 1000),
      'password' => Hash::make('password'),
      'slug' => Str::slug([$this->teacher['firstname'], $this->teacher['middlename'], $this->teacher['lastname']], '-'),
    ]);

    session()->flash('message', 'Teacher Added Successfully');

    $this->emit('stored');
  }
}
