<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Categoria;

interface CategoriaRepositoryInterface
{
    public function listarTodas(): array;
    public function findById(int $id): ?Categoria;
    public function save(Categoria $categoria): void;
    public function delete(int $id): void;
}
