<?php
// app/Infrastructure/Providers/CoinGeckoProvider.php

namespace App\Infrastructure\Providers;

use Illuminate\Support\Facades\Http;

class CoinGeckoProvider implements MarketDataProviderInterface
{
  public function buscarCotacoes(array $tickers): array
  {
    // ex: tickers = ['bitcoin', 'ethereum']
    $ids = implode(',', $tickers);

    $response = Http::timeout(10)
      ->get('https://api.coingecko.com/api/v3/simple/price', [
        'ids' => $ids,
        'vs_currencies' => 'brl',
      ])
      ->throw()
      ->json();

    $resultado = [];
    foreach ($response as $id => $valores) {
      $resultado[$id] = $valores['brl'];
    }

    return $resultado;
  }
}
