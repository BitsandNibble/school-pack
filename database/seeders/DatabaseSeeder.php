<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

		// \App\Models\User::factory(10)->create();

		// User::create([
		//   'name' => 'Sam Billy',
		//   'email' => 'sam@gmail.com',
		//   'email_verified_at' => now(),
		//   'password' => Hash::make('password'),
		// ]);
		$this->call([
			GradeSeeder::class,
			ClassTypeSeeder::class,
			ClassRoomSeeder::class,
			SectionSeeder::class,
			PrincipalSeeder::class,
			SettingsSeeder::class,
			AccountantSeeder::class,
			StudentSeeder::class,
			TeacherSeeder::class,
//            NationalitySeeder::class,
//            StateSeeder::class,
//            LgaSeeder::class,
			SkillSeeder::class,
			NoticeBoardSeeder::class,
			CommentsBankSeeder::class,
			SubjectsSeeder::class,
		]);

		DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
	}
}
