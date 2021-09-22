<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\ClassType;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Classes extends Component
{
  use WithPagination;

  public $name, $deleting;
  public $class_id, $class_type_id;
  public $sortBy = 'name', $sortAsc = true, $paginate = 10;
  protected $paginationTheme = 'bootstrap';
  protected $rules;

  protected $queryString = [
    'sortBy' => ['except' => 'name'],
    'sortAsc' => ['except' => true],
  ];

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
    $classes = ClassRoom::orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
      ->Paginate($this->paginate);
    $class_types = ClassType::get();

    return view('livewire.pages.principal.classes', compact('classes', 'class_types'));
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
    $class = ClassRoom::whereId($id)->first();
    $this->class_id = $class['id'];
    $this->name = $class->name;
    $this->class_type_id = $class->class_type_id;
  }

  public function store(): void
  {
    $this->validate();

    if ($this->class_id) {
      $class = ClassRoom::find($this->class_id);
      $class->update([
        'name' => $this->name,
        'class_type_id' => $this->class_id,
        'slug' => Str::slug($this->name)
      ]);
      session()->flash('message', 'Class Updated Successfully');
    } else {
      ClassRoom::create([
        'name' => $this->name,
        'class_type_id' => $this->class_id,
        'slug' => Str::slug($this->name)
      ]);

      session()->flash('message', 'Class Added Successfully');
    }

    $this->cancel();
  }

  public function openDeleteModal($id): void
  {
    $del = ClassRoom::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(ClassRoom $class): void
  {
    $class->delete();
    $this->cancel();
    session()->flash('message', 'Class Deleted Successfully');
  }
}
