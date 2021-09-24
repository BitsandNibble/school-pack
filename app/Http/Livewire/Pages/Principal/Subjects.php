<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Helpers\SP;
use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Subjects extends Component
{
  public $q;
  public $paginate = 15;
  public $name;
  public $subject_id;
  public $deleting;
  public $i = 1;
  public $inputs = [];

//  protected $rules = [
//    'name.0' => 'required|string',
//    'name.*' => 'required|string'
//  ];

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
        Subject::create([
          'name' => $this->name[$key],
          'slug' => SP::getFirstWord($this->name[$key]),
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
