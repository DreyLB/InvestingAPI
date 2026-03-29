<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Rendimento;
use App\Domain\Repositories\RendimentoRepositoryInterface;
use App\Infrastructure\Persistence\Models\RendimentoModel;
use DateTime;

class RendimentoRepository implements RendimentoRepositoryInterface
{
  public function listarPorCarteira(int $carteiraId): array
  {
    return RendimentoModel::where('wallet_id', $carteiraId)
      ->orderBy('periodo_ini', 'desc')
      ->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function findById(int $id): ?Rendimento
  {
    $model = RendimentoModel::find($id);
    return $model ? $this->toEntity($model) : null;
  }

  public function save(Rendimento $rendimento, int $carteiraId): void
  {
    $model = $rendimento->getId()
      ? RendimentoModel::findOrFail($rendimento->getId())
      : new RendimentoModel();

    $model->wallet_id    = $carteiraId;
    $model->rendimento   = $rendimento->getType();
    $model->valor        = $rendimento->getValor();
    $model->periodo_ini  = $rendimento->getPeriodoInicial()?->format('Y-m-d');
    $model->periodo_fim  = $rendimento->getPeriodoFinal()?->format('Y-m-d');
    $model->save();

    if (!$rendimento->getId()) {
      $rendimento->setId($model->id);
    }
  }

  public function delete(int $id): void
  {
    RendimentoModel::findOrFail($id)->delete();
  }

  private function toArray(RendimentoModel $model): array
  {
    return [
      'id'          => $model->id,
      'wallet_id'   => $model->wallet_id,
      'rendimento'  => $model->rendimento,
      'valor'       => $model->valor,
      'periodo_ini' => $model->periodo_ini,
      'periodo_fim' => $model->periodo_fim,
      'created_at'  => $model->created_at,
      'updated_at'  => $model->updated_at,
    ];
  }

  private function toEntity(RendimentoModel $model): Rendimento
  {
    return new Rendimento(
      (int) $model->id,
      $model->rendimento,
      $model->periodo_ini ? new DateTime($model->periodo_ini) : null,
      $model->periodo_fim ? new DateTime($model->periodo_fim) : null,
    );
  }
}
