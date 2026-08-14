<?php

namespace App\Application\Services;

use App\Domain\Entities\Ativo;
use App\Domain\Repositories\AssetTypeRepositoryInterface;
use App\Domain\Repositories\AtivoRepositoryInterface;
use App\Infrastructure\Providers\BrapiProvider;
use DateTime;

class CatalogoSyncService
{
  public function __construct(
    private AtivoRepositoryInterface $ativoRepository,
    private AssetTypeRepositoryInterface $assetTypeRepository,
  ) {}

  /**
   * @param array<int, array{type: ?string, subType: ?string, excludeSubType: ?string, assetTypeNome: string}> $categorias
   * @return array<string, int> quantidade sincronizada por assetTypeNome
   */
  public function sincronizar(BrapiProvider $provider, array $categorias): array
  {
    $assetTypesPorNome = [];
    foreach ($this->assetTypeRepository->findAll() as $assetType) {
      $assetTypesPorNome[$assetType->getNome()] = $assetType;
    }

    $resumo = [];

    foreach ($categorias as $categoria) {
      $assetType = $assetTypesPorNome[$categoria['assetTypeNome']] ?? null;

      if (!$assetType) {
        continue;
      }

      $tickers = $provider->listarTickers($categoria['type'] ?? null, $categoria['subType'] ?? null);
      $sincronizados = 0;

      foreach ($tickers as $ticker) {
        $excludeSubType = $categoria['excludeSubType'] ?? null;

        if ($excludeSubType && ($ticker['subType'] ?? null) === $excludeSubType) {
          continue;
        }

        $this->upsertAtivo($ticker, $assetType->getId());
        $sincronizados++;
      }

      $resumo[$categoria['assetTypeNome']] = $sincronizados;
    }

    return $resumo;
  }

  private function upsertAtivo(array $ticker, int $assetTypeId): void
  {
    $existente = $this->ativoRepository->findByTickerExato($ticker['symbol']);

    $ativo = new Ativo(
      id: $existente?->getId(),
      ticker: strtoupper($ticker['symbol']),
      nome: $ticker['name'],
      assetTypeId: $assetTypeId,
      categoriaId: $existente?->getCategoriaId(),
      createdAt: new DateTime(),
      updatedAt: new DateTime(),
    );

    $this->ativoRepository->save($ativo);
  }
}
