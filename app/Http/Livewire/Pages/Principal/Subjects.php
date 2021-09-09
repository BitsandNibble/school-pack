<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Subject;
use Livewire\Component;

class Subjects extends Component
{
  public $q, $paginate = 15;
  public $name, $subject_id, $deleting;
  public $i = 1, $inputs = [];

//  protected $rules = [
//    'name.0' => 'required|string',
//    'name.*' => 'required|string'
//  ];

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
    $this->name = $subject['name.0'];
  }

  public function store(): void
  {
    $validated = $this->validate([
      'name.0' => 'required|string',
      'name.*' => 'required|string'
    ],
      [
        'name.0.required' => 'subject field is required',
        'name.*.required' => 'subject field is required'
      ]);

    if ($this->subject_id) {
      $subject = Subject::find($this->subject_id);
      $subject->update($validated);
      session()->flash('message', 'Subject Updated Successfully');
    } else {
      foreach ($this->name as $key => $value) {
        $subject = Subject::create([
          'name' => $this->name[$key],
        ]);
      }
      $this->inputs = [];

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


  // for dynamic input
  public function add($i): void
  {
    ++$i;
    $this->i = $i;
    $this->inputs[] = $i;
  }

  public function remove($i): void
  {
    unset($this->inputs[$i]);
  }

}
