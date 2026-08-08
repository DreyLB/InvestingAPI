<?php

namespace App\Application\Services;

use App\Domain\Repositories\CotacaoRepositoryInterface;
use App\Infrastructure\Providers\MarketDataProviderInterface;
use DateTimeImmutable;

class CotacaoService
{
  public function __construct(
    private CotacaoRepositoryInterface $cotacaoRepository,
  ) {}

  public function atualizarCotacoesAcoes(MarketDataProviderInterface $provider, array $tickers): void
  {
    $cotacoes = $provider->buscarCotacoes($tickers);

    foreach ($cotacoes as $ticker => $valor) {
      $this->cotacaoRepository->salvar($ticker, 'acao', $valor, new DateTimeImmutable());
    }
  }

  public function atualizarCotacoesCripto(MarketDataProviderInterface $provider, array $ids): void
  {
    $cotacoes = $provider->buscarCotacoes($ids);

    foreach ($cotacoes as $id => $valor) {
      $this->cotacaoRepository->salvar($id, 'cripto', $valor, new DateTimeImmutable());
    }
  }
}
