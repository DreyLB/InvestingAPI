<?php

namespace App\Http\Controllers\API;

use App\Application\Services\MetaService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MetaRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class MetaController extends Controller
{
  public function __construct(private MetaService $service) {}

  // GET /carteiras/{carteiraId}/metas
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

  // POST /carteiras/{carteiraId}/metas
  public function store(MetaRequest $request, int $carteiraId): JsonResponse
  {
    try {
      $meta = $this->service->criar($carteiraId, $request->validated());

      return response()->json([
        'message' => 'Meta criada com sucesso!',
        'data'    => $meta,
      ], 201);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // PUT /carteiras/{carteiraId}/metas/{id}
  public function update(MetaRequest $request, int $carteiraId, int $id): JsonResponse
  {
    try {
      $meta = $this->service->atualizar($carteiraId, $id, $request->validated());

      return response()->json([
        'message' => 'Meta atualizada com sucesso!',
        'data'    => $meta,
      ]);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // DELETE /carteiras/{carteiraId}/metas/{id}
  public function destroy(int $carteiraId, int $id): JsonResponse
  {
    try {
      $this->service->remover($carteiraId, $id);
      return response()->json(['message' => 'Meta removida com sucesso!']);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }
}
