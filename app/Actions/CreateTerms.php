<?php

namespace App\Actions;

use App\Models\Term;

class CreateTerms
{
	public function 	create(): void
	{
		Term::firstOrCreate([
			'name' => 'First Term',
			'session' => get_setting('current_session'),
		]);

		Term::firstOrCreate([
			'name' => 'Second Term',
			'session' => get_setting('current_session'),
		]);

		Term::firstOrCreate([
			'name' => 'Third Term',
			'session' => get_setting('current_session'),
		]);
	}
}