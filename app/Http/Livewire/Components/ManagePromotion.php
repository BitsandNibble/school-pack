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

		$new_year = explode('-', $old_year);
		$new_year = ++$new_year[0] . ' - ' . ++$new_year[1];

		// where fc, fs , tc & ts are "from class", "from section", "to class", & "to section" respectively
		$promotions = PromotionModel::with('student', 'fc', 'fs', 'tc', 'ts')->get();

		return view('livewire.components.manage-promotion', compact('promotions', 'old_year', 'new_year'));
	}
}
