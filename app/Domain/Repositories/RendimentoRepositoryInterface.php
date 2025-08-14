<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Rendimento;

interface RendimentoRepositoryInterface
{
    public function findById(int $id): ?Rendimento;
    public function findAll(): array;
    public function save(Rendimento $rendimento): void;
    public function delete(int $id): void;
}
