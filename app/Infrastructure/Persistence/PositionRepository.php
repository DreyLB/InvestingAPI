<?php
// app/Infrastructure/Persistence/PositionRepository.php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Position;
use App\Domain\Repositories\PositionRepositoryInterface;
use App\Infrastructure\Persistence\Models\PositionModel;

class PositionRepository implements PositionRepositoryInterface
{
  public function listarPorCarteira(int $walletId): array
  {
    return PositionModel::where('wallet_id', $walletId)
      ->with(['asset.assetType', 'asset.category'])
      ->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function findByWalletAndAsset(int $walletId, int $assetId): ?Position
  {
    $model = PositionModel::where('wallet_id', $walletId)
      ->where('asset_id', $assetId)
      ->first();

    return $model ? $this->toEntity($model) : null;
  }

  public function save(Position $position): void
  {
    $model = $position->getId()
      ? PositionModel::findOrFail($position->getId())
      : new PositionModel();

    $model->wallet_id   = $position->getWalletId();
    $model->asset_id    = $position->getAssetId();
    $model->quantidade  = $position->getQuantidade();
    $model->preco_medio = $position->getPrecoMedio();
    $model->valor_total = $position->getValorTotal();
    $model->save();

    if (!$position->getId()) {
      $position->setId($model->id);
    }
  }

  public function delete(int $id): void
  {
    PositionModel::findOrFail($id)->delete();
  }

  private function toArray(PositionModel $model): array
  {
    return [
      'id'             => $model->id,
      'wallet_id'      => $model->wallet_id,
      'asset_id'       => $model->asset_id,
      'ticker'         => $model->asset?->ticker,
      'nome'           => $model->asset?->name,
      'tipo_nome'      => $model->asset?->assetType?->nome,
      'categoria_nome' => $model->asset?->category?->nome,
      'quantidade'     => $model->quantidade,
      'preco_medio'    => $model->preco_medio,
      'valor_total'    => $model->valor_total,
    ];
  }

  private function toEntity(PositionModel $model): Position
  {
    return new Position(
      (int) $model->id,
      (int) $model->wallet_id,
      (int) $model->asset_id,
      (float) $model->quantidade,
      (float) $model->preco_medio,
      (float) $model->valor_total,
      $model->asset?->ticker,
      $model->asset?->name,
      $model->asset?->assetType?->nome
    );
  }
}
