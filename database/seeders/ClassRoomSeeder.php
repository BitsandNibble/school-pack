<?php

namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassRoomSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('class_rooms')->delete();
    $ct = ClassType::pluck('id')->all();

    $data = [
      ['name' => 'Nursery 1', 'class_type_id' => $ct[2]],
      ['name' => 'Nursery 2', 'class_type_id' => $ct[2]],
      ['name' => 'Nursery 3', 'class_type_id' => $ct[2]],
      ['name' => 'Primary 1', 'class_type_id' => $ct[3]],
      ['name' => 'Primary 2', 'class_type_id' => $ct[3]],
      ['name' => 'JSS 2', 'class_type_id' => $ct[4]],
      ['name' => 'JSS 3', 'class_type_id' => $ct[4]],
      ['name' => 'SSS 1', 'class_type_id' => $ct[5]],
      ['name' => 'SSS 2', 'class_type_id' => $ct[5]],
      ['name' => 'SSS 3', 'class_type_id' => $ct[5]],
    ];

    DB::table('class_rooms')->insert($data);
  }
}
