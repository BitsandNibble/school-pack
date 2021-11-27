<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Grade;
use Livewire\Component;
use App\Models\ClassType;
use App\Traits\WithBulkActions;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @property mixed rowsQuery
 * @property mixed rows
 * @property mixed selectedRowsQuery
 */
class Grades extends Component
{
  use LivewireAlert;
  use WithBulkActions;

  public $grade;
  public $grade_id;
  public $deleting;
  public $total;

  protected array $rules = [
    'grade.name' => 'required|string',
    'grade.mark_from' => 'required|numeric',
    'grade.mark_to' => 'required|numeric',
    'grade.class_type_id' => 'sometimes',
    'grade.remark' => 'sometimes',
  ];

  protected array $validationAttributes = [
    'grade.name' => 'name',
    'grade.mark_from' => 'mark from',
    'grade.mark_to' => 'mark to',
  ];

  public function getRowsQueryProperty()
  {
    return Grade::query()
      ->with('class_type');
  }

  public function getRowsProperty()
  {
    return $this->rowsQuery->get();
  }

  public function render(): Factory|View|Application
  {
    if ($this->selectAll) $this->selectPageRows(); // for checkbox

    $class_type = ClassType::get();
    $grades = $this->rows;
    $this->total = $grades->count();

    return view('livewire.pages.principal.grades', compact('class_type', 'grades'));
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $this->grade = Grade::where('id', $id)->first();
    $this->grade_id = $this->grade['id'];
  }

  public function store(): void
  {
    $this->validate();

    if ($this->grade_id) {
      $grade = Grade::find($this->grade_id);
      $grade->update([
        'name' => $this->grade['name'],
        'class_type_id' => $this->grade['class_type_id'] !== 'NULL' ? $this->grade['class_type_id'] : NULL,
        'mark_from' => $this->grade['mark_from'],
        'mark_to' => $this->grade['mark_to'],
        'remark' => $this->grade['remark'],
      ]);
      $this->alert('success', 'Grade Updated Successfully');
    } else {
      Grade::create([
        'name' => $this->grade['name'],
        'class_type_id' => $this->grade['class_type_id'] !== 'NULL' ? $this->grade['class_type_id'] : NULL,
        'mark_from' => $this->grade['mark_from'],
        'mark_to' => $this->grade['mark_to'],
        'remark' => $this->grade['remark'],
      ]);
      $this->alert('success', 'Grade Added Successfully');
    }

    $this->cancel();
  }

  public function openDeleteModal($id): void
  {
    $del = Grade::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Grade $grade): void
  {
    $grade->delete();
    $this->cancel();
    $this->alert('success', 'Grade Deleted Successfully');
  }

  // delete checked/selected rows
  public function deleteSelected(): void
  {
    $this->selectedRowsQuery->delete();

    $this->cancel();
    $this->alert('success', 'Grades Deleted Successfully');
  }
}
