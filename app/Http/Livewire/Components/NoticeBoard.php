<?php

namespace App\Http\Livewire\Components;

use App\Models\NoticeBoard as NoticeBoardModel;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class NoticeBoard extends Component
{
  use WithPagination;

  public $q;
  public $paginate = 10;
  public $message;
  public $notice_info;
  public $deleting;
  public $notice_id;

  protected string $paginationTheme = 'bootstrap';

  protected $queryString = [
    'q' => ['except' => ''],
  ];

  protected array $rules = [
    'message' => 'required',
  ];

  public function render(): Factory|View|Application
  {
    $notices = NoticeBoardModel::when($this->q, function ($query) {
      return $query->search($this->q);
    })->where('author_id', auth('principal')->id())
      ->with('principal')
      ->Paginate($this->paginate);

    return view('livewire.components.notice-board', compact('notices'));
  }

  public function updatingQ(): void
  {
    $this->resetPage();
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $notice = NoticeBoardModel::where('id', $id)->first();
    $this->notice_id = $notice['id'];
    $this->message = $notice->message;
  }

  /**
   * @throws Exception
   */
  public function store(): void
  {
    $this->validate();

    if ($this->notice_id) {
      NoticeBoardModel::find($this->notice_id)->update([
        'message' => $this->message,
      ]);
      session()->flash('message', 'Notice Board Updated Successfully');
    } else {
      NoticeBoardModel::create([
        'message' => $this->message,
        'author_id' => auth('principal')->id(),
      ]);
      session()->flash('message', 'Notice Board Added Successfully');
    }

    $this->cancel();
  }

  public function showInfo($id): void
  {
    $this->notice_info = NoticeBoardModel::where('id', $id)
      ->with('principal')->get();
  }

  public function openDeleteModal($id): void
  {
    $del = NoticeBoardModel::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(NoticeBoardModel $noticeboard): void
  {
    $noticeboard->delete();
    $this->cancel();
  }
}
