<?php

namespace App\Http\Livewire\Components;

use App\Models\Mark;
use App\Models\Term;
use Livewire\Component;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\ExamRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class Scores extends Component
{
	public $term_id;
	public $class_id;
	public $section_id;
	public $subject_id;
	public $classes = [];
	public $sections = [];
	public $subjects = [];

	protected $listeners = ['create_marks'];

	protected array $rules = [
		'term_id' => 'required',
		'class_id' => 'required',
		'section_id' => 'required',
		'subject_id' => 'required',
	];

	protected array $validationAttributes = [
		'term_id' => 'term',
		'class_id' => 'class',
		'section_id' => 'section',
		'subject_id' => 'subject',
	];

	public function render(): Factory|View|Application
	{

		// get terms for current session
		$terms = Term::query()->get();

		if (auth('teacher')->user()) {

			// show classes only when user has selected an term
			if (!empty($this->term_id)) {
				$this->classes = ClassRoom::query()->whereHas('subject_teachers', function ($query) {
					$query->where('teacher_id', auth()->id());
				})->get();
			}

			// show section for the selected class
			if (!empty($this->class_id)) {
				$this->sections = Section::query()->where('class_room_id', $this->class_id)
					->get();
			}

			// show subjects specific to the selcected class
			if (!empty($this->section_id)) {
				$this->subjects = Subject::query()->whereHas('class_subjects', function ($query) {
					$query->where('class_room_id', $this->class_id);
				})->get();
			}
		}

		if (auth('principal')->user()) {

			// show classes only when user has selected a term
			if (!empty($this->term_id)) {
				$this->classes = ClassRoom::query()->get();
			}

			// show section for the selected class
			if (!empty($this->class_id)) {
				$this->sections = Section::query()->where('class_room_id', $this->class_id)
					->get();
			}

			// show subjects specific to the selcected class
			if (!empty($this->section_id)) {
				$this->subjects = Subject::query()->whereHas('class_subjects', function ($query) {
					$query->where('class_room_id', $this->class_id);
				})->get();
			}
		}

		return view('livewire.components.scores', compact('terms'));
	}

	// get values from select box
	public function manage(): void
	{
		$value = $this->validate();

		// add records to marks & exam_records table
		$students = Student::query()->whereHas('class_subjects', function ($query) {
			$query->where([
				'subject_id' => $this->subject_id,
				'class_room_id' => $this->class_id
			]);
		})->get(['id']);

		$year = Term::query()->find($this->term_id)->session;

		foreach ($students as $student) {
			Mark::query()->firstOrCreate([
				'student_id' => $student->id,
				'subject_id' => $this->subject_id,
				'class_room_id' => $this->class_id,
				'section_id' => $this->section_id,
				'term_id' => $this->term_id,
				'year' => $year,
			]);

			ExamRecord::query()->firstOrCreate([
				'student_id' => $student->id,
				'class_room_id' => $this->class_id,
				'section_id' => $this->section_id,
				'term_id' => $this->term_id,
				'year' => $year,
			]);
		}

		// add records to mark table
		$this->emit('getValues', $value);
	}
}
