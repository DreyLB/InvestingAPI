<?php

namespace App\Domain\Entities;

use JsonSerializable;

class Position implements JsonSerializable
{
  public function __construct(
    private ?int $id,
    private int $walletId,
    private int $assetId,
    private float $quantidade,
    private float $precoMedio,
    private float $valorTotal,
    private ?string $ticker = null,   // join
    private ?string $nome = null,     // join
    private ?string $tipoNome = null  // join
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

  public function getQuantidade(): float
  {
    return $this->quantidade;
  }
  public function setQuantidade(float $q): void
  {
    $this->quantidade = $q;
  }

  public function getPrecoMedio(): float
  {
    return $this->precoMedio;
  }
  public function setPrecoMedio(float $p): void
  {
    $this->precoMedio = $p;
  }

  public function getValorTotal(): float
  {
    return $this->valorTotal;
  }
  public function setValorTotal(float $v): void
  {
    $this->valorTotal = $v;
  }

  public function recalcularValorTotal(): void
  {
    $this->valorTotal = $this->quantidade * $this->precoMedio;
  }

  public function jsonSerialize(): mixed
  {
    return [
      'id'          => $this->id,
      'wallet_id'   => $this->walletId,
      'asset_id'    => $this->assetId,
      'ticker'      => $this->ticker,
      'nome'        => $this->nome,
      'tipo_nome'   => $this->tipoNome,
      'quantidade'  => $this->quantidade,
      'preco_medio' => $this->precoMedio,
      'valor_total' => $this->valorTotal,
    ];
  }
}
