<?php

namespace App\Application\Services;

use App\Domain\Repositories\IndicadorMercadoRepositoryInterface;
use App\Infrastructure\Providers\HgBrasilProvider;
use DateTimeImmutable;

class IndicadorMercadoService
{
  public function __construct(
    private IndicadorMercadoRepositoryInterface $indicadorMercadoRepository,
  ) {}

  public function atualizar(HgBrasilProvider $provider): void
  {
    $indicadores = $provider->buscarIndicadoresMercado();

    foreach ($indicadores as $chave => $dados) {
      $this->indicadorMercadoRepository->salvar($chave, $dados['nome'], $dados['valor'], new DateTimeImmutable());
    }
  }

  /**
   * @return array<int, array{chave: string, nome: string, valor: float, atualizado_em: string}>
   */
  public function listarTodos(): array
  {
    return array_map(
      fn($indicador) => [
        'chave' => $indicador->getChave(),
        'nome' => $indicador->getNome(),
        'valor' => $indicador->getValor(),
        'atualizado_em' => $indicador->getAtualizadoEm()->format('Y-m-d H:i:s'),
      ],
      $this->indicadorMercadoRepository->buscarTodos(),
    );
  }
}
