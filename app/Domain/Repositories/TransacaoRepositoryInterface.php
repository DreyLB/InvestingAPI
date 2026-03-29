<?php
// app/Domain/Repositories/TransacaoRepositoryInterface.php

namespace App\Domain\Repositories;

use App\Domain\Entities\Transacao;

interface TransacaoRepositoryInterface
{
    public function listarPorAtivo(int $ativoId): array;
    public function listarPorCarteira(int $carteiraId): array;
    public function findById(int $id): ?Transacao;
    public function save(Transacao $transacao, int $ativoId): void;
    public function delete(int $id): void;
}
