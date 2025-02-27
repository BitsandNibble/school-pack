<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Section;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\ClassRoom;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @property mixed rowsQuery
 * @property mixed rows
 */
class Sections extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithBulkActions;
    use WithSorting;

    public $name;
    public $class;
    public $deleting;
    public string $q = "";
    public $paginate = 10;
    public $section_id;
    public $teacher_id;

    protected string $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
    ];

    protected array $rules = [
        'name' => 'required|string',
        'class' => 'required',
    ];

    public function getRowsQueryProperty()
    {
        $query = Section::query()
            ->when($this->q, fn($query) => $query->search($this->q))
            ->with('class_room', 'teacher');

        return $this->applySorting($query); // apply sorting
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->paginate);
    }

    public function render(): Factory|View|Application
    {
        if ($this->selectAll) $this->selectPageRows(); // for checkbox

        $classes = ClassRoom::get();
        $teachers = Teacher::get();
        $sections = $this->rows;
        return view('livewire.pages.principal.sections', compact('classes', 'teachers', 'sections'));
    }

    public function cancel(): void
    {
        $this->emit('closeModal');
        $this->reset();
		$this->resetErrorBag();
	}

    public function edit($id): void
    {
        $section = Section::where('id', $id)->first();
        $this->section_id = $section['id'];
        $this->name = $section->name;
        $this->class = $section->class_room_id;
        $this->teacher_id = $section->teacher_id;
    }

    public function store(): void
    {
        $this->validate();

        if ($this->section_id) {
            $section = Section::find($this->section_id);
            $section->update([
                'name' => $this->name,
                'class_room_id' => $this->class,
                'teacher_id' => $this->teacher_id !== "" ? $this->teacher_id : null,
            ]);
            $this->alert('success', 'Section Updated Successfully');
        } else {
            Section::create([
                'name' => $this->name,
                'class_room_id' => $this->class,
                'teacher_id' => $this->teacher_id,
            ]);
            $this->alert('success', 'Section Added Successfully');
        }

        $this->cancel();
    }

    public function openDeleteModal($id): void
    {
        $del = Section::find($id);
        $this->deleting = $del['id'];
    }

    public function delete(Section $section): void
    {
        $section->delete();
        $this->cancel();
        $this->alert('success', 'Section Deleted Successfully');
    }
}
