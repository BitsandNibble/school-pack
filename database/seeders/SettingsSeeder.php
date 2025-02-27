<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();

        $data = [
            ['type' => 'school_name', 'description' => 'United Kiddies'],
            ['type' => 'school_title', 'description' => 'UnK'],
            ['type' => 'current_session', 'description' => '2018 - 2019'],
            ['type' => 'term_begins', 'description' => now()->toDateString()],
            ['type' => 'term_ends', 'description' => now()->addMonths(3)->toDateString()],
            ['type' => 'address', 'description' => '18B North Central Park, Behind Central Square Tourist Center'],
            ['type' => 'school_mail', 'description' => 'schoolpack@gmail.com'],
            ['type' => 'alt_mail', 'description' => ''],
            ['type' => 'phone', 'description' => '0123456789'],
            ['type' => 'mobile', 'description' => '0123456789'],
            ['type' => 'school_logo', 'description' => ''],
            ['type' => 'ca1', 'description' => '15'],
            ['type' => 'ca2', 'description' => '15'],
            ['type' => 'exam', 'description' => '70'],
//      ['type' => 'next_term_fees_j', 'description' => '20000'],
//      ['type' => 'next_term_fees_pn', 'description' => '25000'],
//      ['type' => 'next_term_fees_p', 'description' => '25000'],
//      ['type' => 'next_term_fees_n', 'description' => '25600'],
//      ['type' => 'next_term_fees_s', 'description' => '15600'],
//      ['type' => 'next_term_fees_c', 'description' => '1600'],
        ];

        DB::table('settings')->insert($data);
    }
}
