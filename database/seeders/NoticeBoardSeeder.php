<?php

namespace Database\Seeders;

use App\Models\Principal;
use App\Models\NoticeBoard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoticeBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notice_boards')->truncate();

        $author = Principal::first()->id;
        NoticeBoard::insert([
            ['title' => 'Something', 'message' => 'Description of something', 'author_id' => $author, 'created_at' => now()],
            ['title' => 'Something1', 'message' => 'Description of something', 'author_id' => $author, 'created_at' => now(),],
            ['title' => 'Something2', 'message' => 'Description of something', 'author_id' => $author, 'created_at' => now(),],
            ['title' => 'Something3', 'message' => 'Description of something', 'author_id' => $author, 'created_at' => now(),],
            ['title' => 'Something4', 'message' => 'Description of something', 'author_id' => $author, 'created_at' => now(),],
            ['title' => 'Something5', 'message' => 'Description of something', 'author_id' => $author, 'created_at' => now(),],
            ['title' => 'Something6', 'message' => 'Description of something', 'author_id' => $author, 'created_at' => now(),],
        ]);
    }
}
