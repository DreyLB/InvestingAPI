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

    $valorTotal = (float) $dados['valor'] * (float) $dados['quantidade']; // 👈

    $transacao = new Transacao(
      null,
      $dados['tipo'],
      (float) $dados['quantidade'],
      $valorTotal,
      new DateTime($dados['data'])
    );

    $this->transacaoRepository->save($transacao, $ativoId);
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

  public function comprar(int $carteiraId, array $dados): array
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $precoUnitario = (float) $dados['valor'];
    $quantidade    = (float) $dados['quantidade'];
    $valorTotal    = $precoUnitario * $quantidade; // 👈 valor total = preço × qtd

    $ativo = $this->ativoRepository->findByNomeAndCarteira(
      $dados['nome'],
      $carteiraId
    );

    if ($ativo) {
      // Ativo já existe — recalcula preço médio ponderado
      $totalAtual = $ativo->getQuantidade() * $ativo->getPrecoMedio();
      $totalNovo  = $quantidade * $precoUnitario;
      $qtdTotal   = $ativo->getQuantidade() + $quantidade;

      $ativo->setQuantidade($qtdTotal);
      $ativo->setPrecoMedio(($totalAtual + $totalNovo) / $qtdTotal);
      $ativo->setPreco($precoUnitario);
      $ativo->setUpdatedAt(new DateTime());

      $this->ativoRepository->save($ativo);
    } else {
      // Ativo não existe — cria novo
      $ativo = new \App\Domain\Entities\Ativo(
        0,
        $carteiraId,
        $dados['category_id'] ?? null,
        $dados['nome'],
        (int) $dados['asset_type_id'],
        $quantidade,
        $precoUnitario,
        $precoUnitario, // preço médio inicial = preço unitário da compra
        new DateTime(),
        new DateTime()
      );

      $this->ativoRepository->save($ativo);
    }

    // Registra transação com valor total
    $transacao = new \App\Domain\Entities\Transacao(
      null,
      'compra',
      $quantidade,
      $valorTotal,
      new DateTime($dados['data'])
    );

    $this->transacaoRepository->save($transacao, $ativo->getId());

    return [
      'ativo'     => $ativo,
      'transacao' => $transacao,
    ];
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
