<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Teacher::create([
      'slug' => 'amara',
      'fullname' => 'Amrachi Amara',
      'title' => 'Miss',
      'email' => 'amara@gmail.com',
      'phone_number' => '080121121',
      'school_id' => 'GS_005',
      'password' => Hash::make('password'),
    ]);
  }
}
