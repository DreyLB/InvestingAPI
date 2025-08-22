<?php

namespace App\Domain\Entities;

use JsonSerializable;
use DateTime;

class Ativo implements JsonSerializable
{
  private int $id;
  private int $tipo_id;
  private int $carteira_id;
  private ?int $categoria_id;
  private string $nome;
  private int $quantidade;
  private float $preco;
  private float $preco_medio;
  private DateTime $created_at;
  private DateTime $updated_at;

  public function __construct(
    ?int $id,
    int $carteira_id,
    ?int $categoria_id,
    string $nome,
    int $tipo_id,
    int $quantidade,
    float $preco,
    float $preco_medio,
    DateTime $created_at,
    DateTime $updated_at
  ) {
    $this->id = $id;
    $this->carteira_id = $carteira_id;
    $this->categoria_id = $categoria_id;
    $this->nome = $nome;
    $this->quantidade = $quantidade;
    $this->preco = $preco;
    $this->preco_medio = $preco_medio;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
    $this->tipo_id = $tipo_id;
  }

  // --- Getters ---
  public function getId(): int
  {
    return $this->id;
  }
  public function getCarteiraId(): int
  {
    return $this->carteira_id;
  }
  public function getCategoriaId(): ?int
  {
    return $this->categoria_id;
  }
  public function getNome(): string
  {
    return $this->nome;
  }
  public function getQuantidade(): int
  {
    return $this->quantidade;
  }
  public function getPreco(): float
  {
    return $this->preco;
  }
  public function getPrecoMedio(): float
  {
    return $this->preco_medio;
  }
  public function getCreatedAt(): DateTime
  {
    return $this->created_at;
  }
  public function getUpdatedAt(): DateTime
  {
    return $this->updated_at;
  }
  public function getTipoId(): int
  {
    return $this->tipo_id;
  }

  // --- Setters ---
  public function setCarteiraId(int $carteira_id): void
  {
    $this->carteira_id = $carteira_id;
  }
  public function setCategoriaId(?int $categoria_id): void
  {
    $this->categoria_id = $categoria_id;
  }
  public function setNome(string $nome): void
  {
    $this->nome = $nome;
  }
  public function setQuantidade(int $quantidade): void
  {
    $this->quantidade = $quantidade;
  }
  public function setPreco(float $preco): void
  {
    $this->preco = $preco;
  }
  public function setPrecoMedio(float $preco_medio): void
  {
    $this->preco_medio = $preco_medio;
  }
  public function setUpdatedAt(DateTime $updated_at): void
  {
    $this->updated_at = $updated_at;
  }
  public function setTipoId(int $tipo_id): void
  {
    $this->tipo_id = $tipo_id;
  }

  // --- Regra de negócio ---
  public function atualizarPrecoMedio(float $novoPreco, int $novaQuantidade): void
  {
    $totalAtual = $this->preco_medio * $this->quantidade;
    $totalNovo = $novoPreco * $novaQuantidade;
    $quantidadeTotal = $this->quantidade + $novaQuantidade;

    if ($quantidadeTotal > 0) {
      $this->preco_medio = ($totalAtual + $totalNovo) / $quantidadeTotal;
      $this->quantidade = $quantidadeTotal;
    }
  }

  // --- Para debug/json ---
  public function jsonSerialize(): mixed
  {
    return [
      'id' => $this->id,
      'carteira_id' => $this->carteira_id,
      'tipo_id' => $this->tipo_id,
      'categoria_id' => $this->categoria_id,
      'nome' => $this->nome,
      'quantidade' => $this->quantidade,
      'preco' => $this->preco,
      'preco_medio' => $this->preco_medio,
      'created_at' => $this->created_at->format('Y-m-d H:i:s'),
      'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
    ];
  }
}
