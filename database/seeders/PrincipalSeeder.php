<?php

namespace Database\Seeders;

use App\Models\Principal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PrincipalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Principal::create([
            'fullname' => 'Sam Daniels Adekoya',
            'slug' => 'sam-daniels',
            'email' => 'principal@gmail.com',
            'phone_number' => '0802222222',
            'school_id' => 'GS_001',
            'password' => Hash::make('password'),
        ]);
    }
}
