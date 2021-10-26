<?php

namespace App\Http\Livewire\Components;

use App\Helpers\SP;
use App\Models\ClassRoom;
use App\Models\Section;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Collection;

class Promotion extends Component
{

  public $from_class;
  public $to_class;
  public $from_section;
  public $to_section;
  public $fs = [];
  public $ts = [];
//  public $section_id;

  protected array $rules = [
    'from_class' => 'required',
    'to_class' => 'required',
    'from_section' => 'required',
    'to_section' => 'required',
  ];

  public function render(): Factory|View|Application
  {
    // get all classes if accessing from principal's dashboard
    $classes = ClassRoom::orderBy('class_type_id', 'ASC')->get();

    // show sections per class
    if (!empty($this->from_class)) {
      $this->fs = Section::where('class_room_id', $this->from_class)
        ->with('class_room')
        ->get();
    }

    if (!empty($this->to_class)) {
      $this->ts = Section::where('class_room_id', $this->to_class)
        ->with('class_room')
        ->get();
    }


    $old_year = SP::getSetting('current_session');
    $old_yr = explode('-', $old_year);
    $new_year = ++$old_yr[0] . ' - ' . ++$old_yr[1];

    return view('livewire.components.promotion', compact('classes', 'old_year', 'new_year'));
  }

//  get values from select box
  public function view(): void
  {
    $value = $this->validate();
    $this->emit('getValues', $value);
  }
}
