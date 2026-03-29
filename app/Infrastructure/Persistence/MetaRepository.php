<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Meta;
use App\Domain\Repositories\MetaRepositoryInterface;
use App\Infrastructure\Persistence\Models\MetaModel;
use DateTime;

class MetaRepository implements MetaRepositoryInterface
{
  public function listarPorCarteira(int $carteiraId): array
  {
    return MetaModel::where('wallet_id', $carteiraId)
      ->orderBy('data_limite', 'asc')
      ->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function findById(int $id): ?Meta
  {
    $model = MetaModel::find($id);
    return $model ? $this->toEntity($model) : null;
  }

  public function save(Meta $meta, int $carteiraId): void
  {
    $model = $meta->getId()
      ? MetaModel::findOrFail($meta->getId())
      : new MetaModel();

    $model->wallet_id   = $carteiraId;
    $model->nome        = $meta->getNome();
    $model->descricao   = $meta->getDescricao();
    $model->valor       = $meta->getValor();
    $model->data_limite = $meta->getDataLimite()?->format('Y-m-d');
    $model->save();

    if (!$meta->getId()) {
      $meta->setId($model->id);
    }
  }

  public function delete(int $id): void
  {
    MetaModel::findOrFail($id)->delete();
  }

  private function toArray(MetaModel $model): array
  {
    return [
      'id'          => $model->id,
      'wallet_id'   => $model->wallet_id,
      'nome'        => $model->nome,
      'descricao'   => $model->descricao,
      'valor'       => $model->valor,
      'data_limite' => $model->data_limite,
      'created_at'  => $model->created_at,
      'updated_at'  => $model->updated_at,
    ];
  }

  private function toEntity(MetaModel $model): Meta
  {
    return new Meta(
      (int) $model->id,
      $model->nome,
      $model->descricao ?? '',
      (float) $model->valor,
      $model->data_limite ? new DateTime($model->data_limite) : new DateTime()
    );
  }
}
