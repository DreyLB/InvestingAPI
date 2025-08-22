<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Ativo;

interface AtivoRepositoryInterface
{
    public function save(Ativo $ativo): void; 
    public function listarPorCarteira(int $carteiraId): array;
    public function findByIdAndCarteira(int $id, int $carteiraId): ?Ativo;
    public function delete(int $id, int $carteiraId): void;
}
