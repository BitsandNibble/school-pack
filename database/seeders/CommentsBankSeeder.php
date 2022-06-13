<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments_banks')->truncate();

        $data = [
            ['description' => 'He is a very remarkable student'],
            ['description' => 'She is a very remarkable student'],
            ['description' => 'He is very good'],
            ['description' => 'She is very good'],
        ];

        DB::table('comments_banks')->insert($data);
    }
}
