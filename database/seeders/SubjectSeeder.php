<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('subjects')->delete();

    $subjects = ['English Language', 'Mathematics', 'Civics'];
    $subject_slug = ['Eng', 'Maths', 'Civic'];
    $classes = ClassRoom::all();

    $data = [
      ['name' => $subjects[0], 'slug' => $subject_slug[0]],
      ['name' => $subjects[1], 'slug' => $subject_slug[1]],
      ['name' => $subjects[2], 'slug' => $subject_slug[2]],
    ];

    foreach ($classes as $class) {
      DB::table('class_room_subject_teachers')->insert([
        'class_room_id' => $class->id,
        'subject_id' => Subject::get('id'),
      ]);

    }

    DB::table('subjects')->insert($data);
  }
}
