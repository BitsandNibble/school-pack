<?php

namespace App\Http\Controllers;

use App\Helpers\SP;
use App\Models\ClassRoom;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PromotionController extends Controller
{
  public function promotion($fc = NULL, $fs = NULL, $tc = NULL, $ts = NULL): View|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
  {
    $d['old_year'] = $old_yr = SP::getSetting('current_session');
    $old_yr = explode('-', $old_yr);
    $d['new_year'] = ++$old_yr[0] . '-' . ++$old_yr[1];
    $d['class_rooms'] = ClassRoom::orderBy('name', 'asc')->with('class_type')->get();
    $d['sections'] = Section::orderBy('name', 'asc')->with('class_room', 'teacher')->get();
    $d['selected'] = false;

    if ($fc && $fs && $tc && $ts) {
      $d['selected'] = true;
      $d['fc'] = $fc;
      $d['fs'] = $fs;
      $d['tc'] = $tc;
      $d['ts'] = $ts;
      $d['students'] = $sts = Student::where('class_room_id', $fc)->where('section_id', $fs)
        ->where('session', $d['old_year'])->get();

      if ($sts->count() < 1) {
        session()->flash('message', 'There are NO Students To Promote');
        return redirect()->route('principal.students.promotion');
      }
    }

    return view('users.student.promotion.index', $d);
  }
}
