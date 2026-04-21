<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    DB::table('users')->insert([
      'name'       => 'Andrey',
      'email'      => 'andreycesar02@email.com',
      'password'   => Hash::make('senha123'),
      'balance'    => 0,
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
