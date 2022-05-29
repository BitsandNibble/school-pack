<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeachersCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['comment' => 'He is a very skilled student'],
            ['comment' => 'She is a very skilled student'],
            ['comment' => 'He is a very talented student'],
            ['comment' => 'She is a very talented student'],
        ];

        DB::table('teachers_comments')->insert($data);
    }
}
