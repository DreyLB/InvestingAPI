<?php
// app/Infrastructure/Persistence/IndicadorMercadoRepository.php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\IndicadorMercado;
use App\Domain\Repositories\IndicadorMercadoRepositoryInterface;
use App\Infrastructure\Persistence\Models\IndicadorMercadoModel;
use DateTimeImmutable;

class IndicadorMercadoRepository implements IndicadorMercadoRepositoryInterface
{
  public function salvar(string $chave, string $nome, float $valor, DateTimeImmutable $atualizadoEm): void
  {
    IndicadorMercadoModel::updateOrCreate(
      ['chave' => $chave],
      ['nome' => $nome, 'valor' => $valor, 'atualizado_em' => $atualizadoEm]
    );
  }

  public function buscarPorChave(string $chave): ?IndicadorMercado
  {
    $model = IndicadorMercadoModel::where('chave', $chave)->first();

    return $model ? $this->toEntity($model) : null;
  }

  public function buscarTodos(): array
  {
    return IndicadorMercadoModel::all()
      ->map(fn($model) => $this->toEntity($model))
      ->all();
  }

  private function toEntity(IndicadorMercadoModel $model): IndicadorMercado
  {
    return new IndicadorMercado(
      chave: $model->chave,
      nome: $model->nome,
      valor: $model->valor,
      atualizadoEm: DateTimeImmutable::createFromMutable($model->atualizado_em),
      id: $model->id,
    );
  }
}
