<?php
// app/Console/Commands/AtualizarIndicadoresMercadoCommand.php

namespace App\Console\Commands;

use App\Application\Services\IndicadorMercadoService;
use App\Infrastructure\Providers\HgBrasilProvider;
use Illuminate\Console\Command;

class AtualizarIndicadoresMercadoCommand extends Command
{
  protected $signature = 'indicadores:atualizar';

  public function handle(IndicadorMercadoService $service, HgBrasilProvider $hgBrasil): void
  {
    $service->atualizar($hgBrasil);

    $this->info('Indicadores de mercado atualizados com sucesso.');
  }
}
