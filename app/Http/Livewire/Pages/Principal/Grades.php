<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassType;
use App\Models\Grade;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Grades extends Component
{
  public $grade;
  public $grade_id;
  public $class_type_id;
  public $remark;
  public $deleting;

  protected array $rules = [
    'grade.name' => 'required|string',
    'grade.mark_from' => 'required|numeric',
    'grade.mark_to' => 'required|numeric',
  ];

  protected array $validationAttributes = [
    'grade.name' => 'name',
    'grade.mark_from' => 'mark from',
    'grade.mark_to' => 'mark to',
  ];


  public function render(): Factory|View|Application
  {
    $class_type = ClassType::get();
    $grades = Grade::with('class_type')->get();

    return view('livewire.pages.principal.grades', compact('class_type', 'grades'));
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $grade = Grade::where('id', $id)->first();
    $this->grade_id = $grade['id'];
    $this->grade = $grade;
    $this->class_type_id = $grade['class_type_id'];
    $this->remark = $grade['remark'];
  }

  public function store(): void
  {
    $this->validate();

    if ($this->grade_id) {
      $grade = Grade::find($this->grade_id);
      $grade->update([
        'name' => $this->grade['name'],
        'class_type_id' => $this->class_type_id,
        'mark_from' => $this->grade['mark_from'],
        'mark_to' => $this->grade['mark_to'],
        'remark' => $this->remark,
      ]);
      session()->flash('message', 'Grade Updated Successfully');
    } else {
      Grade::create([
        'name' => $this->grade['name'],
        'class_type_id' => $this->class_type_id,
        'mark_from' => $this->grade['mark_from'],
        'mark_to' => $this->grade['mark_to'],
        'remark' => $this->remark,
      ]);
      session()->flash('message', 'Grade Added Successfully');
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
    session()->flash('message', 'Grade Deleted Successfully');
  }
}
