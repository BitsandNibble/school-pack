<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_types')->truncate();

        $data = [
            ['name' => 'Creche', 'code' => 'C'],
            ['name' => 'Pre Nursery', 'code' => 'PN'],
            ['name' => 'Nursery', 'code' => 'N'],
            ['name' => 'Primary', 'code' => 'P'],
            ['name' => 'Junior Secondary', 'code' => 'J'],
            ['name' => 'Senior Secondary', 'code' => 'S'],
        ];

        DB::table('class_types')->insert($data);
    }
}
