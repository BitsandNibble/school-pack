<?php

namespace App\Http\Livewire\Components;

use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Promote extends Component
{
  public $from_class;
  public $to_class;
  public $from_section;
  public $to_section;
  public $students;

  protected $listeners = ['getValues'];

  public function render(): Factory|View|Application
  {
    if ($this->from_class) {
      $this->students = Student::where('class_room_id', $this->from_class)
        ->where('section_id', $this->from_section)
        ->get();
    }
    return view('livewire.components.promote');
  }

  public function getValues($value): void
  {
    $this->from_class = $value['from_class'];
    $this->to_class = $value['to_class'];
    $this->from_section = $value['from_section'];
    $this->to_section = $value['to_section'];
  }
}
