<?php

namespace App\Domain\Entities;

use DateTime;

class Dividendo
{
  private ?int $id;
  private ?DateTime $periodoInicial;
  private float $valor;

  public function __construct(?int $id, ?DateTime $periodoInicial, float $valor)
  {
    $this->id = $id;
    $this->periodoInicial = $periodoInicial;
    $this->valor = $valor;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  public function getPeriodoInicial(): ?DateTime
  {
    return $this->periodoInicial;
  }

  public function setPeriodoInicial(?DateTime $periodoInicial): void
  {
    $this->periodoInicial = $periodoInicial;
  }

  public function getValor(): float
  {
    return $this->valor;
  }

  public function setValor(float $valor): void
  {
    $this->valor = $valor;
  }
}
