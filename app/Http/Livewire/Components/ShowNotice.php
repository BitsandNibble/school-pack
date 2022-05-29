<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Models\NoticeBoard as NoticeBoardModel;
use Illuminate\Contracts\Foundation\Application;

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
