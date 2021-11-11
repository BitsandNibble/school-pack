<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Exam;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GradeSettings extends Component
{
  public $settings;

  protected array $rules = [
    'settings.ca1' => 'required|numeric',
    'settings.ca2' => 'required|numeric',
    'settings.exam' => 'required|numeric',
  ];

  protected array $validationAttributes = [
    'settings.ca1' => 'first CA',
    'settings.ca2' => 'second CA',
    'settings.exam' => 'exam score',
  ];

  public function render(): Factory|View|Application
  {
    $sets = Setting::get();
    $s['set'] = $sets->flatMap(function ($sets) {
      return [$sets->type => $sets->description];
    });
    $this->settings = $s['set'];

    $s['exams'] = Exam::get();

    return view('livewire.pages.principal.grade-settings', $s);
  }

  public function store(): void
  {
    $credentials = $this->validate();
    foreach ($credentials as $cred) {
    }

    $keys = array_keys($cred);
    $values = array_values($cred);
    $iMax = count($cred);

    for ($i = 0; $i < $iMax; $i++) {
      Setting::where('type', $keys[$i])->update(['description' => $values[$i]]);
    }

    session()->flash('message', 'Grade Settings Updated Successfully');
  }

  public function unlock(Exam $exam): void
  {
    if (isset($exam->locked)) {
      if ($exam->locked === 0) {
        $exam->locked = 1;
        $exam->update();
        session()->flash('message', 'Exam Locked Successfully');
      } else {
        $exam->locked = 0;
        $exam->update();
        session()->flash('message', 'Exam Unlocked Successfully');
      }
    }
  }
}
