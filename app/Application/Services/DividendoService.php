<?php

namespace App\Application\Services;

use App\Domain\Entities\Dividendo;
use App\Domain\Repositories\DividendoRepositoryInterface;
use App\Infrastructure\Persistence\AtivoRepository;
use App\Infrastructure\Persistence\CarteiraRepository;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class DividendoService
{
  public function __construct(
    private DividendoRepositoryInterface $dividendoRepository,
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
    return $this->dividendoRepository->listarPorCarteira($carteiraId);
  }

  public function listarPorAtivo(int $carteiraId, int $ativoId): array
  {
    $this->validarPropriedadeCarteira($carteiraId);
    $this->validarPropriedadeAtivo($ativoId, $carteiraId);
    return $this->dividendoRepository->listarPorAtivo($ativoId);
  }

  public function criar(int $carteiraId, int $ativoId, array $dados): Dividendo
  {
    $this->validarPropriedadeCarteira($carteiraId);
    $this->validarPropriedadeAtivo($ativoId, $carteiraId);

    $dividendo = new Dividendo(
      null,
      new DateTime($dados['data']),
      (float) $dados['valor']
    );

    $this->dividendoRepository->save($dividendo, $ativoId);
    return $dividendo;
  }

  public function remover(int $carteiraId, int $id): void
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $dividendo = $this->dividendoRepository->findById($id);
    if (!$dividendo) {
      throw new ModelNotFoundException('Dividendo não encontrado.');
    }

    $this->dividendoRepository->delete($id);
  }
}
