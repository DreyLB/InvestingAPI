<?php

namespace App\Domain\Entities;

use JsonSerializable;
use DateTime;

class AssetType implements JsonSerializable
{
  private int $id;
  private string $nome;
  private ?string $descricao;
  private DateTime $createdAt;
  private DateTime $updatedAt;

  public function __construct(
    int $id,
    string $nome,
    ?string $descricao,
    DateTime $createdAt,
    DateTime $updatedAt
  ) {
    $this->id = $id;
    $this->nome = $nome;
    $this->descricao = $descricao;
    $this->createdAt = $createdAt;
    $this->updatedAt = $updatedAt;
  }

  public function getId(): int
  {
    return $this->id;
  }
  public function getNome(): string
  {
    return $this->nome;
  }
  public function getDescricao(): ?string
  {
    return $this->descricao;
  }
  public function getCreatedAt(): DateTime
  {
    return $this->createdAt;
  }
  public function getUpdatedAt(): DateTime
  {
    return $this->updatedAt;
  }

  public function jsonSerialize(): mixed
  {
    return [
      'id'        => $this->id,
      'nome'      => $this->nome,
      'descricao' => $this->descricao,
      'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
      'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
    ];
  }
}
