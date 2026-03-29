<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Dividendo;

interface DividendoRepositoryInterface
{
    public function listarPorAtivo(int $ativoId): array;
    public function listarPorCarteira(int $carteiraId): array;
    public function findById(int $id): ?Dividendo;
    public function save(Dividendo $dividendo, int $ativoId): void;
    public function delete(int $id): void;
}
