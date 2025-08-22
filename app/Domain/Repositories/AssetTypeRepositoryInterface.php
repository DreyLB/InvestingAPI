<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\AssetType;

interface AssetTypeRepositoryInterface
{
  public function save(AssetType $assetType): void;
  public function findAll(): array;
  public function findById(int $id): ?AssetType;
  public function delete(int $id): void;
}
