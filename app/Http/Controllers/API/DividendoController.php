<?php


namespace App\Http\Controllers\API;

use App\Application\Services\DividendoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DividendoRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DividendoController extends Controller
{
  public function __construct(private DividendoService $service) {}

  // GET /carteiras/{carteiraId}/dividendos
  public function porCarteira(int $carteiraId): JsonResponse
  {
    try {
      return response()->json(
        $this->service->listarPorCarteira($carteiraId)
      );
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // GET /carteiras/{carteiraId}/ativos/{ativoId}/dividendos
  public function index(int $carteiraId, int $ativoId): JsonResponse
  {
    try {
      return response()->json(
        $this->service->listarPorAtivo($carteiraId, $ativoId)
      );
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // POST /carteiras/{carteiraId}/ativos/{ativoId}/dividendos
  public function store(DividendoRequest $request, int $carteiraId, int $ativoId): JsonResponse
  {
    try {
      $dividendo = $this->service->criar(
        $carteiraId,
        $ativoId,
        $request->validated()
      );

      return response()->json([
        'message' => 'Dividendo registrado com sucesso!',
        'data'    => $dividendo,
      ], 201);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // DELETE /carteiras/{carteiraId}/dividendos/{id}
  public function destroy(int $carteiraId, int $id): JsonResponse
  {
    try {
      $this->service->remover($carteiraId, $id);
      return response()->json(['message' => 'Dividendo removido com sucesso!']);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }
}
