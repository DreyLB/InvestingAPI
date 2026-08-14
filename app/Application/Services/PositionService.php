<?php
// app/Application/Services/PositionService.php

namespace App\Application\Services;

use App\Domain\Entities\Position;
use App\Domain\Entities\Transacao;
use App\Domain\Repositories\CotacaoRepositoryInterface;
use App\Domain\Repositories\PositionRepositoryInterface;

class PositionService
{
  public function __construct(
    private PositionRepositoryInterface $positionRepository,
    private CotacaoRepositoryInterface $cotacaoRepository
  ) {}

  public function listarPorCarteira(int $walletId): array
  {
    $positions = $this->positionRepository->listarPorCarteira($walletId);

    $cotacoes = $this->cotacaoRepository->buscarPorAssetIds(
      array_column($positions, 'asset_id')
    );

    $cotacaoPorAsset = [];
    foreach ($cotacoes as $cotacao) {
      $cotacaoPorAsset[$cotacao->getAssetId()] = $cotacao->getValor();
    }

    return array_map(function (array $position) use ($cotacaoPorAsset) {
      $cotacaoAtual = $cotacaoPorAsset[$position['asset_id']] ?? null;

      $position['cotacao_atual'] = $cotacaoAtual;
      $position['valor_atual'] = $cotacaoAtual !== null
        ? $cotacaoAtual * (float) $position['quantidade']
        : (float) $position['valor_total'];

      return $position;
    }, $positions);
  }

  public function calcularValorTotal(int $walletId): float
  {
    $positions = $this->positionRepository->listarPorCarteira($walletId);

    return array_reduce(
      $positions,
      fn(float $carry, array $position) => $carry + (float) $position['valor_total'],
      0.0
    );
  }

  public function composicaoPorCategoria(int $walletId): array
  {
    $positions = $this->listarPorCarteira($walletId);

    $valorPorCategoria = [];
    foreach ($positions as $position) {
      $categoria = $position['tipo_nome'] ?? 'Outros';
      $valorPorCategoria[$categoria] = ($valorPorCategoria[$categoria] ?? 0.0) + (float) $position['valor_atual'];
    }

    return array_map(
      fn(string $categoria, float $valor) => ['categoria' => $categoria, 'valor' => $valor],
      array_keys($valorPorCategoria),
      array_values($valorPorCategoria)
    );
  }

  public function composicaoPorTipo(int $walletId, string $tipoNome): array
  {
    $positions = $this->listarPorCarteira($walletId);

    $filtradas = array_filter(
      $positions,
      fn(array $position) => $position['tipo_nome'] === $tipoNome
    );

    return array_values(array_map(
      fn(array $position) => [
        'ticker' => $position['ticker'],
        'valor'  => (float) $position['valor_atual'],
      ],
      $filtradas
    ));
  }

  // Chamado sempre que uma transação é registrada
  public function processar(Transacao $transacao): void
  {
    match ($transacao->getTipo()) {
      'compra'    => $this->processarCompra($transacao),
      'venda'     => $this->processarVenda($transacao),
      'dividendo' => null, // dividendo não afeta posição
      default     => throw new \InvalidArgumentException("Tipo de transação inválido: {$transacao->getTipo()}")
    };
  }

  private function processarCompra(Transacao $transacao): void
  {
    $position = $this->positionRepository->findByWalletAndAsset(
      $transacao->getWalletId(),
      $transacao->getAssetId()
    );

    if ($position) {
      // Já tem posição — recalcula preço médio ponderado
      $totalAtual = $position->getQuantidade() * $position->getPrecoMedio();
      $totalNovo  = $transacao->getQuantidade() * $transacao->getPrecoUnitario();
      $qtdTotal   = $position->getQuantidade() + $transacao->getQuantidade();

      $position->setQuantidade($qtdTotal);
      $position->setPrecoMedio(($totalAtual + $totalNovo) / $qtdTotal);
      $position->setValorTotal($qtdTotal * $position->getPrecoMedio());
    } else {
      // Primeira compra — cria nova posição
      $position = new Position(
        null,
        $transacao->getWalletId(),
        $transacao->getAssetId(),
        $transacao->getQuantidade(),
        $transacao->getPrecoUnitario(),
        $transacao->getValorTotal()
      );
    }

    $this->positionRepository->save($position);
  }

  private function processarVenda(Transacao $transacao): void
  {
    $position = $this->positionRepository->findByWalletAndAsset(
      $transacao->getWalletId(),
      $transacao->getAssetId()
    );

    if (!$position) {
      throw new \InvalidArgumentException('Você não possui posição neste ativo.');
    }

    if ($transacao->getQuantidade() > $position->getQuantidade()) {
      throw new \InvalidArgumentException(
        "Quantidade insuficiente. Disponível: {$position->getQuantidade()}"
      );
    }

    $novaQtd = $position->getQuantidade() - $transacao->getQuantidade();

    if ($novaQtd == 0) {
      // Zerou a posição — remove do portfolio
      $this->positionRepository->delete($position->getId());
    } else {
      // Preço médio não muda na venda
      $position->setQuantidade($novaQtd);
      $position->setValorTotal($novaQtd * $position->getPrecoMedio());
      $this->positionRepository->save($position);
    }
  }
}
