<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
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
            NationalitySeeder::class,
            StateSeeder::class,
            LgaSeeder::class,
            SkillSeeder::class,
            NoticeBoardSeeder::class,
            PrincipalsCommentsSeeder::class,
            TeachersCommentsSeeder::class,
        ]);
    }
}
