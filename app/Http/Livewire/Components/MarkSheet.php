<?php

namespace App\Http\Livewire\Components;

use App\Models\Mark;
use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class MarkSheet extends Component
{
    public $session;
    public $classes = [];
    public $class_id;
    public $sections = [];
    public $section_id;
    public $data;
    public bool $selected = false;
    public $students;
    public $marks;

    protected array $rules = [
        'session' => 'required',
        'class_id' => 'required',
        'section_id' => 'required',
    ];

    protected array $validationAttributes = [
        'class_id' => 'class',
        'section_id' => 'section',
    ];

    public function render(): Factory|View|Application
    {
        check_teacher_marksheet_access(); // check if teacher has access to view this page

        $sessions = Mark::distinct()->select('year')->get();

        // show classes only when user has selected a term
        if (!empty($this->session)) {
            // get all classes where current logged in teacher has been
            // assigned to and when accessing from teacher's dashboard
            if (auth('teacher')->user()) {
                $this->classes = Section::where('teacher_id', auth()->id())
                    ->with('class_room')
                    ->distinct()
                    ->select('class_room_id')
                    ->get();

                // show sections only when teacher has selected a class (teacher's dashboard)
                if ($this->class_id) {
                    $this->sections = Section::where('teacher_id', auth()->id())
                        ->where('class_room_id', $this->class_id)
                        ->with('class_room')
                        ->get();
                }
            }

            // get all classes if accessing from principal's dashboard
            if (auth('principal')->user()) {
                $this->classes = Section::with('class_room')
                    ->distinct()
                    ->select('class_room_id')
                    ->get();

                // show sections per class (principal's dashboard)
                if ($this->class_id) {
                    $this->sections = Section::where('class_room_id', $this->class_id)
                        ->with('class_room')
                        ->get();
                }
            }
        }

        if ($this->class_id) {
            $this->students = Student::where($this->data)->get(); // get students
            $this->marks = Mark::with('term')->get(); // use this to get the terms to view the scoresheet
        }

        return view('livewire.components.mark-sheet', compact('sessions'));
    }

    // get values from select box
    public function view(): void
    {
        $this->validate();
        $this->selected = true;

        // use this for where clause to avoid duplicates
        $this->data = [
            'class_room_id' => $this->class_id,
            'section_id' => $this->section_id,
        ];
    }
}

