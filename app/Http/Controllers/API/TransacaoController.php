<?php
// app/Http/Controllers/API/TransacaoController.php

namespace App\Http\Controllers\API;

use App\Application\Services\TransacaoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransacaoCompraRequest;
use App\Http\Requests\TransacaoVendaRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class TransacaoController extends Controller
{
  public function __construct(private TransacaoService $service) {}

  // GET /carteiras/{carteiraId}/transacoes
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

  // POST /carteiras/{carteiraId}/comprar
  public function comprar(TransacaoCompraRequest $request, int $carteiraId): JsonResponse
  {
    try {
      $resultado = $this->service->comprar($carteiraId, $request->validated());

      return response()->json([
        'message'   => 'Compra registrada com sucesso!',
        'transacao' => $resultado['transacao'],
        'ativo'     => $resultado['Ativo'],
      ], 201);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    } catch (\InvalidArgumentException $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  // POST /carteiras/{carteiraId}/vender
  public function vender(TransacaoVendaRequest $request, int $carteiraId): JsonResponse
  {
    try {
      $transacao = $this->service->vender(
        $carteiraId,
        (int) $request->validated()['asset_id'],
        $request->validated()
      );

      return response()->json([
        'message'   => 'Venda registrada com sucesso!',
        'transacao' => $transacao,
      ], 201);
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    } catch (\InvalidArgumentException $e) {
      return response()->json(['message' => $e->getMessage()], 400);
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
