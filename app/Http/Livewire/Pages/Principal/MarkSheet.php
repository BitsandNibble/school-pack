<?php

namespace App\Http\Livewire\Pages\Principal;

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
    // get all classes
    $classes = Section::with('class_room')
      ->distinct()
      ->select('class_room_id')
      ->get();

    // show sections per class
    if (!empty($this->class_id)) {
      $this->sections = Section::where('class_room_id', $this->class_id)
        ->with('class_room')
        ->get();
    }

    return view('livewire.pages.principal.mark-sheet', compact('classes'));
  }

//  get values from select box
  public function view(): void
  {
    $value = $this->validate();
    $this->emit('getValues', $value);
  }
}

