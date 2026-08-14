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
      $this->indicadorMercadoRepository->salvar(
        $chave,
        $dados['nome'],
        $dados['valor'],
        $dados['variacaoPercentual'] ?? null,
        new DateTimeImmutable(),
      );
    }
  }

  /**
   * @return array<int, array{chave: string, nome: string, valor: float, variacao_percentual: ?float, atualizado_em: string}>
   */
  public function listarTodos(): array
  {
    return array_map(
      fn($indicador) => [
        'chave' => $indicador->getChave(),
        'nome' => $indicador->getNome(),
        'valor' => $indicador->getValor(),
        'variacao_percentual' => $indicador->getVariacaoPercentual(),
        'atualizado_em' => $indicador->getAtualizadoEm()->format('Y-m-d H:i:s'),
      ],
      $this->indicadorMercadoRepository->buscarTodos(),
    );
  }
}
