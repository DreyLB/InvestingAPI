<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Dividendo;

interface DividendoRepositoryInterface
{
    public function findById(int $id): ?Dividendo;
    public function findAll(): array;
    public function save(Dividendo $dividendo): void;
    public function delete(int $id): void;
}
