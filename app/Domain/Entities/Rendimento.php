<?php

namespace App\Domain\Entities;

use DateTime;
use JsonSerializable;

class Rendimento implements JsonSerializable
{
  private ?int $id;
  private string $type;
  private float $valor;
  private ?DateTime $periodoInicial;
  private ?DateTime $periodoFinal;

  public function __construct(
    ?int $id,
    string $type,
    float $valor,
    ?DateTime $periodoInicial,
    ?DateTime $periodoFinal
  ) {
    $this->id             = $id;
    $this->type           = $type;
    $this->valor          = $valor;
    $this->periodoInicial = $periodoInicial;
    $this->periodoFinal   = $periodoFinal;
  }

  public function getId(): ?int
  {
    return $this->id;
  }
  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  public function getType(): string
  {
    return $this->type;
  }
  public function setType(string $type): void
  {
    $this->type = $type;
  }

  public function getValor(): float
  {
    return $this->valor;
  }
  public function setValor(float $valor): void
  {
    $this->valor = $valor;
  }

  public function getPeriodoInicial(): ?DateTime
  {
    return $this->periodoInicial;
  }
  public function setPeriodoInicial(?DateTime $periodoInicial): void
  {
    $this->periodoInicial = $periodoInicial;
  }

  public function getPeriodoFinal(): ?DateTime
  {
    return $this->periodoFinal;
  }
  public function setPeriodoFinal(?DateTime $periodoFinal): void
  {
    $this->periodoFinal = $periodoFinal;
  }

  public function jsonSerialize(): mixed
  {
    return [
      'id'          => $this->id,
      'rendimento'  => $this->type,
      'valor'       => $this->valor,
      'periodo_ini' => $this->periodoInicial?->format('Y-m-d'),
      'periodo_fim' => $this->periodoFinal?->format('Y-m-d'),
    ];
  }
}
