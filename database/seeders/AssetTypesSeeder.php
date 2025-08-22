<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssetTypesSeeder extends Seeder
{
  public function run(): void
  {
    $now = Carbon::now();

    DB::table('asset_types')->insert([
      ['nome' => 'Ações', 'created_at' => $now, 'updated_at' => $now],
      ['nome' => 'FIIs', 'created_at' => $now, 'updated_at' => $now],
      ['nome' => 'Cripto', 'created_at' => $now, 'updated_at' => $now],
      ['nome' => 'Tesouro', 'created_at' => $now, 'updated_at' => $now],
    ]);
  }
}
