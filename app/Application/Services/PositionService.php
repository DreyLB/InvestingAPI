<?php
// app/Application/Services/PositionService.php

namespace App\Application\Services;

use App\Domain\Entities\Position;
use App\Domain\Entities\Transacao;
use App\Domain\Repositories\PositionRepositoryInterface;

class PositionService
{
  public function __construct(
    private PositionRepositoryInterface $positionRepository
  ) {}

  public function listarPorCarteira(int $walletId): array
  {
    return $this->positionRepository->listarPorCarteira($walletId);
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
