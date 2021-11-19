<?php

namespace App\Http\Livewire\Pages\Student;

use App\Models\Mark;
use Livewire\Component;

class SelectYear extends Component
{
  public $year;

  public function render()
  {
    $years = Mark::where(['student_id' => auth('student')->id()])->select('year')->distinct()->get();

    return view('livewire.pages.student.select-year', compact('years'));
  }

  public function submit()
  {
    $this->validate(
      [
        'year' => 'required',
      ]
    );

    redirect()->route('result.marksheet.show', [auth('student')->id(), $this->year]);
  }
}
