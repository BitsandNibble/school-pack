<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Sections extends Component
{
  use WithPagination;
  use LivewireAlert;

  public $name;
  public $class;
  public $deleting;
  public $sortBy = 'name';
  public $sortAsc = true;
  public $paginate = 10;
  public $section_id;
  public $teacher_id;

  protected string $paginationTheme = 'bootstrap';

  protected array $rules = [
    'name' => 'required|string',
    'class' => 'required',
  ];

  public function render(): Factory|View|Application
  {
    $classes = ClassRoom::get();
    $teachers = Teacher::get();
    $sections = Section::orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
      ->with('class_room')
      ->paginate($this->paginate);

    return view('livewire.pages.principal.sections', compact('classes', 'teachers', 'sections'));
  }

  public function sortBy($field): void
  {
    if ($field === $this->sortBy) {
      $this->sortAsc = !$this->sortAsc;
    }
    $this->sortBy = $field;
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
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
        'teacher_id' => $this->teacher_id
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
