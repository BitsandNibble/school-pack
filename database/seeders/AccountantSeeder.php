<?php

namespace Database\Seeders;

use App\Models\Accountant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accountants')->truncate();

        Accountant::create([
            'fullname' => 'Adams Anna',
            'slug' => 'adams-anna',
            'title' => 'Mrs',
            'email' => 'accountant@gmail.com',
            'phone_number' => '0801111222',
            'school_id' => 'GS_002',
            'password' => Hash::make('password'),
        ]);
    }
}
