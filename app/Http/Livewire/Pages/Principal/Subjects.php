<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Subjects extends Component
{
  use LivewireAlert;

  public $q;
  public $paginate = 15;
  public $names = [0];
  public $subject_id;
  public $deleting;
  public $i = 1;

  protected array $rules = [
    'names.*.name' => 'required|string|min:6'
  ];

  protected array $validationAttributes = [
    'names.*.name' => 'subject'
  ];

  public function render(): Factory|View|Application
  {
    $classes = ClassRoom::orderBy('name', 'ASC')->get();
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
    $subject = Subject::where('id', $id)->get();
    $this->subject_id = $subject->first()->id;

    $this->names = [];
    foreach ($subject as $key => $value) {
      $this->names[$key]['name'] = $value->name;
    }
  }

  public function store(): void
  {
    $this->validate();

    foreach ($this->names as $key => $value) {
      if ($this->subject_id) {
        $subject = Subject::find($this->subject_id);
        $subject->update([
          'name' => $this->names[$key]['name'],
          'slug' => get_first_word($this->names[$key]['name']),
        ]);
        $this->alert('success', 'Subject Updated Successfully');
      } else {
        Subject::create([
          'name' => $this->names[$key]['name'],
          'slug' => get_first_word($this->names[$key]['name']),
        ]);
        $this->alert('success', 'Subject Updated Successfully');
      }

      $this->names = [];
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

  // for dynamic input
  public function addInput(): void
  {
    $this->names[] = $this->i++;
  }

  public function removeInput($index): void
  {
    unset($this->names[$index]);
  }

}
