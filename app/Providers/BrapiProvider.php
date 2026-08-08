<?php
// app/Infrastructure/Providers/BrapiProvider.php

namespace App\Infrastructure\Providers;

use Illuminate\Support\Facades\Http;

class BrapiProvider implements MarketDataProviderInterface
{
  public function buscarCotacoes(array $tickers): array
  {
    $symbols = implode(',', $tickers);

    $response = Http::timeout(10)
      ->get('https://brapi.dev/api/v2/stocks/quote', [
        'symbols' => $symbols,
      ])
      ->throw()
      ->json();

    $resultado = [];
    foreach ($response['results'] ?? [] as $item) {
      $resultado[$item['symbol']] = $item['regularMarketPrice'];
    }

    return $resultado;
  }
}
