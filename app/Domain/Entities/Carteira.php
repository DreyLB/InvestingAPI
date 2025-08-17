<?php

namespace App\Domain\Entities;

class Carteira implements \JsonSerializable
{
  private ?int $id;
  private ?int $user_id;
  private string $nome;
  private string $descricao;


  public function __construct(
    ?int $id,
    ?int $user_id,
    string $nome,
    string $descricao
  ) {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->nome = $nome;
    $this->descricao = $descricao;
  }

  public function jsonSerialize(): array
  {
    return [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'nome' => $this->nome,
      'descricao' => $this->descricao,
    ];
  }

  // Getter e Setter para id
  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  // Getter e Setter para user_id
  public function getUserId(): ?int
  {
    return $this->user_id;
  }

  public function setUserId(?int $user_id): void
  {
    $this->user_id = $user_id;
  }

  // Getter e Setter para nome
  public function getNome(): string
  {
    return $this->nome;
  }

  public function setNome(string $nome): void
  {
    $this->nome = $nome;
  }

  // Getter e Setter para descricao
  public function getDescricao(): string
  {
    return $this->descricao;
  }

  public function setDescricao(string $descricao): void
  {
    $this->descricao = $descricao;
  }
}
