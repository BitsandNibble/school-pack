<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Skill;
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
 */
class Skills extends Component
{
    use LivewireAlert;
    use WithBulkActions;

    public $skill;
    public $skill_id;
    public $deleting;
    public $total;

    protected array $rules = [
        'skill.name' => 'required|string',
        'skill.skill_type' => 'required',
        'skill.class_type_id' => 'sometimes',
    ];

    protected array $validationAttributes = [
        'skill.name' => 'name',
        'skill.skill_type' => 'skill type',
    ];

    public function getRowsQueryProperty()
    {
        return Skill::with('class_type');
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->get();
    }

    public function render(): Factory|View|Application
    {
        if ($this->selectAll) $this->selectPageRows(); // for checkbox

        $class_types = ClassType::get();
        $skills = $this->rows;
        $this->total = $skills->count();

        return view('livewire.pages.principal.skills', compact('skills', 'class_types'));
    }

    public function cancel(): void
    {
        $this->emit('closeModal');
        $this->reset();
		$this->resetErrorBag();
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
            $this->alert('success', 'Skill Updated Successfully');
        } else {
            Skill::create([
                'name' => $this->skill['name'],
                'skill_type' => $this->skill['skill_type'],
                'class_type_id' => $this->skill['class_type_id'] !== 'NULL' ? $this->skill['class_type_id'] : NULL,
            ]);
            $this->alert('success', 'Skill Added Successfully');
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
        $this->alert('success', 'Skill Deleted Successfully');
    }
}
