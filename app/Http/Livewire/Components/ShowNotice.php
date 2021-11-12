<?php

namespace App\Http\Livewire\Components;

use App\Models\NoticeBoard as NoticeBoardModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ShowNotice extends Component
{
  public function render(): Factory|View|Application
  {
    $notices = NoticeBoardModel::with('principal')->get();

    return view('livewire.components.show-notice', compact('notices'));
  }
}
