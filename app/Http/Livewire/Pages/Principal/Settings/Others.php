<?php

namespace App\Http\Livewire\Pages\Principal\Settings;

use App\Models\Term;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

class Others extends Component
{
    use LivewireAlert;

    public function render(): Factory|View|Application
    {
        $s['terms'] = Term::get();

        return view('livewire.pages.principal.settings.others', $s);
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
