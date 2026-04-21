<?php

namespace App\Domain\Entities;

use DateTime;
use JsonSerializable;

class Transacao implements JsonSerializable
{
  public function __construct(
    private ?int $id,
    private int $walletId,
    private int $assetId,
    private string $tipo,
    private float $quantidade,
    private float $precoUnitario,
    private DateTime $data
  ) {}

  public function getId(): ?int
  {
    return $this->id;
  }
  public function setId(int $id): void
  {
    $this->id = $id;
  }

  public function getWalletId(): int
  {
    return $this->walletId;
  }
  public function getAssetId(): int
  {
    return $this->assetId;
  }

  public function getTipo(): string
  {
    return $this->tipo;
  }
  public function getQuantidade(): float
  {
    return $this->quantidade;
  }
  public function getPrecoUnitario(): float
  {
    return $this->precoUnitario;
  }
  public function getValorTotal(): float
  {
    return $this->quantidade * $this->precoUnitario;
  }
  public function getData(): DateTime
  {
    return $this->data;
  }

  public function jsonSerialize(): mixed
  {
    return [
      'id'             => $this->id,
      'wallet_id'      => $this->walletId,
      'asset_id'       => $this->assetId,
      'tipo'           => $this->tipo,
      'quantidade'     => $this->quantidade,
      'preco_unitario' => $this->precoUnitario,
      'valor_total'    => $this->getValorTotal(),
      'data'           => $this->data->format('Y-m-d'),
    ];
  }
}
