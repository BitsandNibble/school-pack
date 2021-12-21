<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrincipalsCommentsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $data = [
      ['comment' => 'He is a very remarkable student'],
      ['comment' => 'She is a very remarkable student'],
      ['comment' => 'He is very good'],
      ['comment' => 'She is very good'],
    ];

    DB::table('principals_comments')->insert($data);
  }
}
