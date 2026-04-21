<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
  public function run(): void
  {
    $categories = [
      ['nome' => 'Renda Variável',  'descricao' => 'Ativos com rentabilidade variável'],
      ['nome' => 'Renda Fixa',      'descricao' => 'Ativos com rentabilidade previsível'],
      ['nome' => 'Cripto',          'descricao' => 'Criptomoedas e ativos digitais'],
      ['nome' => 'Internacional',   'descricao' => 'Ativos negociados no exterior'],
    ];

    foreach ($categories as $category) {
      DB::table('categories')->insert([
        'nome'       => $category['nome'],
        'descricao'  => $category['descricao'],
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }
}
