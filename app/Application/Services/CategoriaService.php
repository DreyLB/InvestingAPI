<?php


namespace App\Application\Services;

use App\Domain\Entities\Categoria;
use App\Domain\Repositories\CategoriaRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoriaService
{
  public function __construct(
    private CategoriaRepositoryInterface $categoriaRepository
  ) {}

  public function listarTodas(): array
  {
    return $this->categoriaRepository->listarTodas();
  }

  public function buscarPorId(int $id): Categoria
  {
    $categoria = $this->categoriaRepository->findById($id);

    if (!$categoria) {
      throw new ModelNotFoundException('Categoria não encontrada.');
    }

    return $categoria;
  }

  public function criar(string $nome, string $descricao): Categoria
  {
    $categoria = new Categoria(null, $nome, $descricao);
    $this->categoriaRepository->save($categoria);
    return $categoria;
  }

  public function atualizar(int $id, string $nome, string $descricao): Categoria
  {
    $categoria = $this->buscarPorId($id);
    $categoria->setNome($nome);
    $categoria->setDescricao($descricao);
    $this->categoriaRepository->save($categoria);
    return $categoria;
  }

  public function remover(int $id): void
  {
    $this->buscarPorId($id); // garante que existe antes de deletar
    $this->categoriaRepository->delete($id);
  }
}
