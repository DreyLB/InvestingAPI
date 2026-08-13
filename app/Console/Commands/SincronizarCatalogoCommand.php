<?php

namespace App\Console\Commands;

use App\Application\Services\CatalogoSyncService;
use App\Infrastructure\Providers\BrapiProvider;
use Illuminate\Console\Command;

class SincronizarCatalogoCommand extends Command
{
  protected $signature = 'catalogo:sincronizar';

  public function handle(CatalogoSyncService $service, BrapiProvider $brapi): void
  {
    $categorias = [
      ['type' => 'stock', 'subType' => null, 'excludeSubType' => null, 'assetTypeNome' => 'Ações'],
      ['type' => null, 'subType' => 'fii', 'excludeSubType' => null, 'assetTypeNome' => 'FIIs'],
      ['type' => 'fund', 'subType' => null, 'excludeSubType' => 'fii', 'assetTypeNome' => 'ETF'],
      ['type' => 'bdr', 'subType' => null, 'excludeSubType' => null, 'assetTypeNome' => 'Internacional'],
    ];

    $resumo = $service->sincronizar($brapi, $categorias);

    foreach ($resumo as $tipo => $quantidade) {
      $this->info("{$tipo}: {$quantidade} ativos sincronizados.");
    }
  }
}