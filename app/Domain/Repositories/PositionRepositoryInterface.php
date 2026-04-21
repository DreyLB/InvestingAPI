<?php
// app/Domain/Repositories/PositionRepositoryInterface.php

namespace App\Domain\Repositories;

use App\Domain\Entities\Position;

interface PositionRepositoryInterface
{
  public function listarPorCarteira(int $walletId): array;
  public function findByWalletAndAsset(int $walletId, int $assetId): ?Position;
  public function save(Position $position): void;
  public function delete(int $id): void;
}
