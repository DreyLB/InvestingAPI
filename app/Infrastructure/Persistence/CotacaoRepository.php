<?php
// app/Infrastructure/Persistence/CotacaoRepository.php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Cotacao;
use App\Domain\Repositories\CotacaoRepositoryInterface;
use App\Infrastructure\Persistence\Models\CotacaoModel;
use DateTimeImmutable;

class CotacaoRepository implements CotacaoRepositoryInterface
{
  public function salvar(int $assetId, float $valor, DateTimeImmutable $atualizadoEm): void
  {
    CotacaoModel::updateOrCreate(
      ['asset_id' => $assetId],
      ['valor' => $valor, 'atualizado_em' => $atualizadoEm]
    );
  }

  public function buscarPorAssetId(int $assetId): ?Cotacao
  {
    $model = CotacaoModel::where('asset_id', $assetId)->first();

    return $model ? $this->toEntity($model) : null;
  }

  public function buscarPorTicker(string $ticker): ?Cotacao
  {
    $model = CotacaoModel::whereHas('asset', fn($q) => $q->where('ticker', strtoupper($ticker)))->first();

    return $model ? $this->toEntity($model) : null;
  }

  public function buscarPorAssetTypeId(int $assetTypeId): array
  {
    return CotacaoModel::whereHas('asset', fn($q) => $q->where('asset_type_id', $assetTypeId))
      ->get()
      ->map(fn($model) => $this->toEntity($model))
      ->all();
  }

  public function buscarPorAssetIds(array $assetIds): array
  {
    return CotacaoModel::whereIn('asset_id', $assetIds)
      ->get()
      ->map(fn($model) => $this->toEntity($model))
      ->all();
  }

  private function toEntity(CotacaoModel $model): Cotacao
  {
    return new Cotacao(
      assetId: $model->asset_id,
      valor: $model->valor,
      atualizadoEm: DateTimeImmutable::createFromMutable($model->atualizado_em),
      id: $model->id,
    );
  }
}
