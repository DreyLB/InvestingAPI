<?php

namespace App\Http\Controllers\API;

use App\Application\Services\AssetTypeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetTypeRequest;
use App\Http\Requests\UpdateAssetTypeRequest;
use Illuminate\Http\JsonResponse;

class AssetTypeController extends Controller
{
  private AssetTypeService $service;

  public function __construct(AssetTypeService $service)
  {
    $this->service = $service;
  }

  public function index(): JsonResponse
  {
    return response()->json($this->service->listarTodos());
  }

  public function store(StoreAssetTypeRequest $request): JsonResponse
  {
    $assetType = $this->service->criar(
      $request->validated()['nome'],
      $request->validated()['descricao'] ?? null
    );

    return response()->json($assetType, 201);
  }

  public function show(int $id): JsonResponse
  {
    $assetType = $this->service->buscarPorId($id);

    if (!$assetType) {
      return response()->json(['message' => 'Tipo de ativo não encontrado'], 404);
    }

    return response()->json($assetType);
  }

  public function update(UpdateAssetTypeRequest $request, int $id): JsonResponse
  {
    $assetType = $this->service->atualizar(
      $id,
      $request->validated()['nome'],
      $request->validated()['descricao'] ?? null
    );

    if (!$assetType) {
      return response()->json(['message' => 'Tipo de ativo não encontrado'], 404);
    }

    return response()->json($assetType);
  }

  public function destroy(int $id): JsonResponse
  {
    $this->service->excluir($id);
    return response()->json(['message' => 'Tipo de ativo removido com sucesso']);
  }
}
