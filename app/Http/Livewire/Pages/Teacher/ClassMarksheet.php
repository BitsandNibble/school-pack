<?php

namespace App\Http\Livewire\Pages\Teacher;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ClassMarksheet extends Component
{
  public $class_id;
  public $section_id;
  public $data;
  public $students;

  protected $listeners = ['getValues'];

  public function render(): Factory|View|Application
  {
    if ($this->class_id) {

//      get students along with the subjects they're registered with to show in table body
      $this->students = \App\Models\Student::where($this->data)
        ->get();
    }

    return view('livewire.pages.teacher.class-marksheet');
  }

  public function getValues($value): void
  {
    $this->class_id = $value['class_id'];
    $this->section_id = $value['section_id'];

//    use this for where clause to avoid duplicates
    $this->data = [
      'class_room_id' => $this->class_id,
      'section_id' => $this->section_id,
    ];
  }
}
