<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Exam;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class OtherSettings extends Component
{
  use LivewireAlert;

  public function render(): Factory|View|Application
  {
    $s['exams'] = Exam::get();

    return view('livewire.pages.principal.other-settings', $s);
  }

  public function unlock(Exam $exam): void
  {
    if (isset($exam->locked)) {
      if ($exam->locked === 0) {
        $exam->locked = 1;
        $exam->update();
        $this->alert('success', 'Exam Locked Successfully');
      } else {
        $exam->locked = 0;
        $exam->update();
        $this->alert('success', 'Exam Unlocked Successfully');
      }
    }
  }
}
