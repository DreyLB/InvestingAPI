<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\AssetType;
use App\Domain\Repositories\AssetTypeRepositoryInterface;
use App\Infrastructure\Persistence\Models\AssetTypeModel;
use DateTime;

class AssetTypeRepository implements AssetTypeRepositoryInterface
{
  public function save(AssetType $assetType): void
  {
    $model = $assetType->getId()
      ? AssetTypeModel::findOrFail($assetType->getId())
      : new AssetTypeModel();

    $model->nome = $assetType->getNome();
    $model->descricao = $assetType->getDescricao();
    $model->save();
  }

  public function findAll(): array
  {
    return AssetTypeModel::all()->map(fn($model) => $this->toEntity($model))->toArray();
  }

  public function findById(int $id): ?AssetType
  {
    $model = AssetTypeModel::find($id);
    return $model ? $this->toEntity($model) : null;
  }

  public function delete(int $id): void
  {
    AssetTypeModel::destroy($id);
  }

  private function toEntity(AssetTypeModel $model): AssetType
  {
    return new AssetType(
      $model->id,
      $model->nome,
      $model->descricao,
      new DateTime($model->created_at),
      new DateTime($model->updated_at)
    );
  }
}
