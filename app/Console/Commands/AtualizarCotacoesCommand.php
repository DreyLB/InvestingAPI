<?php

namespace App\Console\Commands;

use App\Application\Services\CotacaoService;
use App\Domain\Repositories\AtivoRepositoryInterface;
use App\Domain\Repositories\PositionRepositoryInterface;
use App\Infrastructure\Providers\BrapiProvider;
use Illuminate\Console\Command;

class AtualizarCotacoesCommand extends Command
{
  protected $signature = 'cotacoes:atualizar {--catalogo : Atualiza todos os ativos do catálogo (Ações e FIIs), em vez de só os ativos em carteira}';

  public function handle(
    CotacaoService $service,
    BrapiProvider $brapi,
    PositionRepositoryInterface $positionRepository,
    AtivoRepositoryInterface $ativoRepository,
  ): void {
    $tickers = $this->option('catalogo')
      ? $this->tickersDoCatalogo($ativoRepository)
      : $positionRepository->listarTickersEmUso();

    if (empty($tickers)) {
      $this->info('Nenhum ativo encontrado.');
      return;
    }

    $this->info(sprintf('Atualizando cotação de %d ativo(s)...', count($tickers)));

    $processados = 0;
    foreach (array_chunk($tickers, 100) as $indice => $lote) {
      $service->atualizarCotacoes($brapi, $lote);
      $processados += count($lote);
      $this->info(sprintf('Lote %d concluído (%d/%d ativos processados).', $indice + 1, $processados, count($tickers)));
    }

    $this->info('Cotações atualizadas com sucesso.');
  }

  private function tickersDoCatalogo(AtivoRepositoryInterface $ativoRepository): array
  {
    $tickers = array_map(
      fn(array $ativo) => $ativo['ticker'],
      array_filter(
        $ativoRepository->listarTodos(),
        fn(array $ativo) => in_array($ativo['tipo_nome'], ['Ações', 'FIIs'], true),
      ),
    );

    return array_values(array_unique($tickers));
  }
}