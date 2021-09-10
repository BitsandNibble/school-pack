<?php

namespace App\Http\Livewire\Pages\Teacher;

use App\Models\ClassRoom;
use App\Models\Student as StudentModel;
use Livewire\Component;
use Livewire\WithPagination;

class Student extends Component
{
  use WithPagination;

  public $q, $sortBy = 'fullname', $sortAsc = true, $paginate = 10;
  public $class_id, $studentInfo, $studentClassInfo;
  protected $paginationTheme = 'bootstrap';

  protected $queryString = [
    'q' => ['except' => ''],
    'sortBy' => ['except' => 'fullname'],
    'sortAsc' => ['except' => true],
  ];

  public function mount($id): void
  {
    $this->class_id = $id;
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset(['studentInfo', 'studentClassInfo']);
  }

  public function render()
  {
    $class = ClassRoom::findOrFail($this->class_id);

    $students = $class->students()->wherePivot('class_room_id', $this->class_id)
      ->when($this->q, function ($query) {
        return $query->search($this->q);
      })
      ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
      ->Paginate($this->paginate);

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
    $student = StudentModel::where('id', $id)->with('classes')->first();

    foreach ($student->classes()->get() as $studentClass) {
      $this->studentClassInfo = $studentClass->name;
    }

    $this->studentInfo = $student;
  }
}
