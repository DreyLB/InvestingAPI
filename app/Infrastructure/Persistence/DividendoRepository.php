<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Dividendo;
use App\Domain\Repositories\DividendoRepositoryInterface;
use App\Infrastructure\Persistence\Models\DividendoModel;
use App\Infrastructure\Persistence\Models\PositionModel;
use DateTime;

class DividendoRepository implements DividendoRepositoryInterface
{
  public function listarPorAtivo(int $ativoId): array
  {
    return DividendoModel::where('asset_id', $ativoId)
      ->with('ativo:id,ticker,name')
      ->orderBy('data', 'desc')
      ->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function listarPorCarteira(int $carteiraId): array
  {
    $assetIds = PositionModel::where('wallet_id', $carteiraId)
      ->pluck('asset_id');

    return DividendoModel::whereIn('asset_id', $assetIds)
      ->with('ativo:id,ticker,name')
      ->orderBy('data', 'desc')
      ->get()
      ->map(fn($m) => $this->toArray($m))
      ->toArray();
  }

  public function findById(int $id): ?Dividendo
  {
    $model = DividendoModel::find($id);
    return $model ? $this->toEntity($model) : null;
  }

  public function save(Dividendo $dividendo, int $ativoId): void
  {
    $model = $dividendo->getId()
      ? DividendoModel::findOrFail($dividendo->getId())
      : new DividendoModel();

    $model->asset_id = $ativoId;
    $model->valor    = $dividendo->getValor();
    $model->data     = $dividendo->getPeriodoInicial()?->format('Y-m-d');
    $model->save();

    if (!$dividendo->getId()) {
      $dividendo->setId($model->id);
    }
  }

  public function delete(int $id): void
  {
    DividendoModel::findOrFail($id)->delete();
  }

  private function toArray(DividendoModel $model): array
  {
    return [
      'id'          => $model->id,
      'asset_id'    => $model->asset_id,
      'ticker'      => $model->ativo?->ticker,
      'ativo_nome'  => $model->ativo?->name,
      'valor'       => $model->valor,
      'data'        => $model->data,
      'created_at'  => $model->created_at,
      'updated_at'  => $model->updated_at,
    ];
  }

  private function toEntity(DividendoModel $model): Dividendo
  {
    return new Dividendo(
      (int) $model->id,
      new DateTime($model->data),
      (float) $model->valor
    );
  }
}