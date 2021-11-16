<?php

namespace App\Http\Livewire\Components;

use App\Models\ExamRecord;
use App\Models\Skill;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use JsonException;
use Livewire\Component;

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
    $this->year = $year;
    $this->data = [
      'student_id' => $this->student_id,
      'year' => $this->year,
    ];
  }

  /**
   * @throws JsonException
   */
  public function render(): Factory|View|Application
  {
    $skills = Skill::get();

    $afs = ExamRecord::where($this->data)->first()->af;
    $pss = ExamRecord::where($this->data)->first()->ps;

    $decode_afs = empty($afs) ? '' : json_decode($afs, true, 512, JSON_THROW_ON_ERROR);
    $decode_pss = empty($pss) ? '' : json_decode($pss, true, 512, JSON_THROW_ON_ERROR);

    $this->af = $decode_afs ?: [];
    $this->ps = $decode_pss ?: [];

    return view('livewire.components.skills', compact('skills'));
  }

  /**
   * @throws JsonException
   */
  public function store(): void
  {
    $af_skill = json_encode($this->af, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT);
    $ps_skill = json_encode($this->ps, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT);

    $exam_record = ExamRecord::where($this->data)->first();
    $exam_record->update([
      'af' => $af_skill,
      'ps' => $ps_skill,
    ]);

    $this->alert('success', 'Skill Updated Successfully');
  }
}
