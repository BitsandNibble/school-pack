<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\ClassSubjectTeacher;
use Livewire\Component;

class Subjects extends Component
{
  public $i = 1;

  public function render()
  {
    $sub = ClassSubjectTeacher::where('teacher_id', auth()->id())
      ->with('subject', 'class_room')
      ->get();

    return view('livewire.pages.teacher.subjects', compact('sub'));
  }
}
