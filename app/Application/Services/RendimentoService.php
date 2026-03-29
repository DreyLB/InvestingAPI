<?php

namespace App\Application\Services;

use App\Domain\Entities\Rendimento;
use App\Domain\Repositories\RendimentoRepositoryInterface;
use App\Infrastructure\Persistence\CarteiraRepository;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class RendimentoService
{
  public function __construct(
    private RendimentoRepositoryInterface $rendimentoRepository,
    private CarteiraRepository $carteiraRepository
  ) {}

  private function validarPropriedadeCarteira(int $carteiraId): void
  {
    $userId = (int) Auth::id();
    if (!$this->carteiraRepository->findByIdAndUserId($carteiraId, $userId)) {
      throw new ModelNotFoundException('Carteira não encontrada ou não pertence ao usuário.');
    }
  }

  public function listarPorCarteira(int $carteiraId): array
  {
    $this->validarPropriedadeCarteira($carteiraId);
    return $this->rendimentoRepository->listarPorCarteira($carteiraId);
  }

  public function criar(int $carteiraId, array $dados): Rendimento
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $rendimento = new Rendimento(
      null,
      $dados['rendimento'],
      (float) $dados['valor'],
      new DateTime($dados['periodo_ini']),
      new DateTime($dados['periodo_fim'])
    );

    $this->rendimentoRepository->save($rendimento, $carteiraId);
    return $rendimento;
  }

  public function atualizar(int $carteiraId, int $id, array $dados): Rendimento
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $rendimento = $this->rendimentoRepository->findById($id);
    if (!$rendimento) {
      throw new ModelNotFoundException('Rendimento não encontrado.');
    }

    if (isset($dados['rendimento']))  $rendimento->setType($dados['rendimento']);
    if (isset($dados['valor']))       $rendimento->setValor((float) $dados['valor']);
    if (isset($dados['periodo_ini'])) $rendimento->setPeriodoInicial(new DateTime($dados['periodo_ini']));
    if (isset($dados['periodo_fim'])) $rendimento->setPeriodoFinal(new DateTime($dados['periodo_fim']));

    $this->rendimentoRepository->save($rendimento, $carteiraId);
    return $rendimento;
  }

  public function remover(int $carteiraId, int $id): void
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $rendimento = $this->rendimentoRepository->findById($id);
    if (!$rendimento) {
      throw new ModelNotFoundException('Rendimento não encontrado.');
    }

    $this->rendimentoRepository->delete($id);
  }
}
