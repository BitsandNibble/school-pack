<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * @property mixed subjects
 * @property mixed subjectsQuery
 */
class Subjects extends Component
{
  use WithPagination;
  use LivewireAlert;

  public $i = 1;
  public $paginate = 15;
  public $q;
  public $subject_id;
  public $deleting;
  public bool $selectPage = false;
  public bool $selectAll = false;
  public $names = [0];
  public $selected = [];

  protected string $paginationTheme = 'bootstrap';

  protected array $rules = [
    'names.*.name' => 'required|string'
  ];

  protected array $validationAttributes = [
    'names.*.name' => 'subject'
  ];

  public function updatedSelected()
  {
    $this->selectAll = false;
    $this->selectPage = false;
  }

  public function updatedSelectPage($value)
  {
    $this->selected = $value
      ? $this->subjects->pluck('id')->map(fn($id) => (string)$id)
      : [];
  }

  public function selectAll()
  {
    $this->selectAll = true;
  }

  public function getSubjectsQueryProperty()
  {
    return Subject::query()
      ->when($this->q, function ($query) {
        return $query->search($this->q);
      });
  }

  public function getSubjectsProperty()
  {
    return $this->subjectsQuery->Paginate($this->paginate);
  }

  public function render(): Factory|View|Application
  {
    if ($this->selectAll) {
      $this->selected = $this->subjects->pluck('id')->map(fn($id) => (string)$id);
    }

    $classes = ClassRoom::orderBy('name', 'ASC')->get();
    $subjects = $this->subjects;

    return view('livewire.pages.principal.subjects', compact('classes', 'subjects'));
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $subject = Subject::where('id', $id)->get();
    $this->subject_id = $subject->first()->id;

    $this->names = [];
    foreach ($subject as $key => $value) {
      $this->names[$key]['name'] = $value->name;
    }
  }

  public function store(): void
  {
    $this->validate();

    foreach ($this->names as $key => $value) {
      if ($this->subject_id) {
        $subject = Subject::find($this->subject_id);
        $subject->update([
          'name' => $this->names[$key]['name'],
          'slug' => get_first_word($this->names[$key]['name']),
        ]);
        $this->alert('success', 'Subject Updated Successfully');
      } else {
        Subject::create([
          // need to fix a bug somewhere around here
          'name' => $this->names[$key]['name'],
          'slug' => get_first_word($this->names[$key]['name']),
        ]);
        $this->alert('success', 'Subject Updated Successfully');
      }

      $this->names = [];
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

  public function exportSelected()
  {
    return response()->streamDownload(function () {
      echo (clone $this->subjectsQuery)
        ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected))
        ->toCsv();
    }, 'subjects.csv');
  }

  public function deleteSelected(): void
  {
    (clone $this->subjectsQuery)
      ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected))
      ->delete();

    $this->cancel();
  }

  // for dynamic input
  public function addInput(): void
  {
    $this->names[] = $this->i++;
  }

  public function removeInput($index): void
  {
    unset($this->names[$index]);
  }

}
