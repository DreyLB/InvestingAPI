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
      (int) $dados['quantidade'],
      (float) $dados['valor'],
      new DateTime($dados['data'])
    );

    $this->transacaoRepository->save($transacao, $ativoId);
    return $transacao;
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
