<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Cotacao;

interface CotacaoRepositoryInterface
{
  public function salvar(string $ticker, string $tipo, float $valor, \DateTimeImmutable $atualizadoEm): void;

  public function buscarPorTicker(string $ticker, string $tipo): ?Cotacao;

  /**
   * @return Cotacao[]
   */
  public function buscarPorTipo(string $tipo): array;

  /**
   * @param string[] $tickers
   * @return Cotacao[]
   */
  public function buscarPorTickers(array $tickers, string $tipo): array;
}
