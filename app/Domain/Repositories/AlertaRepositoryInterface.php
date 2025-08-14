<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Alerta;

interface AlertaRepositoryInterface
{
    public function findById(int $id): ?Alerta;
    public function findAll(): array;
    public function save(Alerta $alerta): void;
    public function delete(int $id): void;
}
