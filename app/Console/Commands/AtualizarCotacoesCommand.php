<?php
// app/Console/Commands/AtualizarCotacoesCommand.php

namespace App\Console\Commands;

use App\Application\Services\CotacaoService;
use App\Infrastructure\Providers\BrapiProvider;
use App\Infrastructure\Providers\CoinGeckoProvider;
use Illuminate\Console\Command;

class AtualizarCotacoesCommand extends Command
{
  protected $signature = 'cotacoes:atualizar';

  public function handle(CotacaoService $service, BrapiProvider $brapi, CoinGeckoProvider $coinGecko): void
  {
    $tickers = ['PETR4', 'VALE3', 'ITUB4'];
    $service->atualizarCotacoesAcoes($brapi, $tickers);

    $cryptos = ['bitcoin', 'ethereum'];
    $service->atualizarCotacoesCripto($coinGecko, $cryptos);

    $this->info('Cotações atualizadas com sucesso.');
  }
}
