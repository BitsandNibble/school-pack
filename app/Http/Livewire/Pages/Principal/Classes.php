<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\ClassType;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Classes extends Component
{
  use WithPagination;

  public $name, $deleting, $paginate = 10;
  public $class_id, $class_type_id;

  protected $paginationTheme = 'bootstrap';
  protected $rules;

  protected function rules()
  {
    return [
      'name' => ['required', 'string', Rule::unique('class_rooms')->ignore($this->class_id)],
      'class_type_id' => ['required'],
    ];
  }

  protected $validationAttributes = [
    'class_type_id' => 'class type',
  ];

  public function render()
  {
    $classes = ClassRoom::orderBy('name')->with('teachers')->Paginate($this->paginate);
    $class_types = ClassType::get();

    return view('livewire.pages.principal.classes', compact('classes', 'class_types'));
  }

  public function cancel()
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id)
  {
    $class = ClassRoom::whereId($id)->first();
    $this->class_id = $class['id'];
    $this->name = $class->name;
    $this->class_type_id = $class->class_type_id;
  }

  public function store()
  {
    $validated = $this->validate();

    if ($this->class_id) {
      $class = ClassRoom::find($this->class_id);
      $class->update($validated);
      session()->flash('message', 'Class Updated Successfully');
    } else {
      $class = ClassRoom::create($validated);
      session()->flash('message', 'Class Added Successfully');
    }

    $this->cancel();
  }

  public function openDeleteModal($id)
  {
    $del = ClassRoom::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(ClassRoom $class)
  {
    $class->delete();
    $this->cancel();
    session()->flash('message', 'Class Deleted Successfully');
  }
}
