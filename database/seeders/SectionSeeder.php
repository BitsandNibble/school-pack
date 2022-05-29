<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->truncate();
        $c = ClassRoom::pluck('id')->all();

        $data = [
            ['name' => 'Gold', 'class_room_id' => $c[0]],
            ['name' => 'Diamond', 'class_room_id' => $c[0]],
            ['name' => 'Silver', 'class_room_id' => $c[1]],
            ['name' => 'Lemon', 'class_room_id' => $c[1]],
            ['name' => 'Bronze', 'class_room_id' => $c[2]],
            ['name' => 'Silver', 'class_room_id' => $c[3]],
            ['name' => 'Diamond', 'class_room_id' => $c[4]],
            ['name' => 'Blue', 'class_room_id' => $c[5]],
            ['name' => 'A', 'class_room_id' => $c[6]],
            ['name' => 'A', 'class_room_id' => $c[7]],
            ['name' => 'A', 'class_room_id' => $c[8]],
            ['name' => 'A', 'class_room_id' => $c[9]],
        ];

        DB::table('sections')->insert($data);
    }
}
