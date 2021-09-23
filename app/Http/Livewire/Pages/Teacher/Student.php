<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\Student as StudentModel;
use Livewire\Component;
use Livewire\WithPagination;

class Student extends Component
{
  use WithPagination;

  public $q, $sortBy = 'fullname', $sortAsc = true, $paginate = 10;
  public $section_id, $studentInfo, $studentClassInfo;
  protected $paginationTheme = 'bootstrap';

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
    $this->reset(['studentInfo', 'studentClassInfo']);
  }

  public function render()
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
    $this->studentInfo = $student;
    $this->studentClassInfo = is_null($student) ? null : $student->class_room->name . ' ' . $student->section->name;
  }
}
