<?php

namespace App\Http\Livewire\Pages\Teacher;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use App\Models\ClassSubjectTeacher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class Subjects extends Component
{
    public function render(): Factory|View|Application
    {
        $sub = ClassSubjectTeacher::where('teacher_id', auth()->id())
            ->with('subject', 'class_room')
            ->get();

        return view('livewire.pages.teacher.subjects', compact('sub'));
    }
}
