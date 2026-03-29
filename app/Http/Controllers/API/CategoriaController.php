<?php

namespace App\Http\Controllers\API;

use App\Application\Services\CategoriaService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
  public function __construct(private CategoriaService $service) {}

  public function index(): JsonResponse
  {
    return response()->json($this->service->listarTodas());
  }

  public function store(CategoriaRequest $request): JsonResponse
  {
    $categoria = $this->service->criar(
      $request->validated()['nome'],
      $request->validated()['descricao'] ?? ''
    );

    return response()->json([
      'message' => 'Categoria criada com sucesso!',
      'data'    => $categoria,
    ], 201);
  }

  public function show(int $id): JsonResponse
  {
    try {
      return response()->json($this->service->buscarPorId($id));
    } catch (ModelNotFoundException) {
      return response()->json(['message' => 'Categoria não encontrada.'], 404);
    }
  }

  public function update(CategoriaRequest $request, int $id): JsonResponse
  {
    try {
      $categoria = $this->service->atualizar(
        $id,
        $request->validated()['nome'],
        $request->validated()['descricao'] ?? ''
      );

      return response()->json([
        'message' => 'Categoria atualizada com sucesso!',
        'data'    => $categoria,
      ]);
    } catch (ModelNotFoundException) {
      return response()->json(['message' => 'Categoria não encontrada.'], 404);
    }
  }

  public function destroy(int $id): JsonResponse
  {
    try {
      $this->service->remover($id);
      return response()->json(['message' => 'Categoria removida com sucesso!']);
    } catch (ModelNotFoundException) {
      return response()->json(['message' => 'Categoria não encontrada.'], 404);
    }
  }
}
