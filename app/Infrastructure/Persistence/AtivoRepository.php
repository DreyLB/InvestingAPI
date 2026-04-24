<?php
// app/Infrastructure/Persistence/AssetRepository.php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Ativo;
use App\Domain\Repositories\AtivoRepositoryInterface;
use App\Infrastructure\Persistence\Models\AtivoModel;
use DateTime;

class AtivoRepository implements AtivoRepositoryInterface
{
  public function findById(int $id): ?Ativo
  {
    $model = AtivoModel::with(['assetType', 'category'])->find($id);
    return $model ? $this->toEntity($model) : null;
  }

  public function findByTicker(string $ticker): array
  {
    $model = AtivoModel::with(['assetType', 'category'])
      ->where('ticker', 'LIKE', strtoupper("%$ticker%"))
      ->get();

    return $model->map(fn($m) => $this->toEntity($m))->toArray();
  }

  public function listarTodos(): array
  {
    return AtivoModel::with(['assetType', 'category'])
      ->orderBy('ticker')
      ->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function save(Ativo $asset): void
  {
    $model = $asset->getId()
      ? AtivoModel::findOrFail($asset->getId())
      : new AtivoModel();

    $model->ticker        = strtoupper($asset->getTicker());
    $model->name          = $asset->getNome();
    $model->asset_type_id = $asset->getAssetTypeId();
    $model->category_id   = $asset->getCategoriaId();
    $model->save();

    if (!$asset->getId()) {
      $asset->setId($model->id);
    }
  }

  private function toArray(AtivoModel $model): array
  {
    return [
      'id'            => $model->id,
      'ticker'        => $model->ticker,
      'nome'          => $model->name,
      'asset_type_id' => $model->asset_type_id,
      'tipo_nome'     => $model->assetType?->nome,
      'category_id'   => $model->category_id,
      'categoria_nome' => $model->category?->nome,
    ];
  }

  private function toEntity(AtivoModel $model): Ativo
  {
    return new Ativo(
      (int) $model->id,
      $model->ticker,
      $model->name,
      (int) $model->asset_type_id,
      $model->category_id ? (int) $model->category_id : null,
      new DateTime($model->created_at),
      new DateTime($model->updated_at)
    );
  }
}
