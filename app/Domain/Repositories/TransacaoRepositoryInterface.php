<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Transacao;

interface TransacaoRepositoryInterface
{
    public function findById(int $id): ?Transacao;
    public function findAll(): array;
    public function save(Transacao $transacao): void;
    public function delete(int $id): void;
}
