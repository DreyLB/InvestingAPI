<?php

namespace App\Application\Services;

use App\Domain\Repositories\AtivoRepositoryInterface;
use App\Domain\Repositories\CotacaoRepositoryInterface;
use App\Infrastructure\Providers\MarketDataProviderInterface;
use DateTimeImmutable;

class CotacaoService
{
  public function __construct(
    private CotacaoRepositoryInterface $cotacaoRepository,
    private AtivoRepositoryInterface $ativoRepository,
  ) {}

  public function atualizarCotacoes(MarketDataProviderInterface $provider, array $tickers): void
  {
    $cotacoes = $provider->buscarCotacoes($tickers);

    foreach ($cotacoes as $ticker => $valor) {
      $ativo = $this->ativoRepository->findByTickerExato($ticker);

      if (!$ativo) {
        continue;
      }

      $this->cotacaoRepository->salvar($ativo->getId(), $valor, new DateTimeImmutable());
    }
  }
}
