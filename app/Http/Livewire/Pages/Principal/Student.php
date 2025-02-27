<?php

namespace App\Http\Livewire\Pages\Principal;

use Exception;
use App\Models\Section;
use Livewire\Component;
use App\Models\ClassRoom;
use Illuminate\Support\Str;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\Student as StudentModel;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @property mixed rowsQuery
 * @property mixed rows
 */
class Student extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithBulkActions;
    use WithSorting;

    public $q;
    public $paginate = 10;
    public $column_id;
    public $class_id;
    public $section_id;
    public $class_section_id;
    public $parent;
    public $title = 'All Students';
    public $student;
    public $class_name;

    protected string $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh', 'filterStudents', 'fetchAll'];

    protected array $rules = [
        'student.fullname' => 'required|string|unique:students,fullname',
        'student.gender' => 'sometimes',
    ];

    protected array $validationAttributes = [
        'student.fullname' => 'fullname',
        'student.gender' => 'gender',
    ];

    protected $queryString = [
        'q' => ['except' => ''],
    ];

    public function mount($id, $type): void
    {
        $this->class_id = $id[0] ?? $id;
        $this->section_id = $id[1] ?? null;
        $this->parent = $type ?? null;

        // fetching from parent component which gets value from controller
        // type 1 = student
        // type 2 = class
    }

    public function getRowsQueryProperty()
    {
        $query = StudentModel::query()
            ->when($this->q, fn($query) => $query->search($this->q))
            ->with('class_room', 'section');

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->paginate);
    }

    public function render(): Factory|View|Application
    {
        if ($this->selectAll) $this->selectPageRows(); // for checkbox

        $sec = is_null($this->section_id) ? '' : Section::where('id', $this->section_id)->first()->name;
        $class = is_null($this->class_id) ? '' : ClassRoom::where('id', $this->class_id)->first()->name;
        if ($this->class_id) {
            if ($this->section_id) {
                $this->class_section_id = 'section_id';
                $this->column_id = $this->section_id;
            } else {
                $this->title = $class;
                $this->class_section_id = 'class_room_id';
                $this->column_id = $this->class_id;
            }

            $students = $this->rowsQuery
                ->where($this->class_section_id, $this->column_id)
                ->paginate($this->paginate);

            foreach ($students as $student) {
                $this->class_name = $student->class_room->name . ' ' . $sec;
            }
        } else {
            $students = $this->rows;
        }

        return view('livewire.pages.principal.student', compact('students'));
    }

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function filterStudents($id): void
    {
        $this->class_id = $id;
    }

    public function fetchAll(): void
    {
        $this->class_id = null;
        $this->title = 'All Students';
    }

    public function refresh(): void
    {
        $this->render();
    }

    public function cancel(): void
    {
        $this->emit('closeModal');
        $this->reset(['student']);
		$this->resetErrorBag();
	}

    /**
     * @throws Exception
     */
    public function store(): void
    {
        $this->validate();

        if ($this->section_id) {
            StudentModel::create([
                'fullname' => $this->student['fullname'],
                'class_room_id' => $this->class_id,
                'section_id' => $this->section_id,
                'gender' => $this->student['gender'] ?? '',
                'school_id' => 'GS_' . random_int(500, 1000),
                'password' => Hash::make('password'),
                'slug' => Str::slug($this->student['fullname']),
            ]);
        } else {
            StudentModel::create([
                'fullname' => $this->student['fullname'],
                'class_room_id' => $this->class_id,
                'gender' => $this->student['gender'] ?? '',
                'school_id' => 'GS_' . random_int(500, 1000),
                'password' => Hash::make('password'),
                'slug' => Str::slug($this->student['fullname']),
            ]);
        }

        $this->cancel();
        $this->alert('success', 'Student Added Successfully');
    }
}
