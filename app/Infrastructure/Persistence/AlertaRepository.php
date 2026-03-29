<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Alerta;
use App\Domain\Repositories\AlertaRepositoryInterface;
use App\Infrastructure\Persistence\Models\AlertaModel;
use DateTime;

class AlertaRepository implements AlertaRepositoryInterface
{
  public function listarPorCarteira(int $carteiraId, ?bool $lido = null): array
  {
    $query = AlertaModel::where('wallet_id', $carteiraId)
      ->orderBy('data', 'desc');

    // Filtro opcional por lido/não lido
    if (!is_null($lido)) {
      $query->where('lido', $lido);
    }

    return $query->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function findById(int $id): ?Alerta
  {
    $model = AlertaModel::find($id);
    return $model ? $this->toEntity($model) : null;
  }

  public function save(Alerta $alerta): void
  {
    $model = $alerta->getId()
      ? AlertaModel::findOrFail($alerta->getId())
      : new AlertaModel();

    $model->wallet_id = $alerta->getWalletId();
    $model->tipo      = $alerta->getTipo();
    $model->mensagem  = $alerta->getMensagem();
    $model->data      = $alerta->getData()->format('Y-m-d');
    $model->lido      = $alerta->isLido();
    $model->save();

    if (!$alerta->getId()) {
      $alerta->setId($model->id);
    }
  }

  public function marcarComoLido(int $id): void
  {
    AlertaModel::findOrFail($id)->update(['lido' => true]);
  }

  public function delete(int $id): void
  {
    AlertaModel::findOrFail($id)->delete();
  }

  private function toArray(AlertaModel $model): array
  {
    return [
      'id'        => $model->id,
      'wallet_id' => $model->wallet_id,
      'tipo'      => $model->tipo,
      'mensagem'  => $model->mensagem,
      'data'      => $model->data,
      'lido'      => $model->lido,
      'created_at' => $model->created_at,
      'updated_at' => $model->updated_at,
    ];
  }

  private function toEntity(AlertaModel $model): Alerta
  {
    return new Alerta(
      (int) $model->id,
      (int) $model->wallet_id,
      $model->tipo,
      $model->mensagem,
      new DateTime($model->data),
      (bool) $model->lido
    );
  }
}
