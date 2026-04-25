<?php

namespace App\Application\Services;

use App\Domain\Entities\Dividendo;
use App\Domain\Repositories\DividendoRepositoryInterface;
use App\Domain\Repositories\AtivoRepositoryInterface;
use App\Infrastructure\Persistence\CarteiraRepository;
use App\Infrastructure\Persistence\PositionRepository;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class DividendoService
{
  public function __construct(
    private DividendoRepositoryInterface $dividendoRepository,
    private AtivoRepositoryInterface $ativoRepository,
    private CarteiraRepository $carteiraRepository,
    private PositionRepository $positionRepository
  ) {}

  private function validarPropriedadeCarteira(int $carteiraId): void
  {
    $userId = (int) Auth::id();
    if (!$this->carteiraRepository->findByIdAndUserId($carteiraId, $userId)) {
      throw new ModelNotFoundException('Carteira não encontrada.');
    }
  }

  // Valida se o ativo existe na carteira via positions (nova arquitetura)
  private function validarAtivoNaCarteira(int $ativoId, int $carteiraId): void
  {
    $position = $this->positionRepository->findByWalletAndAsset($carteiraId, $ativoId);
    if (!$position) {
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
    $this->validarAtivoNaCarteira($ativoId, $carteiraId);
    return $this->dividendoRepository->listarPorAtivo($ativoId);
  }

  public function criar(int $carteiraId, int $ativoId, array $dados): Dividendo
  {
    $this->validarPropriedadeCarteira($carteiraId);
    $this->validarAtivoNaCarteira($ativoId, $carteiraId);

    // Verifica se o ativo existe no catálogo
    $ativo = $this->ativoRepository->findById($ativoId);
    if (!$ativo) {
      throw new ModelNotFoundException('Ativo não encontrado no catálogo.');
    }

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
