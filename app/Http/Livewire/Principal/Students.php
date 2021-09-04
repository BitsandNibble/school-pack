<?php

namespace App\Http\Livewire\Principal;

use App\Models\ClassRoom;
use App\Models\Student;
use Livewire\Component;

class Students extends Component
{
  public function render()
  {
    $classes = ClassRoom::orderBy('name')->get();
    $students = Student::get(['firstname', 'lastname']);

    return view('livewire.principal.students', compact('classes', 'students'));
  }
}
