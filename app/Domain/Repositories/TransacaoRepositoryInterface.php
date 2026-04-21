<?php
// app/Domain/Repositories/TransacaoRepositoryInterface.php

namespace App\Domain\Repositories;

use App\Domain\Entities\Transacao;

interface TransacaoRepositoryInterface
{
    public function listarPorCarteira(int $walletId): array;
    public function listarPorAsset(int $walletId, int $assetId): array;
    public function findById(int $id): ?Transacao;
    public function save(Transacao $transacao): void;
    public function delete(int $id): void;
}