<?php

namespace App\Http\Livewire\Pages\Student;

use App\Models\Mark;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class SelectSession extends Component
{
    public $session;
    public $terms = [];
    public $term;

    public function render(): Factory|View|Application
    {
        $sessions = Mark::where(['student_id' => auth('student')->id()])->select('year')->distinct()->get();

        if ($this->session) {
            $this->terms = Mark::with('term')->get(); // use this to get the terms to view the scoresheet
        }

        return view('livewire.pages.student.select-session', compact('sessions'));
    }

    public function submit(): void
    {
        $this->validate(
            [
                'session' => 'required',
                'term' => 'required',
            ]
        );

        redirect()->route('result.marksheet.show', [auth('student')->id(), $this->session, $this->term]);
        $this->reset(); // clear input fields upon redirect
    }
}
