<?php

namespace App\Http\Livewire\Components;

use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\NoticeBoard as NoticeBoardModel;
use Illuminate\Contracts\Foundation\Application;

class NoticeBoard extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithBulkActions;

    public $q;
    public $paginate = 10;
    public $title;
    public $message;
    public $notice_info;
    public $deleting;
    public $notice_id;

    protected string $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
    ];

    protected function rules(): array
    {
        return [
            'title'   => ['required', Rule::unique('notice_boards', 'title')->ignore($this->notice_id)],
            'message' => 'required',
        ];
    }

    public function getRowsQueryProperty()
    {
        return NoticeBoardModel::query()
            ->when($this->q, function ($query) {
                return $query->search($this->q);
            })
            ->where('author_id', auth('principal')->id())
            ->with('principal');
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->paginate);
    }

    public function render(): Factory|View|Application
    {
        if ($this->selectAll) $this->selectPageRows(); // for checkbox

        $notices = $this->rows;

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
        $notice          = NoticeBoardModel::query()->where('id', $id)->first();
        $this->notice_id = $notice['id'];
        $this->title     = $notice->title;
        $this->message   = $notice->message;
    }

    /**
     * @throws Exception
     */
    public function store(): void
    {
        $this->validate();

        if ($this->notice_id) {
            NoticeBoardModel::query()->find($this->notice_id)->update([
                'title'   => $this->title,
                'message' => $this->message,
            ]);
            $this->alert('success', 'Notice Updated Successfully');
        } else {
            NoticeBoardModel::query()->create([
                'title'     => $this->title,
                'message'   => $this->message,
                'author_id' => auth('principal')->id(),
            ]);
            $this->alert('success', 'Notice Added Successfully');
        }

        $this->cancel();
    }

    public function showInfo($id): void
    {
        $this->notice_info = NoticeBoardModel::query()->where('id', $id)
            ->with('principal')->get();
    }

    public function openDeleteModal($id): void
    {
        $del            = NoticeBoardModel::query()->find($id);
        $this->deleting = $del['id'];
    }

    public function delete(NoticeBoardModel $noticeboard): void
    {
        $noticeboard->delete();

        $this->cancel();
        $this->alert('success', 'Notice Deleted Successfully');
    }
}
