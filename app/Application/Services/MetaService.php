<?php

namespace App\Application\Services;

use App\Domain\Entities\Meta;
use App\Domain\Repositories\MetaRepositoryInterface;
use App\Infrastructure\Persistence\CarteiraRepository;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class MetaService
{
  public function __construct(
    private MetaRepositoryInterface $metaRepository,
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
    return $this->metaRepository->listarPorCarteira($carteiraId);
  }

  public function criar(int $carteiraId, array $dados): Meta
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $meta = new Meta(
      null,
      $dados['nome'],
      $dados['descricao'] ?? '',
      (float) $dados['valor'],
      isset($dados['data_limite']) ? new DateTime($dados['data_limite']) : null
    );

    $this->metaRepository->save($meta, $carteiraId);
    return $meta;
  }

  public function atualizar(int $carteiraId, int $id, array $dados): Meta
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $meta = $this->metaRepository->findById($id);
    if (!$meta) {
      throw new ModelNotFoundException('Meta não encontrada.');
    }

    if (isset($dados['nome']))        $meta->setNome($dados['nome']);
    if (isset($dados['descricao']))   $meta->setDescricao($dados['descricao']);
    if (isset($dados['valor']))       $meta->setValor((float) $dados['valor']);
    if (isset($dados['data_limite'])) $meta->setDataLimite(new DateTime($dados['data_limite']));

    $this->metaRepository->save($meta, $carteiraId);
    return $meta;
  }

  public function remover(int $carteiraId, int $id): void
  {
    $this->validarPropriedadeCarteira($carteiraId);

    $meta = $this->metaRepository->findById($id);
    if (!$meta) {
      throw new ModelNotFoundException('Meta não encontrada.');
    }

    $this->metaRepository->delete($id);
  }
}
