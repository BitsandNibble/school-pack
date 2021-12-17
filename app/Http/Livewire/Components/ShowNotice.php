<?php

namespace App\Http\Livewire\Components;

use App\Models\NoticeBoard as NoticeBoardModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShowNotice extends Component
{
  use WithPagination;

  protected string $paginationTheme = 'bootstrap';

  public function render(): Factory|View|Application
  {
    $notices = NoticeBoardModel::with('principal')->Paginate(5);

    return view('livewire.components.show-notice', compact('notices'));
  }
}
