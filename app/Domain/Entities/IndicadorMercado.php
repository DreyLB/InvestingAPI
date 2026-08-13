<?php

namespace App\Domain\Entities;

use DateTimeImmutable;
use InvalidArgumentException;

class IndicadorMercado
{
  public function __construct(
    private readonly string $chave,
    private readonly string $nome,
    private readonly float $valor,
    private readonly ?float $variacaoPercentual,
    private readonly DateTimeImmutable $atualizadoEm,
    private readonly ?int $id = null,
  ) {
    if ($valor < 0) {
      throw new InvalidArgumentException("Valor do indicador não pode ser negativo.");
    }
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getChave(): string
  {
    return $this->chave;
  }

  public function getNome(): string
  {
    return $this->nome;
  }

  public function getValor(): float
  {
    return $this->valor;
  }

  public function getVariacaoPercentual(): ?float
  {
    return $this->variacaoPercentual;
  }

  public function getAtualizadoEm(): DateTimeImmutable
  {
    return $this->atualizadoEm;
  }
}
