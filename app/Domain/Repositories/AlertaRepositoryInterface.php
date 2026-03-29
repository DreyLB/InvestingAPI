<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Alerta;

interface AlertaRepositoryInterface
{
    public function listarPorCarteira(int $carteiraId, ?bool $lido): array;
    public function findById(int $id): ?Alerta;
    public function save(Alerta $alerta): void;
    public function marcarComoLido(int $id): void;
    public function delete(int $id): void;
}
