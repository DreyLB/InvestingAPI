<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Application\Services\AtivoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AtivoController extends Controller
{
    public function __construct(private AtivoService $service)
    {
        $this->middleware('auth:api');
    }

    public function index(int $carteiraId): JsonResponse
    {
        $ativos = $this->service->listarAtivos($carteiraId);
        return response()->json($ativos);
    }

    public function show(int $carteiraId, int $id): JsonResponse
    {
        $ativo = $this->service->buscarAtivo($carteiraId, $id);
        return response()->json($ativo);
    }

    public function store(Request $request, int $wallet): JsonResponse
    {
        $dados = $request->validate([
            'category_id'    => 'nullable|exists:categories,id',
            'asset_type_id'  => 'required|exists:asset_types,id',
            'name'           => 'required|string|max:255',
            'quantity'       => 'required|numeric|min:0',
            'price'          => 'required|numeric|min:0',
            'average_price'  => 'required|numeric|min:0',
        ]);

        $ativo = $this->service->criarAtivo($wallet, $dados);
        return response()->json($ativo, 201);
    }

    public function update(Request $request, int $carteiraId, int $id): JsonResponse
    {
        $dados = $request->validate([
            'category_id'    => 'nullable|exists:categories,id',
            'asset_type_id'  => 'sometimes|exists:asset_types,id',
            'name'           => 'sometimes|string|max:255',
            'quantity'       => 'sometimes|numeric|min:0',
            'price'          => 'sometimes|numeric|min:0',
            'average_price'  => 'sometimes|numeric|min:0',
        ]);

        $ativo = $this->service->atualizarAtivo($carteiraId, $id, $dados);
        return response()->json($ativo);
    }

    public function destroy(int $carteiraId, int $id): JsonResponse
    {
        $this->service->removerAtivo($carteiraId, $id);
        return response()->json(['message' => 'Ativo removido com sucesso.']);
    }
}
