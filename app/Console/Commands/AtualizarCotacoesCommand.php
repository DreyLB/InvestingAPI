<?php
// app/Console/Commands/AtualizarCotacoesCommand.php

namespace App\Console\Commands;

use App\Application\Services\CotacaoService;
use App\Infrastructure\Providers\HgBrasilProvider;
use Illuminate\Console\Command;

class AtualizarCotacoesCommand extends Command
{
  protected $signature = 'cotacoes:atualizar';

  public function handle(CotacaoService $service, HgBrasilProvider $hgBrasil): void
  {
    $tickers = ['PETR4', 'VALE3', 'ITUB4'];
    $service->atualizarCotacoes($hgBrasil, $tickers);

    $this->info('Cotações atualizadas com sucesso.');
  }
}
