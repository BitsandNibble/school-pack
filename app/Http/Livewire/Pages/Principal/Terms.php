<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Term;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Traits\WithBulkActions;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @property mixed rowsQuery
 * @property mixed rows
 */
class Terms extends Component
{
  use LivewireAlert;
  use WithBulkActions;

  public int $paginate = 10;
  public $name;
  public $term_id;
  public $deleting;

  protected function rules(): array
  {
    return [
      'name' => [
        'required',
        'string',
        Rule::unique('terms')->where(function ($q) {
          $q->where('session', get_setting('current_session'));
        })->ignore($this->term_id),
      ],
    ];
  }

  public function getRowsQueryProperty()
  {
    return Term::query();
  }

  public function getRowsProperty()
  {
    return $this->rowsQuery->paginate($this->paginate);
  }

  public function render(): Factory|View|Application
  {
    if ($this->selectAll) $this->selectPageRows(); // for checkbox

    $terms = $this->rows;

    return view('livewire.pages.principal.terms', compact('terms'));
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $term = Term::where('id', $id)->first();
    $this->term_id = $term['id'];
    $this->name = $term['name'];
  }

  public function store(): void
  {
    $this->validate();

    if ($this->term_id) {
      $term = Term::find($this->term_id);
      $term->update([
        'name' => $this->name,
        'session' => get_setting('current_session'),
      ]);
      $this->alert('success', 'Term Updated Successfully');
    } else {
      Term::create([
        'name' => $this->name,
        'session' => get_setting('current_session'),
      ]);
      $this->alert('success', 'Term Added Successfully');
    }

    $this->cancel();
  }

  public function openDeleteModal($id): void
  {
    $del = Term::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Term $term): void
  {
    $term->delete();
    $this->cancel();
    $this->alert('success', 'Term Deleted Successfully');
  }
}
