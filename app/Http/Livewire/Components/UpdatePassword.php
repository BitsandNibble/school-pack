<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Actions\Fortify\PasswordValidationRules;

class UpdatePassword extends Component
{
	use PasswordValidationRules;
	use LivewireAlert;

	public $current_password;
	public $password;
	public $password_confirmation;

	public function render()
	{
		return view('livewire.components.update-password');
	}

	public function updatePassword()
	{
		$input = [
			'current_password'      => $this->current_password ?? '',
			'password'              => $this->password ?? '',
			'password_confirmation' => $this->password_confirmation ?? '',
		];

		$user = auth()->user();

		Validator::make($input, [
			'current_password' => ['required', 'string'],
			'password'         => $this->passwordRules(),
		])->after(function ($validator) use ($user, $input) {
			if (!isset($input['current_password']) || !Hash::check($input['current_password'], $user->password)) {
				$validator->errors()->add('current_password', __('The provided password does not match your current password.'));
			}
		})->validate();

		$user->forceFill([
			'password' => Hash::make($input['password']),
		])->save();

		session()->invalidate();
		session()->regenerateToken();

		$this->alert('success', 'Password Updated Successfully');

		return redirect(request()->header('Referer'));
	}
}
