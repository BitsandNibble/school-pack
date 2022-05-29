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
            ['name' => 'Nursery 1', 'slug' => 'nursery-1', 'class_type_id' => $ct[2]],
            ['name' => 'Nursery 2', 'slug' => 'nursery-2', 'class_type_id' => $ct[2]],
            ['name' => 'Nursery 3', 'slug' => 'nursery-3', 'class_type_id' => $ct[2]],
            ['name' => 'Primary 1', 'slug' => 'primary-1', 'class_type_id' => $ct[3]],
            ['name' => 'Primary 2', 'slug' => 'primary-2', 'class_type_id' => $ct[3]],
            ['name' => 'JSS 1', 'slug' => 'jss-1', 'class_type_id' => $ct[4]],
            ['name' => 'JSS 2', 'slug' => 'jss-2', 'class_type_id' => $ct[4]],
            ['name' => 'JSS 3', 'slug' => 'jss-3', 'class_type_id' => $ct[4]],
            ['name' => 'SSS 1', 'slug' => 'sss-1', 'class_type_id' => $ct[5]],
            ['name' => 'SSS 2', 'slug' => 'sss-2', 'class_type_id' => $ct[5]],
            ['name' => 'SSS 3', 'slug' => 'sss-3', 'class_type_id' => $ct[5]],
        ];

        DB::table('class_rooms')->insert($data);
    }
}
