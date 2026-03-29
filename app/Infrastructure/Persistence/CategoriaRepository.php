<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Categoria;
use App\Domain\Repositories\CategoriaRepositoryInterface;
use App\Infrastructure\Persistence\Models\CategoriaModel;

class CategoriaRepository implements CategoriaRepositoryInterface
{
  public function listarTodas(): array
  {
    return CategoriaModel::all()
      ->map(fn($m) => $this->toEntity($m))
      ->toArray();
  }

  public function findById(int $id): ?Categoria
  {
    $model = CategoriaModel::find($id);
    return $model ? $this->toEntity($model) : null;
  }

  public function save(Categoria $categoria): void
  {
    $model = $categoria->getId()
      ? CategoriaModel::findOrFail($categoria->getId())
      : new CategoriaModel();

    $model->nome = $categoria->getNome();
    $model->descricao = $categoria->getDescricao();
    $model->save();

    if (!$categoria->getId()) {
      $categoria->setId($model->id);
    }
  }

  public function delete(int $id): void
  {
    CategoriaModel::findOrFail($id)->delete();
  }

  private function toEntity(CategoriaModel $model): Categoria
  {
    return new Categoria(
      (int) $model->id,
      $model->nome,
      $model->descricao ?? ''
    );
  }
}
