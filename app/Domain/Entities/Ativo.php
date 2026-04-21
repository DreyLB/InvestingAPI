<?php

namespace App\Domain\Entities;

use JsonSerializable;
use DateTime;

class Ativo implements JsonSerializable
{
  public function __construct(
    private ?int $id,
    private string $ticker,
    private string $nome,
    private int $assetTypeId,
    private ?int $categoriaId,
    private DateTime $createdAt,
    private DateTime $updatedAt
  ) {}

  public function getId(): ?int
  {
    return $this->id;
  }
  public function setId(int $id): void
  {
    $this->id = $id;
  }

  public function getTicker(): string
  {
    return $this->ticker;
  }
  public function setTicker(string $ticker): void
  {
    $this->ticker = $ticker;
  }

  public function getNome(): string
  {
    return $this->nome;
  }
  public function setNome(string $nome): void
  {
    $this->nome = $nome;
  }

  public function getAssetTypeId(): int
  {
    return $this->assetTypeId;
  }
  public function setAssetTypeId(int $id): void
  {
    $this->assetTypeId = $id;
  }

  public function getCategoriaId(): ?int
  {
    return $this->categoriaId;
  }
  public function setCategoriaId(?int $id): void
  {
    $this->categoriaId = $id;
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
      'id'            => $this->id,
      'ticker'        => $this->ticker,
      'nome'          => $this->nome,
      'asset_type_id' => $this->assetTypeId,
      'categoria_id'  => $this->categoriaId,
    ];
  }
}
