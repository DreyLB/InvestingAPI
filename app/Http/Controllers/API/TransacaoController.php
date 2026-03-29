<?php
// app/Http/Controllers/API/TransacaoController.php

namespace App\Http\Controllers\API;

use App\Application\Services\TransacaoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransacaoRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class TransacaoController extends Controller
{
  public function __construct(private TransacaoService $service) {}

  // GET /carteiras/{carteiraId}/transacoes
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

  // GET /carteiras/{carteiraId}/ativos/{ativoId}/transacoes
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

  // POST /carteiras/{carteiraId}/ativos/{ativoId}/transacoes
  public function store(TransacaoRequest $request, int $carteiraId, int $ativoId): JsonResponse
  {
    try {
      $transacao = $this->service->criar(
        $carteiraId,
        $ativoId,
        $request->validated()
      );

      return response()->json([
        'message' => 'Transação registrada com sucesso!',
        'data'    => $transacao,
      ], 201);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }

  // DELETE /carteiras/{carteiraId}/transacoes/{id}
  public function destroy(int $carteiraId, int $id): JsonResponse
  {
    try {
      $this->service->remover($carteiraId, $id);
      return response()->json(['message' => 'Transação removida com sucesso!']);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }
}
