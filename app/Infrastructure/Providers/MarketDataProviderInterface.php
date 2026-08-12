<?php
// app/Infrastructure/Providers/MarketDataProviderInterface.php

namespace App\Infrastructure\Providers;

interface MarketDataProviderInterface
{
  /**
   * @return array<string, float> ['PETR4' => 37.85, 'VALE3' => 61.20]
   */
  public function buscarCotacoes(array $tickers): array;
}
