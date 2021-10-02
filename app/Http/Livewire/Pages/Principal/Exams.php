<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Helpers\SP;
use App\Models\Exam;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Exams extends Component
{
  public $exam;
  public $exam_id;
  public $deleting;

  protected array $rules = [
    'exam.name' => 'required|string',
    'exam.term' => 'required|string',
  ];

  protected array $validationAttributes = [
    'exam.name' => 'name',
    'exam.term' => 'term',
  ];

  public function render(): Factory|View|Application
  {
    $exams = Exam::get();

    return view('livewire.pages.principal.exams', compact('exams'));
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $exam = Exam::where('id', $id)->first();
    $this->exam_id = $exam['id'];
    $this->exam = $exam;
  }

  public function store(): void
  {
    $this->validate();

    if ($this->exam_id) {
      $exam = Exam::find($this->exam_id);
      $exam->update([
        'name' => $this->exam['name'],
        'term' => $this->exam['term'],
        'session' => SP::getSetting('current_session'),
      ]);
      session()->flash('message', 'Exam Updated Successfully');
    } else {
      Exam::create([
        'name' => $this->exam['name'],
        'term' => $this->exam['term'],
        'session' => SP::getSetting('current_session'),
      ]);
      session()->flash('message', 'Exam Added Successfully');
    }

    $this->cancel();
  }

  public function openDeleteModal($id): void
  {
    $del = Exam::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Exam $exam): void
  {
    $exam->delete();
    $this->cancel();
    session()->flash('message', 'Exam Successfully');
  }
}
