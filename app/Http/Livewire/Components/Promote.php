<?php

namespace App\Http\Livewire\Components;

use App\Models\ClassRoom;
use App\Models\Promotion as PromotionModel;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Promote extends Component
{
  use LivewireAlert;

  public $from_class;
  public $to_class;
  public $from_section;
  public $to_section;
  public bool $selected = false;
  public $decision;
  public $students;
  public $class;
  public $section;
  public $fs = [];
  public $ts = [];

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
    if ($this->from_class) {
      $this->fs = Section::where('class_room_id', $this->from_class)
        ->with('class_room')
        ->get();
    }

    if ($this->to_class) {
      $this->ts = Section::where('class_room_id', $this->to_class)
        ->with('class_room')
        ->get();
    }

    $old_year = get_setting('current_session');
    $old_yr = explode('-', $old_year);
    $new_year = ++$old_yr[0] . ' - ' . ++$old_yr[1];


    if ($this->selected) {
      $this->students = Student::where('class_room_id', $this->from_class)
        ->where('section_id', $this->from_section)
        ->get();

      $this->class = ClassRoom::get();
      $this->section = Section::get();

    }

    return view('livewire.components.promote', compact('classes', 'old_year', 'new_year'));
  }

//  get values from select box
  public function view(): void
  {
    $this->validate();
    $this->selected = true;
  }

  public function promote(): void
  {
    $this->validate(['decision' => 'required']);

    $old_year = get_setting('current_session');
    $old_yr = explode('-', $old_year);
    $new_year = ++$old_yr[0] . ' - ' . ++$old_yr[1];
    $d = [];
    $promote = [];

    $students = Student::where('class_room_id', $this->from_class)
      ->where('section_id', $this->from_section)
      ->get();

    if ($students->count() < 1) {
      abort(404, 'No Student to Promote');
    }

    foreach ($students as $st) {
      $p = $this->decision;

      if ($p === 'P') {
        $d['class_room_id'] = $this->to_class;
        $d['section_id'] = $this->to_section;
      }

      if ($p === 'D') {
        $d['class_room_id'] = $this->from_class;
        $d['section_id'] = $this->from_section;
      }

      if ($p === 'G') {
        $d['class_room_id'] = $this->to_class;
        $d['section_id'] = $this->to_section;
        $d['graduated'] = 1;
        $d['graduation_date'] = $old_year;
      }

      Student::find($st->id)->update($d);

//      Insert New Promotion Data
      $promote['from_class'] = $this->from_class;
      $promote['from_section'] = $this->from_section;
      $promote['grad'] = ($p === 'G') ? 1 : 0;
      $promote['to_class'] = in_array($p, ['D', 'G']) ? $this->from_class : $this->to_class;
      $promote['to_section'] = in_array($p, ['D', 'G']) ? $this->from_section : $this->to_section;
      $promote['student_id'] = $st->id;
      $promote['from_session'] = $old_year;
      $promote['to_session'] = $new_year;
      $promote['status'] = $p;

      PromotionModel::create($promote);
    }

    $this->alert('success', 'Student Record Updated Successfully');
  }
}
