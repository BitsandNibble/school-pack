<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\Student as StudentModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Student extends Component
{
  use WithPagination;

  public $q;
  public $sortBy = 'fullname';
  public $sortAsc = true;
  public $paginate = 10;
  public $section_id;
  public $student_info;
  public $student_class_info;

  protected string $paginationTheme = 'bootstrap';

  protected $queryString = [
    'q' => ['except' => ''],
    'sortBy' => ['except' => 'fullname'],
    'sortAsc' => ['except' => true],
  ];

  public function mount($id): void
  {
    $this->section_id = $id;
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset(['student_info', 'student_class_info']);
  }

  public function render(): Factory|View|Application
  {
    $students = StudentModel::where('section_id', $this->section_id)
      ->when($this->q, function ($query) {
        return $query->search($this->q);
      })
      ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
      ->paginate(10);

    return view('livewire.pages.teacher.student', compact('students'));
  }

  public function updatingQ(): void
  {
    $this->resetPage();
  }

  public function sortBy($field): void
  {
    if ($field === $this->sortBy) {
      $this->sortAsc = !$this->sortAsc;
    }
    $this->sortBy = $field;
  }

  public function showInfo($id): void
  {
    $student = StudentModel::where('id', $id)->with('class_room', 'section')->first();
    $this->student_info = $student;
    $this->student_class_info = is_null($student) ? null : $student->class_room->name . ' ' . $student->section->name;
  }
}
