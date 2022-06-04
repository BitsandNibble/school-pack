<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->truncate();

        $data = [
            ['comment' => 'He is a very remarkable student'],
            ['comment' => 'She is a very remarkable student'],
            ['comment' => 'He is very good'],
            ['comment' => 'She is very good'],
        ];

        DB::table('comments')->insert($data);
    }
}
