<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\ExamRecord;
use App\Models\TeachersComments;
use App\Models\PrincipalsComments;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

class Comment extends Component
{
	use LivewireAlert;

	public $teachers_comment;
	public $default_teachers_comment;
	public $principals_comment;
	public $default_principals_comment;
	public $student_id;
	public $user_comment;

	public function mount($id): void
	{
		$this->student_id = $id;
	}

	public function render(): Factory|View|Application
	{
		// check authenticated user, to ascertain the type of comment to render(Teacher or Principal)

		if (auth('teacher')->user()) {
			$this->teachers_comment = ExamRecord::query()->where(['student_id' => $this->student_id])
				->first()
				->teachers_comment;

			$this->default_teachers_comment = TeachersComments::query()->get();
		}

		if (auth('principal')->user()) {
			$this->principals_comment = ExamRecord::query()->where(['student_id' => $this->student_id])
				->first()
				->principals_comment;

			$this->default_principals_comment = PrincipalsComments::query()->get();
		}

		return view('livewire.components.comment');
	}

	public function store(): void
	{
		// check authenticated user, to ascertain which column to store the comment

		if (auth('teacher')->user()) {
			$this->validate([
				'teachers_comment' => 'required|string',
			]);

			$this->user_comment = 'teachers_comment';
		}

		if (auth('principal')->user()) {
			$this->validate([
				'principals_comment' => 'required|string',
			]);

			$this->user_comment = 'principals_comment';
		}

		ExamRecord::query()->where(['student_id' => $this->student_id])->update([
			$this->user_comment => ($this->user_comment === 'teachers_comment' ? $this->teachers_comment : $this->principals_comment),
		]);

		$this->alert('success', 'Comment Added Successfully');
	}
}