<?php

namespace App\Domain\Entities;

use DateTime;
use JsonSerializable;

class Alerta implements JsonSerializable
{
  private ?int $id;
  private int $walletId;
  private string $tipo;
  private string $mensagem;
  private DateTime $data;
  private bool $lido;

  public function __construct(
    ?int $id,
    int $walletId,
    string $tipo,
    string $mensagem,
    DateTime $data,
    bool $lido = false
  ) {
    $this->id       = $id;
    $this->walletId = $walletId;
    $this->tipo     = $tipo;
    $this->mensagem = $mensagem;
    $this->data     = $data;
    $this->lido     = $lido;
  }

  public function getId(): ?int
  {
    return $this->id;
  }
  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  public function getWalletId(): int
  {
    return $this->walletId;
  }
  public function setWalletId(int $walletId): void
  {
    $this->walletId = $walletId;
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

  public function isLido(): bool
  {
    return $this->lido;
  }
  public function setLido(bool $lido): void
  {
    $this->lido = $lido;
  }

  public function jsonSerialize(): mixed
  {
    return [
      'id'        => $this->id,
      'wallet_id' => $this->walletId,
      'tipo'      => $this->tipo,
      'mensagem'  => $this->mensagem,
      'data'      => $this->data->format('Y-m-d'),
      'lido'      => $this->lido,
    ];
  }
}
