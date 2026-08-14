<?php

namespace App\Console\Commands;

use App\Application\Services\CotacaoService;
use App\Domain\Repositories\CarteiraRepositoryInterface;
use App\Domain\Repositories\PositionRepositoryInterface;
use App\Infrastructure\Providers\BrapiProvider;
use Illuminate\Console\Command;

class AtualizarCotacoesCommand extends Command
{
  protected $signature = 'cotacoes:atualizar';

  public function handle(
    CotacaoService $service,
    BrapiProvider $brapi,
    CarteiraRepositoryInterface $carteiraRepository,
    PositionRepositoryInterface $positionRepository,
  ): void {
    $userId = 1;

    $tickers = [];
    foreach ($carteiraRepository->findByUserId($userId) as $carteira) {
      foreach ($positionRepository->listarPorCarteira($carteira->getId()) as $posicao) {
        if ($posicao['ticker']) {
          $tickers[] = $posicao['ticker'];
        }
      }
    }

    $tickers = array_values(array_unique($tickers));

    if (empty($tickers)) {
      $this->info('Nenhum ativo encontrado na carteira do usuário.');
      return;
    }

    $service->atualizarCotacoes($brapi, $tickers);

    $this->info('Cotações atualizadas com sucesso.');
  }
}