<?php

namespace App\Domain\Entities;

class Ativo
{
  private ?int $id;
  private string $nome;
  private string $tipo;
  private float $valor;
  private float $precoMedio;
  private int $quantidade;

  public function __construct(
    ?int $id,
    string $nome,
    string $tipo,
    float $valor,
    float $precoMedio,
    int $quantidade
  ) {
    $this->id = $id;
    $this->nome = $nome;
    $this->tipo = $tipo;
    $this->valor = $valor;
    $this->precoMedio = $precoMedio;
    $this->quantidade = $quantidade;
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

  public function getTipo(): string
  {
    return $this->tipo;
  }

  public function setTipo(string $tipo): void
  {
    $this->tipo = $tipo;
  }

  public function getValor(): float
  {
    return $this->valor;
  }

  public function setValor(float $valor): void
  {
    $this->valor = $valor;
  }

  public function getPrecoMedio(): float
  {
    return $this->precoMedio;
  }

  public function setPrecoMedio(float $precoMedio): void
  {
    $this->precoMedio = $precoMedio;
  }

  public function getQuantidade(): int
  {
    return $this->quantidade;
  }

  public function setQuantidade(int $quantidade): void
  {
    $this->quantidade = $quantidade;
  }
}
