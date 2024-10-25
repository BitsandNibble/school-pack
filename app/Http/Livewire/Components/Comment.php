<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\ExamRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Models\CommentsBank;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

class Comment extends Component
{
	use LivewireAlert;

	public $year;
	public $data;
	public $term;
	public $comment;
	public $student_id;
	public $user_comment;

	public function mount($id, $term, $year): void
	{
		$this->student_id = $id;
		$this->term       = $term;
		$this->year       = $year;

        $this->data       = [
            'student_id' => $this->student_id,
            // 'term_id'       => $this->term,
            'year'       => $this->year,
        ];
	}

	public function render(): Factory|View|Application
	{
		// check authenticated user, to ascertain the type of comment to render(Teacher or Principal)
		$get_comment = ExamRecord::query()->where($this->data)->first();

		$this->comment = auth('teacher')->user() ? $get_comment->teachers_comment : $get_comment->principals_comment;

		$comments = CommentsBank::query()->get();

		return view('livewire.components.comment', compact('comments'));
	}

	public function store(): void
	{
		$this->validate(['comment' => 'required|string']);

		// check authenticated user, to ascertain which column to store the comment
		$this->user_comment = auth('principal')->user() ? 'principals_comment' : 'teachers_comment';

		ExamRecord::query()->where($this->data)->update([
			$this->user_comment => $this->comment
		]);

		$this->alert('success', 'Comment Added Successfully');
	}
}
