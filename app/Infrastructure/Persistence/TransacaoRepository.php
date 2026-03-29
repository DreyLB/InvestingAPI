<?php
// app/Infrastructure/Persistence/TransacaoRepository.php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Transacao;
use App\Domain\Repositories\TransacaoRepositoryInterface;
use App\Infrastructure\Persistence\Models\TransacaoModel;
use DateTime;

class TransacaoRepository implements TransacaoRepositoryInterface
{
  public function listarPorAtivo(int $ativoId): array
  {
    return TransacaoModel::where('asset_id', $ativoId)
      ->orderBy('data', 'desc')
      ->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function listarPorCarteira(int $carteiraId): array
  {
    return TransacaoModel::whereHas(
      'ativo',
      fn($q) =>
      $q->where('wallet_id', $carteiraId)
    )
      ->with('ativo:id,name,wallet_id')
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

  public function save(Transacao $transacao, int $ativoId): void
  {
    $model = $transacao->getId()
      ? TransacaoModel::findOrFail($transacao->getId())
      : new TransacaoModel();

    $model->asset_id   = $ativoId;
    $model->tipo       = $transacao->getTipo();
    $model->quantidade = $transacao->getQuantidade();
    $model->valor      = $transacao->getValor();
    $model->data       = $transacao->getData()->format('Y-m-d');
    $model->save();

    if (!$transacao->getId()) {
      $transacao->setId($model->id);
    }
  }

  public function delete(int $id): void
  {
    TransacaoModel::findOrFail($id)->delete();
  }

  // Retorna array com nome do ativo junto — usado nas listagens
  private function toArray(TransacaoModel $model): array
  {
    return [
      'id'         => $model->id,
      'asset_id'   => $model->asset_id,
      'ativo_nome' => $model->ativo?->name,
      'tipo'       => $model->tipo,
      'quantidade' => $model->quantidade,
      'valor'      => $model->valor,
      'data'       => $model->data,
      'created_at' => $model->created_at,
      'updated_at' => $model->updated_at,
    ];
  }

  private function toEntity(TransacaoModel $model): Transacao
  {
    return new Transacao(
      (int) $model->id,
      $model->tipo,
      (int) $model->quantidade,
      (float) $model->valor,
      new DateTime($model->data)
    );
  }
}
