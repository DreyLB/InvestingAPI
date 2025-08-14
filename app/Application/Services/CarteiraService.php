<?php

namespace App\Application\Services;

use App\Domain\Entities\Carteira;
use App\Domain\Repositories\CarteiraRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarteiraService
{
  private CarteiraRepositoryInterface $carteiraRepository;

  public function __construct(CarteiraRepositoryInterface $carteiraRepository)
  {
    $this->carteiraRepository = $carteiraRepository;
  }

  /**
   * Lista todas as carteiras do usuário autenticado
   */
  public function listarCarteiras(int $userId): array
  {
    return $this->carteiraRepository->findByUserId($userId);
  }

  /**
   * Busca carteira específica do usuário
   */
  public function buscarCarteira(int $userId, int $carteiraId): Carteira
  {
    $carteira = $this->carteiraRepository->findByIdAndUserId($carteiraId, $userId);

    if (!$carteira) {
      throw new ModelNotFoundException("Carteira não encontrada ou não pertence ao usuário.");
    }

    return $carteira;
  }

  /**
   * Cria uma nova carteira para o usuário
   */
  public function criarCarteira(int $userId, string $nome, string $descricao): Carteira
  {
    $carteira = new Carteira(
      null,
      $userId,
      $nome,
      $descricao
    );

    $this->carteiraRepository->save($carteira);

    return $carteira;
  }

  /**
   * Atualiza carteira do usuário
   */
  public function atualizarCarteira(int $userId, int $carteiraId, ?string $nome, ?string $descricao): Carteira
  {
    $carteira = $this->buscarCarteira($userId, $carteiraId);

    if ($nome !== null) {
      $carteira->setNome($nome);
    }

    if ($descricao !== null) {
      $carteira->setDescricao($descricao);
    }

    $this->carteiraRepository->save($carteira);

    return $carteira;
  }

  /**
   * Remove carteira do usuário
   */
  public function removerCarteira(int $userId, int $carteiraId): void
  {
    $this->buscarCarteira($userId, $carteiraId); // garante que é do usuário
    $this->carteiraRepository->delete($carteiraId);
  }
}
