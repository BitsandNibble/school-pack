<?php

namespace App\Http\Livewire\Components;

use App\Models\Skill;
use Livewire\Component;
use App\Models\ExamRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

class Skills extends Component
{
    use LivewireAlert;

    public int $student_id;
    public $year;
    public $data;
    public array $af = [];
    public array $ps = [];

    public function mount($id, $year): void
    {
        $this->student_id = $id;
        $this->year       = $year;
        $this->data       = [
            'student_id' => $this->student_id,
            'year'       => $this->year,
        ];
    }

    public function render(): Factory|View|Application
    {
        $skills = Skill::query()->get();

        $a        = ExamRecord::query()->where($this->data)->get();
        $b        = $a->toArray()[0];
        $this->af = explode(',', $b['af']);
        $this->ps = explode(',', $b['ps']);

        return view('livewire.components.skills', compact('skills'));
    }

    public function store($skill): void
    {
        $d = [];

        if ($skill === 'af') {
            $d[$skill] = implode(',', $this->af);
        }
        if ($skill === 'ps') {
            $d[$skill] = implode(',', $this->ps);
        }

        ExamRecord::query()->where($this->data)->first()->update($d);

        $this->alert('success', 'Skill Updated Successfully');
    }
}
