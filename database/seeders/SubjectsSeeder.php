<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('subjects')->truncate();

		$data = [
			['name' => 'Chemistry', 'slug' => 'chem'],
			['name' => 'Physics', 'slug' => 'phy'],
			['name' => 'Biology', 'slug' => 'bio'],
			['name' => 'Mathematics', 'slug' => 'maths'],
			['name' => 'English Language', 'slug' => 'english'],
			['name' => 'Social Studies', 'slug' => 'soc-stud'],
			['name' => 'Basic Technology', 'slug' => 'basic-tech'],
			['name' => 'Yoruba', 'slug' => 'yoruba'],
		];

		DB::table('subjects')->insert($data);
	}
}
