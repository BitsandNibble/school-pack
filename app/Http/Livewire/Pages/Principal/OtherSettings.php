<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Term;
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
    $s['terms'] = Term::get();

    return view('livewire.pages.principal.other-settings', $s);
  }

  public function unlock(Term $term): void
  {
    if (isset($term->locked)) {
      if ($term->locked === 0) {
        $term->locked = 1;
        $term->update();
        $this->alert('success', 'Term Locked Successfully');
      } else {
        $term->locked = 0;
        $term->update();
        $this->alert('success', 'Term Unlocked Successfully');
      }
    }
  }
}
