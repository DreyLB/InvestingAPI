<?php
// app/Infrastructure/Persistence/CotacaoRepository.php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Cotacao;
use App\Domain\Repositories\CotacaoRepositoryInterface;
use App\Infrastructure\Persistence\Models\CotacaoModel;
use DateTimeImmutable;

class CotacaoRepository implements CotacaoRepositoryInterface
{
  public function salvar(string $ticker, string $tipo, float $valor, DateTimeImmutable $atualizadoEm): void
  {
    CotacaoModel::updateOrCreate(
      ['ticker' => $ticker, 'tipo' => $tipo],
      ['valor' => $valor, 'atualizado_em' => $atualizadoEm]
    );
  }

  public function buscarPorTicker(string $ticker, string $tipo): ?Cotacao
  {
    $model = CotacaoModel::where('ticker', $ticker)
      ->where('tipo', $tipo)
      ->first();

    return $model ? $this->toEntity($model) : null;
  }

  public function buscarPorTipo(string $tipo): array
  {
    return CotacaoModel::where('tipo', $tipo)
      ->get()
      ->map(fn($model) => $this->toEntity($model))
      ->all();
  }

  public function buscarPorTickers(array $tickers, string $tipo): array
  {
    return CotacaoModel::whereIn('ticker', $tickers)
      ->where('tipo', $tipo)
      ->get()
      ->map(fn($model) => $this->toEntity($model))
      ->all();
  }

  private function toEntity(CotacaoModel $model): Cotacao
  {
    return new Cotacao(
      ticker: $model->ticker,
      tipo: $model->tipo,
      valor: $model->valor,
      atualizadoEm: DateTimeImmutable::createFromMutable($model->atualizado_em),
      id: $model->id,
    );
  }
}
