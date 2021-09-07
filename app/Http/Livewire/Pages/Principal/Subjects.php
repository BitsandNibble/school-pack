<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Subject;
use Livewire\Component;

class Subjects extends Component
{
  public $q, $paginate = 15;
  public $name, $subject_id, $deleting;

  protected $rules = ['name' => 'required|string'];

  public function render()
  {
    $classes = ClassRoom::orderBy('name')->get();
    $subjects = Subject::when($this->q, function ($query) {
      return $query->search($this->q);
    })->Paginate($this->paginate);

    return view('livewire.pages.principal.subjects', compact('classes', 'subjects'));
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $subject = Subject::where('id', $id)->first();
    $this->subject_id = $subject['id'];
    $this->name = $subject['name'];
  }

  public function store(): void
  {
    $validated = $this->validate();

    if ($this->subject_id) {
      $subject = Subject::find($this->subject_id);
      $subject->update($validated);
      session()->flash('message', 'Subject Updated Successfully');
    } else {
      $subject = Subject::create($validated);
      session()->flash('message', 'Subject Added Successfully');
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
  }
}
