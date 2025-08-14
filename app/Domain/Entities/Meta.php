<?php

namespace App\Domain\Entities;

use DateTime;

class Meta
{
  private ?int $id;
  private string $nome;
  private string $descricao;
  private float $valor;
  private DateTime $dataLimite;

  public function __construct(
    ?int $id,
    string $nome,
    string $descricao,
    float $valor,
    DateTime $dataLimite
  ) {
    $this->id = $id;
    $this->nome = $nome;
    $this->descricao = $descricao;
    $this->valor = $valor;
    $this->dataLimite = $dataLimite;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  public function getNome(): string
  {
    return $this->nome;
  }

  public function setNome(string $nome): void
  {
    $this->nome = $nome;
  }

  public function getDescricao(): string
  {
    return $this->descricao;
  }

  public function setDescricao(string $descricao): void
  {
    $this->descricao = $descricao;
  }

  public function getValor(): float
  {
    return $this->valor;
  }

  public function setValor(float $valor): void
  {
    $this->valor = $valor;
  }

  public function getDataLimite(): DateTime
  {
    return $this->dataLimite;
  }

  public function setDataLimite(DateTime $dataLimite): void
  {
    $this->dataLimite = $dataLimite;
  }
}
