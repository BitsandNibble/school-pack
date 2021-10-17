<?php

namespace App\Http\Livewire\Components;

use App\Models\ExamRecord;
use App\Models\Skill;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Skills extends Component
{
  public int $student_id;
  public array $af = [];
  public array $ps = [];

  public function mount($id): void
  {
    $this->student_id = $id;
  }

  /**
   * @throws \JsonException
   */
  public function render(): Factory|View|Application
  {
    $skills = Skill::get();
    $afs = ExamRecord::where(['student_id' => $this->student_id])->first()->af;
    $pss = ExamRecord::where(['student_id' => $this->student_id])->first()->ps;

    $decode_afs = empty($afs) ? '' : json_decode($afs, true, 512, JSON_THROW_ON_ERROR);
    $decode_pss = empty($pss) ? '' : json_decode($pss, true, 512, JSON_THROW_ON_ERROR);

    $this->af = $decode_afs ?: [];
    $this->ps = $decode_pss ?: [];

    return view('livewire.components.skills', compact('skills'));
  }

  public function store(): void
  {
    $af_skill = json_encode($this->af, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT);
    $ps_skill = json_encode($this->ps, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT);

    $exam_record = ExamRecord::where(['student_id' => $this->student_id])->first();
    $exam_record->update([
      'af' => $af_skill,
      'ps' => $ps_skill,
    ]);
  }
}
