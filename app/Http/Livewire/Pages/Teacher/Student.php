<?php

namespace App\Http\Livewire\Pages\Teacher;

use Livewire\Component;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Models\ClassStudentSubject;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Models\Student as StudentModel;
use Illuminate\Contracts\Foundation\Application;

class Student extends Component
{
    use WithPagination;
    use WithSorting;

    public $q;
    public $paginate = 10;
    public $section_id;
    public $student_info;
    public $offered_subjects;

    protected string $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
    ];

    public function mount($id): void
    {
        $this->section_id = $id;
    }

    public function cancel(): void
    {
        $this->emit('closeModal');
        $this->reset(['student_info']);
    }

    public function render(): Factory|View|Application
    {
        $query = StudentModel::where('section_id', $this->section_id)
            ->when($this->q, fn($query) => $query->search($this->q));

        $students = $query->paginate(10);

        $this->applySorting($query);

        return view('livewire.pages.teacher.student', compact('students'));
    }

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function showInfo($id): void
    {
        $this->student_info = StudentModel::where('id', $id)->with('classroom', 'section')->get();
        $this->offered_subjects = ClassStudentSubject::where('student_id', $id)->get();
    }
}
