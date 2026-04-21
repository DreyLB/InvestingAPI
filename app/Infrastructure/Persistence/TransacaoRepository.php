<?php
// app/Infrastructure/Persistence/TransacaoRepository.php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Transacao;
use App\Domain\Repositories\TransacaoRepositoryInterface;
use App\Infrastructure\Persistence\Models\TransacaoModel;
use DateTime;

class TransacaoRepository implements TransacaoRepositoryInterface
{
  public function listarPorCarteira(int $walletId): array
  {
    return TransacaoModel::where('wallet_id', $walletId)
      ->with('asset')
      ->orderBy('data', 'desc')
      ->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function listarPorAsset(int $walletId, int $assetId): array
  {
    return TransacaoModel::where('wallet_id', $walletId)
      ->where('asset_id', $assetId)
      ->with('asset')
      ->orderBy('data', 'desc')
      ->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function findById(int $id): ?Transacao
  {
    $model = TransacaoModel::find($id);
    return $model ? $this->toEntity($model) : null;
  }

  public function save(Transacao $transacao): void
  {
    $model = $transacao->getId()
      ? TransacaoModel::findOrFail($transacao->getId())
      : new TransacaoModel();

    $model->wallet_id      = $transacao->getWalletId();
    $model->asset_id       = $transacao->getAssetId();
    $model->tipo           = $transacao->getTipo();
    $model->quantidade     = $transacao->getQuantidade();
    $model->preco_unitario = $transacao->getPrecoUnitario();
    $model->data           = $transacao->getData()->format('Y-m-d');
    $model->save();

    if (!$transacao->getId()) {
      $transacao->setId($model->id);
    }
  }

  public function delete(int $id): void
  {
    TransacaoModel::findOrFail($id)->delete();
  }

  private function toArray(TransacaoModel $model): array
  {
    return [
      'id'             => $model->id,
      'wallet_id'      => $model->wallet_id,
      'asset_id'       => $model->asset_id,
      'ticker'         => $model->asset?->ticker,
      'nome'           => $model->asset?->name,
      'tipo'           => $model->tipo,
      'quantidade'     => $model->quantidade,
      'preco_unitario' => $model->preco_unitario,
      'valor_total'    => $model->quantidade * $model->preco_unitario,
      'data'           => $model->data,
    ];
  }

  private function toEntity(TransacaoModel $model): Transacao
  {
    return new Transacao(
      (int) $model->id,
      (int) $model->wallet_id,
      (int) $model->asset_id,
      $model->tipo,
      (float) $model->quantidade,
      (float) $model->preco_unitario,
      new DateTime($model->data)
    );
  }
}
