<?php
// app/Application/Services/TransacaoService.php

namespace App\Application\Services;

use App\Domain\Entities\Ativo;
use App\Domain\Entities\Transacao;
use App\Domain\Repositories\TransacaoRepositoryInterface;
use App\Domain\Repositories\AtivoRepositoryInterface;
use App\Infrastructure\Persistence\CarteiraRepository;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransacaoService
{
  public function __construct(
    private TransacaoRepositoryInterface $transacaoRepository,
    private AtivoRepositoryInterface $AtivoRepository,
    private CarteiraRepository $carteiraRepository,
    private PositionService $positionService
  ) {}

  private function validarPropriedadeCarteira(int $carteiraId): void
  {
    $userId = (int) Auth::id();
    if (!$this->carteiraRepository->findByIdAndUserId($carteiraId, $userId)) {
      throw new ModelNotFoundException('Carteira não encontrada ou não pertence ao usuário.');
    }
  }

  public function listarPorCarteira(int $walletId): array
  {
    $this->validarPropriedadeCarteira($walletId);
    return $this->transacaoRepository->listarPorCarteira($walletId);
  }

  public function listarPorAtivo(int $walletId, int $AtivoId): array
  {
    $this->validarPropriedadeCarteira($walletId);
    return $this->transacaoRepository->listarPorAsset($walletId, $AtivoId);
  }

  // Endpoint principal: compra (cria Ativo global se não existir)
  public function comprar(int $walletId, array $dados): array
  {
    $this->validarPropriedadeCarteira($walletId);

    return DB::transaction(function () use ($walletId, $dados) {
      // Busca ou cria o Ativo no catálogo global
      $Ativo = $this->AtivoRepository->findByTicker($dados['ticker']);

      if (!$Ativo) {
        $Ativo = new Ativo(
          null,
          strtoupper($dados['ticker']),
          $dados['nome'] ?? strtoupper($dados['ticker']),
          (int) $dados['Ativo_type_id'],
          isset($dados['category_id']) ? (int) $dados['category_id'] : null,
          new DateTime(),
          new DateTime()
        );
        $this->AtivoRepository->save($Ativo);
      }

      $transacao = new Transacao(
        null,
        $walletId,
        $Ativo->getId(),
        'compra',
        (float) $dados['quantidade'],
        (float) $dados['preco_unitario'],
        new DateTime($dados['data'])
      );

      $this->transacaoRepository->save($transacao);
      $this->positionService->processar($transacao); // 👈 atualiza position

      return [
        'transacao' => $transacao,
        'Ativo'     => $Ativo,
      ];
    });
  }

  public function vender(int $walletId, int $AtivoId, array $dados): Transacao
  {
    $this->validarPropriedadeCarteira($walletId);

    return DB::transaction(function () use ($walletId, $AtivoId, $dados) {
      $transacao = new Transacao(
        null,
        $walletId,
        $AtivoId,
        'venda',
        (float) $dados['quantidade'],
        (float) $dados['preco_unitario'],
        new DateTime($dados['data'])
      );

      // positionService valida quantidade disponível antes de salvar
      $this->positionService->processar($transacao);
      $this->transacaoRepository->save($transacao);

      return $transacao;
    });
  }

  public function remover(int $walletId, int $id): void
  {
    $this->validarPropriedadeCarteira($walletId);

    $transacao = $this->transacaoRepository->findById($id);
    if (!$transacao) {
      throw new ModelNotFoundException('Transação não encontrada.');
    }

    $this->transacaoRepository->delete($id);
  }
}