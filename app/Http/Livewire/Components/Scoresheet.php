<?php

namespace App\Http\Livewire\Components;

use App\Models\Mark;
use App\Models\Term;
use App\Models\Subject;
use Livewire\Component;
use App\Models\ClassRoom;
use App\Models\ClassType;
use App\Models\ExamRecord;
use App\Models\Section;
use App\Services\ScoreService;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\DB;

class Scoresheet extends Component
{
	use LivewireAlert;

	public $subject;
	public $class;
	public $section;
	public $term;
	public $term_id;
	public $class_id;
	public $section_id;
	public $subject_id;
	public $marks          = [];
	public bool $get_marks = false;
	public $data;
	public $ca1_limit;
	public $ca2_limit;
	public $exam_limit;
	public bool $showEdit = false;
	public $selected_year;

	protected $listeners = ['getValues'];

	protected array $rules;

	protected function rules()
	{
		return [
			'marks.*.ca1'        => 'sometimes|numeric|nullable|max:' . $this->ca1_limit,
			'marks.*.ca2'        => 'sometimes|numeric|nullable|max:' . $this->ca2_limit,
			'marks.*.exam_score' => 'sometimes|nullable|numeric|max:' . $this->exam_limit,
		];
	}

	protected array $validationAttributes = [
		'marks.*.ca1'        => 'first CA score',
		'marks.*.ca2'        => 'second CA score',
		'marks.*.exam_score' => 'exam score',
	];

	public function render(): Factory|View|Application
	{
		$this->ca1_limit  = get_setting('ca1');
		$this->ca2_limit  = get_setting('ca2');
		$this->exam_limit = get_setting('exam');

		// show students based on selected class and subject from grading
		if ($this->class_id) {
			$this->get_marks = true;

			$this->marks = Mark::query()->where($this->data)
				->with('student:id,fullname,school_id')
				->get();
		}

		return view('livewire.components.scoresheet');
	}

	public function getValues($value): void
	{
		$this->class_id   = $value['class_id'];
		$this->section_id = $value['section_id'];
		$this->subject_id = $value['subject_id'];
		$this->term_id    = $value['term_id'];

		// get items
		$this->subject       = Subject::query()->find($value['subject_id'])->name;
		$this->class         = ClassRoom::query()->find($value['class_id'])->name;
		$this->section       = Section::query()->find($value['section_id'])->name;
		$this->term          = Term::query()->find($value['term_id']);
		$this->selected_year = $this->term->session;

		// use this data for where clauses to avoid duplicates
		$this->data = [
			'term_id'       => $this->term_id,
			'class_room_id' => $this->class_id,
			'section_id'    => $this->section_id,
			'subject_id'    => $this->subject_id,
			'year'          => $this->selected_year
		];
	}

	public function store(ScoreService $scoreService): void
	{
		$credentials = $this->validate();

		$scoreService->updateScores($this->data, $credentials['marks']);

		$this->alert('success', 'Scores Recorded Successfully');
	}
}
