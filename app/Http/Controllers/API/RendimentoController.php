<?php

namespace App\Http\Controllers\API;

use App\Application\Services\RendimentoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RendimentoRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class RendimentoController extends Controller
{
  public function __construct(private RendimentoService $service) {}

  // GET /carteiras/{carteiraId}/rendimentos
  public function index(int $carteiraId): JsonResponse
  {
    try {
      return response()->json(
        $this->service->listarPorCarteira($carteiraId)
      );
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // POST /carteiras/{carteiraId}/rendimentos
  public function store(RendimentoRequest $request, int $carteiraId): JsonResponse
  {
    try {
      $rendimento = $this->service->criar($carteiraId, $request->validated());

      return response()->json([
        'message' => 'Rendimento registrado com sucesso!',
        'data'    => $rendimento,
      ], 201);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // PUT /carteiras/{carteiraId}/rendimentos/{id}
  public function update(RendimentoRequest $request, int $carteiraId, int $id): JsonResponse
  {
    try {
      $rendimento = $this->service->atualizar($carteiraId, $id, $request->validated());

      return response()->json([
        'message' => 'Rendimento atualizado com sucesso!',
        'data'    => $rendimento,
      ]);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // DELETE /carteiras/{carteiraId}/rendimentos/{id}
  public function destroy(int $carteiraId, int $id): JsonResponse
  {
    try {
      $this->service->remover($carteiraId, $id);
      return response()->json(['message' => 'Rendimento removido com sucesso!']);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }
}
