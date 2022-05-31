<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Models\Principal;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Actions\Fortify\PasswordValidationRules;

class UpdatePassword extends Component
{
	use PasswordValidationRules;
	use LivewireAlert;

	public $principal;

	public $validationAttributes = [
		'principal.current_password'      => 'current password',
		'principal.password'              => 'password',
		'principal.password_confirmation' => 'password',
	];

	public function render()
	{
		return view('livewire.components.update-password');
	}

	public function updatePrincipalPassword()
	{
		$this->validate([
			'principal.current_password'      => 'required',
			'principal.password'              => 'required|min:6',
			'principal.password_confirmation' => 'required',
		]);

		Principal::query()->find(auth()->id())
			->update([
				'password' => Hash::make($this->principal['password_confirmation'])
			]);

		$this->alert('success', 'Password Updated Successfully');
	}
}
