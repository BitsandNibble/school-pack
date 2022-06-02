<?php

namespace App\Http\Livewire\Components;

use App\Models\Mark;
use App\Models\Term;
use Livewire\Component;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ClassRoom;
use App\Models\ExamRecord;
use Illuminate\Contracts\View\View;
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
	public $selected_term;
	public $selected_year;

	protected array $rules = [
		'term_id'  => 'required',
		'class_id' => 'required',
		// 'subject_id' => 'required',
	];

	protected array $validationAttributes = [
		'term_id'  => 'term',
		'class_id' => 'class',
		// 'subject_id' => 'subject',
	];

	public function render(): Factory|View|Application
	{
		// check if teacher has access to view this page
		check_teacher_tabulation_sheet_access();

		$terms = Term::query()->get();

		// show classes only when user has selected a term
		if (!empty($this->term_id)) {
			if (auth('teacher')->user()) {
				$this->classes = ClassRoom::query()
					->whereHas('sections', function ($query) {
						$query->where('teacher_id', auth()->id());
					})->get();
			}

			if (auth('principal')->user()) $this->classes = ClassRoom::query()->get();

			$this->selected_term = Term::query()->find($this->term_id);

			// get selected year
			$this->selected_year = $this->selected_term->session;
		}

		if ($this->class_id) {
			// fetch all subjects of selected class and show in table head
			$this->subjects = Subject::query()
				->whereHas('marks', function ($query) {
					$query->where($this->data);
				})->get();

			// get students along with registered subjects to show in table body
			$this->students = Student::query()
				->whereHas('marks', function ($query) {
					$query->where($this->data);
				})
				->get(['id', 'fullname']);

			$this->marks = Mark::query()->where($this->data)
				->get(['student_id', 'subject_id', 'total_score']);

			$this->exam_record = ExamRecord::query()->where($this->data)
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
			'term_id'       => $this->term_id,
			'class_room_id' => $this->class_id,
			'year'          => $this->selected_year,
		];

		$this->class_name = ClassRoom::query()->find($this->class_id)->name;
		$this->term_name  = $this->selected_term->name;
	}
}
