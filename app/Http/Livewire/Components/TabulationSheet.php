<?php

namespace App\Http\Livewire\Components;

use App\Models\Mark;
use App\Models\Term;
use Livewire\Component;
use App\Models\ClassRoom;
use App\Models\ExamRecord;
use Illuminate\Contracts\View\View;
use App\Models\ClassSubjectTeacher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class TabulationSheet extends Component
{
    public $term_id;
    public $class_id;
    public $subject_id;
    public $classes = [];
    // public $subjects = [];
    public $data;
    public $marks;
    public $subjects;
    public $students;
    public $exam_record;
    public $class_name;
    public $term_name;
    public $selected_year;

    protected array $rules = [
        'term_id' => 'required',
        'class_id' => 'required',
        // 'subject_id' => 'required',
    ];

    protected array $validationAttributes = [
        'term_id' => 'term',
        'class_id' => 'class',
        // 'subject_id' => 'subject',
    ];

    public function render(): Factory|View|Application
    {
        check_teacher_tabulation_sheet_access(); // check if teacher has access to view this page

        $terms = Term::get(); // get all terms

        // show classes only when user has selected a term
        if (!empty($this->term_id)) {
            if (auth('teacher')->user()) {
                $this->classes = ClassSubjectTeacher::where('teacher_id', auth()->id())
                    ->with('classroom')
                    ->select('class_room_id')
                    ->distinct()
                    ->get();
            }

            if (auth('principal')->user()) {
                $this->classes = ClassRoom::get();
            }

            $this->selected_year = Term::where('id', $this->term_id)->first()['session']; // get selected year
        }

        if ($this->class_id) {
            // get distinct subjects per class and show in table head
            $this->subjects = Mark::where($this->data)
                ->select('subject_id')
                ->distinct()
                ->with('subject')
                ->get(['subject_id']);

            // get students along with the subjects they're registered with to show in table body
            $this->students = Mark::where($this->data)
                ->select('student_id')
                ->distinct()
                ->with('student')
                ->get(['student_id']);

            $this->marks = Mark::where($this->data)
                ->get(['student_id', 'subject_id', 'total_score']);

            $this->exam_record = ExamRecord::where($this->data)
                ->get(['student_id', 'total', 'average', 'position']);
        }

        return view('livewire.components.tabulation-sheet', compact('terms'));
    }

    // get values from select box
    public function view(): void
    {
        $this->validate();

        // use this for where clause to avoid duplicates
        $this->data = [
            'term_id' => $this->term_id,
            'class_room_id' => $this->class_id,
            'year' => $this->selected_year,
        ];

        $this->selected_year = Term::where('id', $this->term_id)->first()->session;
        $this->class_name = ClassRoom::where('id', $this->class_id)->first()->name;
        $this->term_name = Term::where('id', $this->term_id)->first()->name;
    }
}
