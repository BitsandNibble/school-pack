<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\ClassSubjectTeacher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Subjects extends Component
{
  public $i = 1;

  public function render(): Factory|View|Application
  {
    $sub = ClassSubjectTeacher::where('teacher_id', auth()->id())
      ->with('subject', 'class_room')
      ->get();

    return view('livewire.pages.teacher.subjects', compact('sub'));
  }
}
