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
  // Endpoint principal: compra (busca Ativo por asset_id)
  public function comprar(int $walletId, array $dados): array
  {
    $this->validarPropriedadeCarteira($walletId);

    return DB::transaction(function () use ($walletId, $dados) {
      // Busca o ativo pelo ID (já cadastrado no banco)
      $ativo = $this->AtivoRepository->findById((int) $dados['asset_id']);

      if (!$ativo) {
        throw new ModelNotFoundException('Ativo não encontrado.');
      }

      $transacao = new Transacao(
        null,
        $walletId,
        $ativo->getId(),
        'compra',
        (float) $dados['quantidade'],
        (float) $dados['preco_unitario'],
        new DateTime($dados['data'])
      );

      $this->transacaoRepository->save($transacao);
      $this->positionService->processar($transacao);

      return [
        'transacao' => $transacao,
        'ativo'     => $ativo,
      ];
    });
  }

  public function vender(int $walletId, int $AtivoId, array $dados): array
  {
    $this->validarPropriedadeCarteira($walletId);

    return DB::transaction(function () use ($walletId, $AtivoId, $dados) {
      $ativo = $this->AtivoRepository->findById((int) $AtivoId);
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

      return [
        'transacao' => $transacao,
        'ativo'     => $ativo,
      ];
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
