<?php

namespace App\Http\Livewire\Principal;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Teachers extends Component
{
  use WithPagination;

  public $teacher;
  protected $paginationTheme = 'bootstrap';
  
  protected $rules = [
    'teacher.firstname' => 'required|string',
    'teacher.lastname' => 'required|string',
    'teacher.title' => 'required',
  ];

  public function render()
  {
    $teachers = Teacher::Paginate(10);

    return view('livewire.principal.teachers', compact('teachers'));
  }

  public function saveTeacher()
  {
    $this->validate();

    Teacher::create([
      'firstname' => $this->teacher['firstname'],
      'middlename' => $this->teacher['middlename'] ?? '',
      'lastname' => $this->teacher['lastname'],
      'title' => $this->teacher['title'],
      'gender' => $this->teacher['gender'] ?? '',
      'class_teacher' => $this->teacher['class_teacher'] ?? '',
      'staff_id' => 'GS_' . mt_rand(500, 1000),
      'password' => Hash::make('password'),
      'slug' => Str::slug($this->teacher['firstname'], '-'),
    ]);

    session()->flash('message', 'Teacher Added Successfully');
    $this->reset(['teacher']);
    $this->emit('closeModal');
  }

  public function close()
  {
    $this->reset(['teacher']);
    $this->emit('closeModal');
  }
}
