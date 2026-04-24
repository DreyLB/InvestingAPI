<?php
// app/Domain/Repositories/AssetRepositoryInterface.php

namespace App\Domain\Repositories;

use App\Domain\Entities\Ativo;

interface AtivoRepositoryInterface
{
    public function findById(int $id): ?Ativo;
    public function findByTicker(string $ticker): array;
    public function listarTodos(): array;
    public function save(Ativo $ativo): void;
}