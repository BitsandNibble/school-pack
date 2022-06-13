<?php

namespace App\Http\Livewire\Pages\Principal\Settings;

use App\Models\CommentsBank;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use Jantinnerezo\LivewireAlert\LivewireAlert;

/**
 * @property mixed rows
 * @property mixed rowsQuery
 */
class Comments extends Component
{
	use LivewireAlert;
	use WithPagination;
	use WithBulkActions;

	public $q;
	public $i = 1;
	public $deleting;
	public $comment_id;
	public $descriptions = [0];
	public $paginate = 15;

	protected string $paginationTheme = 'bootstrap';

	protected array $rules = [
		'descriptions.*.description' => 'required|string|unique:comments_banks',
	];

	protected array $validationAttributes = [
		'descriptions.*.description' => 'comment',
	];

	public function getRowsQueryProperty()
	{
		return CommentsBank::query()
			->when($this->q, function ($query) {
				return $query->search($this->q);
			});
	}

	public function getRowsProperty()
	{
		return $this->rowsQuery->Paginate($this->paginate);
	}

	public function render()
	{
		if ($this->selectAll) $this->selectPageRows(); // for checkbox

		$comments = $this->rows;

		return view('livewire.pages.principal.settings.comments', compact('comments'));
	}

	public function cancel(): void
	{
		$this->emit('closeModal');
		$this->reset();
		$this->resetErrorBag();
	}

	public function edit($id): void
	{
		$comment = CommentsBank::where('id', $id)->get();
		$this->comment_id = $comment->first()->id;

		$this->descriptions = [];
		foreach ($comment as $key => $value) {
			$this->descriptions[$key]['description'] = $value->description;
		}
	}

	public function store(): void
	{
		$this->validate();

		foreach ($this->descriptions as $value) {
			if ($this->comment_id) {
				$comment = CommentsBank::find($this->comment_id);
				$comment->update([
					'description' => $value['description'],
				]);
				$this->alert('success', 'Comment Updated Successfully');
			} else {
				CommentsBank::create([
					'description' => $value['description'],
				]);
				$this->alert('success', 'Comment Updated Successfully');
			}

			$this->descriptions = [];
		}

		$this->cancel();
	}

	public function openDeleteModal($id): void
	{
		$del = CommentsBank::find($id);
		$this->deleting = $del['id'];
	}

	public function delete(CommentsBank $commentsBank): void
	{
		$commentsBank->delete();

		$this->cancel();
		$this->alert('success', 'Comment Deleted Successfully');
	}

	// Caleb Porzio used a macro to export csv
	//  public function exportSelected()
	//  {
	//    return response()->streamDownload(function () {
	//      echo $this->selectedRowsQuery->toCsv();
	//    }, 'comments.csv');
	//  }

	// for dynamic input
	public function addInput(): void
	{
		$this->descriptions[] = $this->i++;
	}

	public function removeInput($index): void
	{
		unset($this->descriptions[$index]);
	}
}
