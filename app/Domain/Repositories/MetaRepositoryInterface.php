<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Meta;

interface MetaRepositoryInterface
{
    public function listarPorCarteira(int $carteiraId): array;
    public function findById(int $id): ?Meta;
    public function save(Meta $meta, int $carteiraId): void;
    public function delete(int $id): void;
}
