<?php

namespace App\Http\Livewire\Components;

use App\Models\Section;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MarkSheet extends Component
{
  public $class_id;
  public $sections = [];
  public $section_id;

  protected array $rules = [
    'class_id' => 'required',
    'section_id' => 'required',
  ];

  protected array $validationAttributes = [
    'class_id' => 'class',
    'section_id' => 'section',
  ];

  public function render(): Factory|View|Application
  {
    // get all classes where current logged in teacher has been
    // assigned to and when accessing from teacher's dashboard
    if (auth('teacher')->user()) {
      $classes = Section::where('teacher_id', auth()->id())
        ->with('class_room')
        ->distinct()
        ->select('class_room_id')
        ->get();

      // show sections only when teacher has selected a class (teacher's dashboard)
      if (!empty($this->class_id)) {
        $this->sections = Section::where('teacher_id', auth()->id())
          ->where('class_room_id', $this->class_id)
          ->with('class_room')
          ->get();
      }
    }

    // get all classes if accessing from principal's dashboard
    if (auth('principal')->user()) {
      $classes = Section::with('class_room')
        ->distinct()
        ->select('class_room_id')
        ->get();

      // show sections per class (principal's dashboard)
      if (!empty($this->class_id)) {
        $this->sections = Section::where('class_room_id', $this->class_id)
          ->with('class_room')
          ->get();
      }
    }

    return view('livewire.components.mark-sheet', compact('classes'));
  }

//  get values from select box
  public function view(): void
  {
    $value = $this->validate();
    $this->emit('getValues', $value);
  }
}

