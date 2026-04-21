<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetTypeSeeder extends Seeder
{
  public function run(): void
  {
    $types = ['Ações', 'FIIs', 'Cripto', 'Tesouro', 'ETF', 'Internacional'];

    foreach ($types as $type) {
      DB::table('asset_types')->insert([
        'nome'       => $type,
        'descricao'  => null,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }
}
