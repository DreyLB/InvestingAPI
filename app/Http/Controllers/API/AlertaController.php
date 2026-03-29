<?php

namespace App\Http\Controllers\API;

use App\Application\Services\AlertaService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlertaRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
  public function __construct(private AlertaService $service) {}

  // GET /carteiras/{carteiraId}/alertas
  // GET /carteiras/{carteiraId}/alertas?lido=false  → só não lidos
  // GET /carteiras/{carteiraId}/alertas?lido=true   → só lidos
  public function index(Request $request, int $carteiraId): JsonResponse
  {
    try {
      $lido = null;
      if ($request->has('lido')) {
        $lido = filter_var($request->query('lido'), FILTER_VALIDATE_BOOLEAN);
      }

      return response()->json(
        $this->service->listarPorCarteira($carteiraId, $lido)
      );
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // POST /carteiras/{carteiraId}/alertas
  public function store(AlertaRequest $request, int $carteiraId): JsonResponse
  {
    try {
      $alerta = $this->service->criar($carteiraId, $request->validated());

      return response()->json([
        'message' => 'Alerta criado com sucesso!',
        'data'    => $alerta,
      ], 201);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // PATCH /carteiras/{carteiraId}/alertas/{id}/lido
  public function marcarComoLido(int $carteiraId, int $id): JsonResponse
  {
    try {
      $alerta = $this->service->marcarComoLido($carteiraId, $id);

      return response()->json([
        'message' => 'Alerta marcado como lido!',
        'data'    => $alerta,
      ]);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // DELETE /carteiras/{carteiraId}/alertas/{id}
  public function destroy(int $carteiraId, int $id): JsonResponse
  {
    try {
      $this->service->remover($carteiraId, $id);
      return response()->json(['message' => 'Alerta removido com sucesso!']);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }
}
