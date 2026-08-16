<?php

namespace App\Infrastructure\Providers;

use Illuminate\Support\Facades\Http;

class BrapiProvider implements MarketDataProviderInterface
{
  public function __construct(private readonly string $apiKey) {}

  public function buscarCotacoes(array $tickers): array
  {
    $resultado = [];

    // O plano atual da Brapi permite apenas 1 ativo por requisição
    foreach ($tickers as $ticker) {
      $response = Http::timeout(10)
        ->withToken($this->apiKey)
        ->get('https://brapi.dev/api/v2/stocks/quote', [
          'symbols' => $ticker,
        ]);

      // Em lotes grandes é esperado falhar em alguns tickers (delisted,
      // rate limit etc.) — não aborta o restante do lote por causa disso.
      if ($response->failed()) {
        continue;
      }

      foreach ($response->json('results', []) as $item) {
        $resultado[$item['symbol']] = $item['data']['regularMarketPrice'];
      }

      usleep(150_000);
    }

    return $resultado;
  }

  /**
   * @return array<int, array{symbol: string, name: string, subType: ?string, isActive: bool}>
   */
  public function listarTickers(?string $type = null, ?string $subType = null): array
  {
    $resultado = [];
    $page = 1;

    do {
      $response = Http::timeout(15)
        ->withToken($this->apiKey)
        ->get('https://brapi.dev/api/v2/tickers', array_filter([
          'type' => $type,
          'subType' => $subType,
          'limit' => 2000,
          'page' => $page,
        ]))
        ->throw()
        ->json();

      foreach ($response['results'] ?? [] as $item) {
        if ($item['isActive'] ?? true) {
          $resultado[] = $item;
        }
      }

      $temProximaPagina = $response['pagination']['hasNextPage'] ?? false;
      $page++;
    } while ($temProximaPagina);

    return $resultado;
  }
}