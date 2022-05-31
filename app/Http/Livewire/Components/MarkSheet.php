<?php

namespace App\Http\Livewire\Components;

use App\Models\Mark;
use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use App\Models\ClassRoom;
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
	public bool $selected = false;
	public $students;
	public $marks;

	protected array $rules = [
		'session'    => 'required',
		'class_id'   => 'required',
		'section_id' => 'required',
	];

	protected array $validationAttributes = [
		'class_id'   => 'class',
		'section_id' => 'section',
	];

	// get values from select box
	public function view(): void
	{
		$this->validate();
		$this->selected = true;
	}

	public function render(): Factory|View|Application
	{
		check_teacher_marksheet_access(); // check if teacher has access to view this page

		$sessions = Mark::query()->distinct()->select('year')->get();

		// show classes only when user has selected a term
		if (!empty($this->session)) {
			// get all classes where current logged in teacher has been
			// assigned to and when accessing from teacher's dashboard
			if (auth('teacher')->user()) {
				$this->classes = ClassRoom::query()->query()
					->whereHas('sections', function ($query) {
						$query->where('teacher_id', auth()->id());
					})->get();

				// show sections only when teacher has selected a class (teacher's dashboard)
				if ($this->class_id) {
					$this->sections = Section::query()->where('teacher_id', auth()->id())
						->where('class_room_id', $this->class_id)
						->get();
				}
			}

			// get all classes if accessing from principal's dashboard
			if (auth('principal')->user()) {
				$this->classes = ClassRoom::query()->get(['id', 'name']);

				// show sections per class (principal's dashboard)
				if ($this->class_id) {
					$this->sections = Section::query()->where('class_room_id', $this->class_id)->get();
				}
			}
		}

		if ($this->selected) {
			// fetch students results based on the selected class and the specific year

			$this->students = Student::query()
				->whereHas('mark', function ($query) {
					$query->where('year', $this->session)
						->where('class_room_id', $this->class_id);
				})
				->get(['id', 'fullname', 'school_id']); // get students
		}

		return view('livewire.components.mark-sheet', compact('sessions'));
	}
}
