<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Ativo;
use App\Domain\Repositories\AtivoRepositoryInterface;
use App\Infrastructure\Persistence\Models\AtivoModel;
use DateTime;
use Illuminate\Support\Facades\Auth;

class AtivoRepository implements AtivoRepositoryInterface
{
  public function save(Ativo $ativo): void
  {
    $model = $ativo->getId()
      ? AtivoModel::where('id', $ativo->getId())
      ->where('wallet_id', $ativo->getCarteiraId())
      ->firstOrFail()
      : new AtivoModel();

    if (! $ativo->getId()) {
      $model->wallet_id = $ativo->getCarteiraId();
    }

    $model->category_id    = $ativo->getCategoriaId();
    $model->asset_type_id  = $ativo->getTipoId();
    $model->name           = $ativo->getNome();
    $model->quantity       = $ativo->getQuantidade();
    $model->price          = $ativo->getPreco();
    $model->average_price  = $ativo->getPrecoMedio();
    $model->save();

    // opcionalmente, atualize o ID dentro da entidade (se ela tiver setId)
    if (method_exists($ativo, 'setId') && ! $ativo->getId()) {
      $ativo->setId((int) $model->id);
    }
  }

  public function listarPorCarteira(int $carteiraId): array
  {
    $models = AtivoModel::where('wallet_id', $carteiraId)->get();

    return $models->map(fn($m) => $this->toEntity($m))->toArray();
  }

  public function findByIdAndCarteira(int $id, int $carteiraId): ?Ativo
  {
    $model = AtivoModel::where('id', $id)
      ->where('wallet_id', $carteiraId)
      ->first();

    return $model ? $this->toEntity($model) : null;
  }

  public function delete(int $id, int $carteiraId): void
  {
    AtivoModel::where('id', $id)
      ->where('wallet_id', $carteiraId)
      ->delete();
  }

  private function toEntity(AtivoModel $model): Ativo
  {
    return new Ativo(
      (int) $model->id,
      (int) $model->wallet_id,
      $model->category_id ? (int) $model->category_id : null,
      (string) $model->name,
      (int) $model->asset_type_id,             // <- tipo_id no domínio
      (float) $model->quantity,
      (float) $model->price,
      (float) $model->average_price,
      new DateTime($model->created_at),
      new DateTime($model->updated_at)
    );
  }
}
