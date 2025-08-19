<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Carteira;
use App\Domain\Repositories\CarteiraRepositoryInterface;
use App\Infrastructure\Persistence\Models\CarteiraModel;
use Illuminate\Support\Facades\Auth;


class CarteiraRepository implements CarteiraRepositoryInterface
{
  public function findById(int $id): ?Carteira
  {
    $model = CarteiraModel::find($id);
    return $model ? $this->mapToEntity($model) : null;
  }

  public function findAll(): array
  {
    return CarteiraModel::all()
      ->map(fn($model) => $this->mapToEntity($model))
      ->toArray();
  }

  public function save(Carteira $carteira): void
  {
    $model = $carteira->getId() ? CarteiraModel::find($carteira->getId()) : new CarteiraModel();
    if (!$carteira->getId()) {
      $model->user_id = Auth::id();
    }
    $model->nome = $carteira->getNome();
    $model->descricao = $carteira->getDescricao();
    $model->save();
  }

  public function delete(int $id): void
  {
    $model = CarteiraModel::find($id);
    if ($model) {
      $model->delete();
    }
  }
  public function findByUserId(int $userId): array
  {
    return CarteiraModel::where('user_id', $userId)
      ->get()
      ->map(fn($model) => $this->mapToEntity($model))
      ->toArray();
  }

  public function findByIdAndUserId(int $id, int $userId): ?Carteira
  {
    $model = CarteiraModel::where('id', $id)
      ->where('user_id', $userId)
      ->first();

    if (!$model) return null;

    return new Carteira(
      $model->id,
      $model->usuario_id,
      $model->nome,
      $model->descricao
    );
  }

  private function mapToEntity(CarteiraModel $model): Carteira
  {
    return new Carteira(
      $model->id,
      $model->user_id,
      $model->nome,
      $model->descricao
    );
  }

  public function restore(int $id): void
  {
    $model = CarteiraModel::withTrashed()->find($id);
    if ($model && $model->trashed()) {
      $model->restore();
    }
  }
}
