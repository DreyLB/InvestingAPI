<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Cotacao;

interface CotacaoRepositoryInterface
{
  public function salvar(int $assetId, float $valor, \DateTimeImmutable $atualizadoEm): void;

  public function buscarPorAssetId(int $assetId): ?Cotacao;

  public function buscarPorTicker(string $ticker): ?Cotacao;

  /**
   * @return Cotacao[]
   */
  public function buscarPorAssetTypeId(int $assetTypeId): array;

  /**
   * @param int[] $assetIds
   * @return Cotacao[]
   */
  public function buscarPorAssetIds(array $assetIds): array;
}
