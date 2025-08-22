<?php

namespace App\Application\Services;

use App\Domain\Entities\AssetType;
use App\Domain\Repositories\AssetTypeRepositoryInterface;
use DateTime;

class AssetTypeService
{
  private AssetTypeRepositoryInterface $repository;

  public function __construct(AssetTypeRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function listarTodos(): array
  {
    return $this->repository->findAll();
  }

  public function buscarPorId(int $id): ?AssetType
  {
    return $this->repository->findById($id);
  }

  public function criar(string $nome, ?string $descricao): AssetType
  {
    $assetType = new AssetType(
      0,
      $nome,
      $descricao,
      new DateTime(),
      new DateTime()
    );

    $this->repository->save($assetType);
    return $assetType;
  }

  public function atualizar(int $id, string $nome, ?string $descricao): ?AssetType
  {
    $assetType = $this->repository->findById($id);

    if (!$assetType) {
      return null;
    }

    $assetType = new AssetType(
      $id,
      $nome,
      $descricao,
      $assetType->getCreatedAt(),
      new DateTime()
    );

    $this->repository->save($assetType);
    return $assetType;
  }

  public function excluir(int $id): void
  {
    $this->repository->delete($id);
  }
}
