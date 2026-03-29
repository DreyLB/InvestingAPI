<?php
// app/Application/Services/TransacaoService.php

namespace App\Application\Services;

use App\Domain\Entities\Transacao;
use App\Domain\Repositories\TransacaoRepositoryInterface;
use App\Infrastructure\Persistence\AtivoRepository;
use App\Infrastructure\Persistence\CarteiraRepository;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class TransacaoService
{
  public function __construct(
    private TransacaoRepositoryInterface $transacaoRepository,
    private AtivoRepository $ativoRepository,
    private CarteiraRepository $carteiraRepository
  ) {}

  private function validarPropriedadeCarteira(int $carteiraId): void
  {
    $userId = (int) Auth::id();
    if (!$this->carteiraRepository->findByIdAndUserId($carteiraId, $userId)) {
      throw new ModelNotFoundException('Carteira não encontrada ou não pertence ao usuário.');
    }
  }

  private function validarPropriedadeAtivo(int $ativoId, int $carteiraId): void
  {
    if (!$this->ativoRepository->findByIdAndCarteira($ativoId, $carteiraId)) {
      throw new ModelNotFoundException('Ativo não encontrado nesta carteira.');
    }
  }

  public function listarPorCarteira(int $carteiraId): array
  {
    $this->validarPropriedadeCarteira($carteiraId);
    return $this->transacaoRepository->listarPorCarteira($carteiraId);
  }

  public function listarPorAtivo(int $carteiraId, int $ativoId): array
  {
    $this->validarPropriedadeCarteira($carteiraId);
    $this->validarPropriedadeAtivo($ativoId, $carteiraId);
    return $this->transacaoRepository->listarPorAtivo($ativoId);
  }

  public function criar(int $carteiraId, int $ativoId, array $dados): Transacao
  {
    $this->validarPropriedadeCarteira($carteiraId);
    $this->validarPropriedadeAtivo($ativoId, $carteiraId);

    $transacao = new Transacao(
      null,
      $dados['tipo'],
      (float) $dados['quantidade'],
      (float) $dados['valor'],
      new DateTime($dados['data'])
    );

    $this->transacaoRepository->save($transacao, $ativoId);

    // 👇 Atualiza o ativo após registrar a transação
    $this->atualizarAtivo($ativoId, $carteiraId, $dados);

    return $transacao;
  }

  private function atualizarAtivo(int $ativoId, int $carteiraId, array $dados): void
  {
    $ativo = $this->ativoRepository->findByIdAndCarteira($ativoId, $carteiraId);

    if (!$ativo) return;

    $tipo         = $dados['tipo'];
    $qtdTransacao = (float) $dados['quantidade'];
    $valorUnitario = (float) $dados['valor'] / (float) $dados['quantidade'];

    if ($tipo === 'compra') {
      // Recalcula preço médio ponderado
      $totalAtual  = $ativo->getQuantidade() * $ativo->getPrecoMedio();
      $totalNovo   = $qtdTransacao * $valorUnitario;
      $qtdTotal    = $ativo->getQuantidade() + $qtdTransacao;

      $novoPrecoMedio = $qtdTotal > 0
        ? ($totalAtual + $totalNovo) / $qtdTotal
        : $valorUnitario;

      $ativo->setQuantidade($qtdTotal);
      $ativo->setPrecoMedio($novoPrecoMedio);
    } elseif ($tipo === 'venda') {
      $novaQtd = $ativo->getQuantidade() - $qtdTransacao;

      if ($novaQtd < 0) {
        throw new \InvalidArgumentException(
          'Quantidade vendida maior do que a quantidade disponível.'
        );
      }

      $ativo->setQuantidade($novaQtd);
      // Preço médio não muda na venda
    }

    $ativo->setUpdatedAt(new DateTime());
    $this->ativoRepository->save($ativo);
  }

  public function remover(int $carteiraId, int $id): void
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $transacao = $this->transacaoRepository->findById($id);
    if (!$transacao) {
      throw new ModelNotFoundException('Transação não encontrada.');
    }

    $this->transacaoRepository->delete($id);
  }
}
