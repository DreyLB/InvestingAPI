<?php

namespace App\Domain\Entities;

use DateTime;

class Rendimento
{
  private ?int $id;
  private string $type;
  private ?DateTime $periodoInicial;
  private ?DateTime $periodoFinal;

  public function __construct(
    ?int $id,
    string $type,
    ?DateTime $periodoInicial,
    ?DateTime $periodoFinal
  ) {
    $this->id = $id;
    $this->type = $type;
    $this->periodoInicial = $periodoInicial;
    $this->periodoFinal = $periodoFinal;
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
}
