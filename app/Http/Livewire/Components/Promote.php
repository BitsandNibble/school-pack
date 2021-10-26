<?php

namespace App\Http\Livewire\Components;

use App\Helpers\SP;
use App\Models\ClassRoom;
use App\Models\Promotion as PromotionModel;
use App\Models\Section;
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
  public $decision;
  public $students;
  public $class;
  public $section;

  protected $listeners = ['getValues'];

  public function render(): Factory|View|Application
  {
    if ($this->from_class) {
      $this->students = Student::where('class_room_id', $this->from_class)
        ->where('section_id', $this->from_section)
        ->get();

      $this->class = ClassRoom::get();
      $this->section = Section::get();

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

  public function promote(): void
  {
    $old_year = SP::getSetting('current_session');
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

    session()->flash('message', 'Student Record Updated Successfully');
  }
}
