<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Subject;
use Livewire\Component;
use App\Models\ClassRoom;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @property mixed rows
 * @property mixed rowsQuery
 */
class Subjects extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithBulkActions;

    public $q;
    public $i = 1;
    public $deleting;
    public $subject_id;
    public $names = [0];
    public $paginate = 15;

    protected string $paginationTheme = 'bootstrap';

    protected array $rules = [
        'names.*.name' => 'required|string',
    ];

    protected array $validationAttributes = [
        'names.*.name' => 'subject',
    ];

    public function getRowsQueryProperty()
    {
        return Subject::query()
            ->when($this->q, function ($query) {
                return $query->search($this->q);
            });
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->Paginate($this->paginate);
    }

    public function render(): Factory|View|Application
    {
        if ($this->selectAll) $this->selectPageRows(); // for checkbox

        $classes = ClassRoom::orderBy('name', 'ASC')->get();
        $subjects = $this->rows;

        return view('livewire.pages.principal.subjects', compact('classes', 'subjects'));
    }

    public function cancel(): void
    {
        $this->emit('closeModal');
        $this->reset();
    }

    public function edit($id): void
    {
        $subject = Subject::where('id', $id)->get();
        $this->subject_id = $subject->first()->id;

        $this->names = [];
        foreach ($subject as $key => $value) {
            $this->names[$key]['name'] = $value->name;
        }
    }

    public function store(): void
    {
        $this->validate();

        foreach ($this->names as $key => $value) {
            if ($this->subject_id) {
                $subject = Subject::find($this->subject_id);
                $subject->update([
                    'name' => $this->names[$key]['name'],
                    'slug' => get_first_word($this->names[$key]['name']),
                ]);
                $this->alert('success', 'Subject Updated Successfully');
            } else {
                Subject::create([
                    // need to fix a bug somewhere around here
                    'name' => $this->names[$key]['name'],
                    'slug' => get_first_word($this->names[$key]['name']),
                ]);
                $this->alert('success', 'Subject Updated Successfully');
            }

            $this->names = [];
        }

        $this->cancel();
    }

    public function openDeleteModal($id): void
    {
        $del = Subject::find($id);
        $this->deleting = $del['id'];
    }

    public function delete(Subject $subject): void
    {
        $subject->delete();

        $this->cancel();
        $this->alert('success', 'Subject Deleted Successfully');
    }

    // Caleb Porzio used a macro to export csv
    //  public function exportSelected()
    //  {
    //    return response()->streamDownload(function () {
    //      echo $this->selectedRowsQuery->toCsv();
    //    }, 'subjects.csv');
    //  }

    // for dynamic input
    public function addInput(): void
    {
        $this->names[] = $this->i++;
    }

    public function removeInput($index): void
    {
        unset($this->names[$index]);
    }
}
