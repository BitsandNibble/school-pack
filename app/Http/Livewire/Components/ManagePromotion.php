<?php

namespace App\Http\Livewire\Components;


use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Models\Promotion as PromotionModel;
use Illuminate\Contracts\Foundation\Application;

class ManagePromotion extends Component
{
    public function render(): Factory|View|Application
    {
        $old_year = get_setting('current_session');
        $old_yr = explode('-', $old_year);
        $new_year = ++$old_yr[0] . ' - ' . ++$old_yr[1];

        $promotions = PromotionModel::with('student', 'fc', 'fs', 'tc', 'ts')->get();

        return view('livewire.components.manage-promotion', compact('promotions', 'old_year', 'new_year'));
    }
}