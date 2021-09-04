<?php

namespace App\Http\Livewire\Principal;

use App\Models\Student as ModelsStudent;
use Livewire\Component;
use Livewire\WithPagination;

class Student extends Component
{
  use WithPagination;

  protected $paginationTheme = 'bootstrap';

  protected $listeners = ['refresh'];

  public function render()
  {
    $students = ModelsStudent::with('classRooms')->paginate(10);

    return view('livewire.principal.student', compact('students'));
  }

  public function refresh()
  {
    $this->render();
  }

  public function edit($id)
  {
    $this->emit('edit', $id);
  }

  public function showInfo($id)
  {
    $this->emit('showInfo', $id);
  }

  public function openDeleteModal($id)
  {
    $this->emit('openDeleteModal', $id);
  }
}
