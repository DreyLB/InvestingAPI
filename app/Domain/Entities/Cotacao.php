<?php

namespace App\Domain\Entities;

use DateTimeImmutable;
use InvalidArgumentException;

class Cotacao
{
  public function __construct(
    private readonly string $ticker,
    private readonly string $tipo,       // 'acao' | 'cripto' | 'indice'
    private readonly float $valor,
    private readonly DateTimeImmutable $atualizadoEm,
    private readonly ?int $id = null,
  ) {
    if ($valor < 0) {
      throw new InvalidArgumentException("Valor da cotação não pode ser negativo.");
    }

    if (!in_array($tipo, ['acao', 'cripto', 'indice'], true)) {
      throw new InvalidArgumentException("Tipo de cotação inválido: {$tipo}");
    }
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTicker(): string
  {
    return $this->ticker;
  }

  public function getTipo(): string
  {
    return $this->tipo;
  }

  public function getValor(): float
  {
    return $this->valor;
  }

  public function getAtualizadoEm(): DateTimeImmutable
  {
    return $this->atualizadoEm;
  }

  public function estaDesatualizada(int $minutosLimite = 15): bool
  {
    $agora = new DateTimeImmutable();
    $diffMinutos = ($agora->getTimestamp() - $this->atualizadoEm->getTimestamp()) / 60;

    return $diffMinutos > $minutosLimite;
  }
}
