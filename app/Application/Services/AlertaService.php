<?php

namespace App\Application\Services;

use App\Domain\Entities\Alerta;
use App\Domain\Repositories\AlertaRepositoryInterface;
use App\Infrastructure\Persistence\CarteiraRepository;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class AlertaService
{
  public function __construct(
    private AlertaRepositoryInterface $alertaRepository,
    private CarteiraRepository $carteiraRepository
  ) {}

  private function validarPropriedadeCarteira(int $carteiraId): void
  {
    $userId = (int) Auth::id();
    if (!$this->carteiraRepository->findByIdAndUserId($carteiraId, $userId)) {
      throw new ModelNotFoundException('Carteira não encontrada ou não pertence ao usuário.');
    }
  }

  public function listarPorCarteira(int $carteiraId, ?bool $lido = null): array
  {
    $this->validarPropriedadeCarteira($carteiraId);
    return $this->alertaRepository->listarPorCarteira($carteiraId, $lido);
  }

  public function criar(int $carteiraId, array $dados): Alerta
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $alerta = new Alerta(
      null,
      $carteiraId,
      $dados['tipo'],
      $dados['mensagem'],
      new DateTime($dados['data']),
      false
    );

    $this->alertaRepository->save($alerta);
    return $alerta;
  }

  public function marcarComoLido(int $carteiraId, int $id): Alerta
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $alerta = $this->alertaRepository->findById($id);
    if (!$alerta) {
      throw new ModelNotFoundException('Alerta não encontrado.');
    }

    $this->alertaRepository->marcarComoLido($id);
    $alerta->setLido(true);
    return $alerta;
  }

  public function remover(int $carteiraId, int $id): void
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $alerta = $this->alertaRepository->findById($id);
    if (!$alerta) {
      throw new ModelNotFoundException('Alerta não encontrado.');
    }

    $this->alertaRepository->delete($id);
  }
}
