<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\IndicadorMercado;

interface IndicadorMercadoRepositoryInterface
{
  public function salvar(string $chave, string $nome, float $valor, ?float $variacaoPercentual, \DateTimeImmutable $atualizadoEm): void;

  public function buscarPorChave(string $chave): ?IndicadorMercado;

  /**
   * @return IndicadorMercado[]
   */
  public function buscarTodos(): array;
}
