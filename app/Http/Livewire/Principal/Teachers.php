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

  public $teacher;
  protected $paginationTheme = 'bootstrap';

  protected $rules = [
    'teacher.firstname' => 'required|string',
    'teacher.lastname' => 'required|string',
    'teacher.title' => 'required',
  ];

  public function render()
  {
    $teachers = Teacher::with('classRooms')->Paginate(10);
    // $classes = StudentClass::where('teacher_id', NULL)->get();
    $classes = ClassRoom::get();

    return view('livewire.principal.teachers', compact('teachers', 'classes'));
  }

  public function close()
  {
    $this->reset(['teacher']);
    $this->emit('closeModal');
  }

  public function store()
  {
    $this->validate();

    $teach = Teacher::create([
      'firstname' => $this->teacher['firstname'],
      'middlename' => $this->teacher['middlename'] ?? '',
      'lastname' => $this->teacher['lastname'],
      'title' => $this->teacher['title'],
      'gender' => $this->teacher['gender'] ?? '',
      'staff_id' => 'GS_' . mt_rand(500, 1000),
      'password' => Hash::make('password'),
      'slug' => Str::slug($this->teacher['firstname'], '-'),
    ]);

    if (!empty($this->teacher['class_id'])) {
      $teach->classRooms()->sync($this->teacher['class_id']);
    }
    
    session()->flash('message', 'Teacher Added Successfully');
    $this->reset(['teacher']);
    $this->emit('closeModal');
  }

  public function delete(Teacher $teacher)
  {
    $teacher->delete();
  }
}
