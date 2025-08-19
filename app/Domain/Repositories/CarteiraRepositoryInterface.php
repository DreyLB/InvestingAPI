<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Carteira;

interface CarteiraRepositoryInterface
{
  public function findById(int $id): ?Carteira;
  public function findAll(): array;
  public function save(Carteira $carteira): void;
  public function delete(int $id): void;
  public function findByUserId(int $userId): array;
  public function findByIdAndUserId(int $id, int $userId): ?Carteira;
  public function restore(int $id): void;
}
