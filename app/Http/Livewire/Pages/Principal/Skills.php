<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassType;
use App\Models\Skill;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Skills extends Component
{
  public $skill;
  public $skill_id;
  public $deleting;

  protected array $rules = [
    'skill.name' => 'required|string',
    'skill.skill_type' => 'required',
    'skill.class_type_id' => 'sometimes',
  ];

  protected array $validationAttributes = [
    'skill.name' => 'name',
    'skill.skill_type' => 'skill type',
  ];

  public function render(): Factory|View|Application
  {
    $skills = Skill::with('class_type')->get();
    $class_types = ClassType::get();

    return view('livewire.pages.principal.skills', compact('skills', 'class_types'));
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $this->skill = Skill::where('id', $id)->first();
    $this->skill_id = $this->skill['id'];
  }

  public function store(): void
  {
    $this->validate();

    if ($this->skill_id) {
      $skill = Skill::find($this->skill_id);
      $skill->update([
        'name' => $this->skill['name'],
        'skill_type' => $this->skill['skill_type'],
        'class_type_id' => $this->skill['class_type_id'] !== 'NULL' ? $this->skill['class_type_id'] : NULL,
      ]);
      session()->flash('message', 'Skill Updated Successfully');
    } else {
      Skill::create([
        'name' => $this->skill['name'],
        'skill_type' => $this->skill['skill_type'],
        'class_type_id' => $this->skill['class_type_id'] !== 'NULL' ? $this->skill['class_type_id'] : NULL,
      ]);
      session()->flash('message', 'Skill Added Successfully');
    }

    $this->cancel();
  }

  public function openDeleteModal($id): void
  {
    $del = Skill::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Skill $skill): void
  {
    $skill->delete();
    $this->cancel();
    session()->flash('message', 'Skill Deleted Successfully');
  }
}
