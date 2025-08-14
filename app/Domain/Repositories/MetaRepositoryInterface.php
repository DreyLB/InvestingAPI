<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Meta;

interface MetaRepositoryInterface
{
    public function findById(int $id): ?Meta;
    public function findAll(): array;
    public function save(Meta $meta): void;
    public function delete(int $id): void;
}
