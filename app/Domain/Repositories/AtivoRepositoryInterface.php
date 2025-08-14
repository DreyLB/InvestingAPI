<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Ativo;

interface AtivoRepositoryInterface
{
    public function findById(int $id): ?Ativo;
    public function findAll(): array;
    public function save(Ativo $ativo): void;
    public function delete(int $id): void;
}
