<?php
// app/Infrastructure/Providers/HgBrasilProvider.php

namespace App\Infrastructure\Providers;

use Illuminate\Support\Facades\Http;

class HgBrasilProvider implements MarketDataProviderInterface
{
  public function __construct(private readonly string $apiKey) {}

  public function buscarCotacoes(array $tickers): array
  {
    $tickersFormatados = array_map(fn($ticker) => "B3:{$ticker}", $tickers);

    $response = Http::timeout(10)
      ->get('https://api.hgbrasil.com/v2/finance/quotes', [
        'tickers' => implode(',', $tickersFormatados),
        'key' => $this->apiKey,
      ])
      ->throw()
      ->json();

    $resultado = [];
    foreach ($response['results'] ?? [] as $item) {
      $resultado[$item['symbol']] = (float) $item['quote']['value'];
    }

    return $resultado;
  }

  /**
   * @return array<string, array{nome: string, valor: float, variacaoPercentual: ?float}>
   */
  public function buscarIndicadoresMercado(): array
  {
    $response = Http::timeout(10)
      ->get('https://api.hgbrasil.com/finance', [
        'key' => $this->apiKey,
      ])
      ->throw()
      ->json();

    $resultado = [];

    $ibovespa = $response['results']['stocks']['IBOVESPA']['points'] ?? null;
    if ($ibovespa !== null) {
      $variacao = $response['results']['stocks']['IBOVESPA']['variation'] ?? null;
      $resultado['ibovespa'] = [
        'nome' => 'IBOVESPA',
        'valor' => (float) $ibovespa,
        'variacaoPercentual' => $variacao !== null ? (float) $variacao : null,
      ];
    }

    $bitcoin = $response['results']['currencies']['BTC']['buy'] ?? null;
    if ($bitcoin !== null) {
      $variacao = $response['results']['currencies']['BTC']['variation'] ?? null;
      $resultado['bitcoin'] = [
        'nome' => 'Bitcoin',
        'valor' => (float) $bitcoin,
        'variacaoPercentual' => $variacao !== null ? (float) $variacao : null,
      ];
    }

    return $resultado;
  }
}
