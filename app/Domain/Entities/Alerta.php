<?php

namespace App\Domain\Entities;

use DateTime;

class Alerta
{
  private ?int $id;
  private string $tipo;
  private string $mensagem;
  private DateTime $data;

  public function __construct(
    ?int $id,
    string $tipo,
    string $mensagem,
    DateTime $data
  ) {
    $this->id = $id;
    $this->tipo = $tipo;
    $this->mensagem = $mensagem;
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

  public function getMensagem(): string
  {
    return $this->mensagem;
  }

  public function setMensagem(string $mensagem): void
  {
    $this->mensagem = $mensagem;
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
