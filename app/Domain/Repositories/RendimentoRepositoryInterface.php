<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Rendimento;

interface RendimentoRepositoryInterface
{
    public function listarPorCarteira(int $carteiraId): array;
    public function findById(int $id): ?Rendimento;
    public function save(Rendimento $rendimento, int $carteiraId): void;
    public function delete(int $id): void;
}
