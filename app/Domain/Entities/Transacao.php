<?php

namespace App\Domain\Entities;

use DateTime;

class Transacao
{
  private ?int $id;
  private string $tipo;
  private int $quantidade;
  private float $valor;
  private DateTime $data;

  public function __construct(
    ?int $id,
    string $tipo,
    int $quantidade,
    float $valor,
    DateTime $data
  ) {
    $this->id = $id;
    $this->tipo = $tipo;
    $this->quantidade = $quantidade;
    $this->valor = $valor;
    $this->data = $data;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  public function getTipo(): string
  {
    return $this->tipo;
  }

  public function setTipo(string $tipo): void
  {
    $this->tipo = $tipo;
  }

  public function getQuantidade(): int
  {
    return $this->quantidade;
  }

  public function setQuantidade(int $quantidade): void
  {
    $this->quantidade = $quantidade;
  }

  public function getValor(): float
  {
    return $this->valor;
  }

  public function setValor(float $valor): void
  {
    $this->valor = $valor;
  }

  public function getData(): DateTime
  {
    return $this->data;
  }

  public function setData(DateTime $data): void
  {
    $this->data = $data;
  }
}
