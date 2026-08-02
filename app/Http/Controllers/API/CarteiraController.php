<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Application\Services\CarteiraService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CarteiraRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CarteiraController extends Controller
{
    private CarteiraService $carteiraService;

    public function __construct(CarteiraService $carteiraService)
    {
        $this->carteiraService = $carteiraService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carteiras = $this->carteiraService->listarCarteiras(Auth::id());
        return response()->json($carteiras);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CarteiraRequest $request)
    {
        $carteira = $this->carteiraService->criarCarteira(
            Auth::id(),
            $request->nome,
            $request->descricao ?? ''
        );

        return response()->json([
            'message' => 'Carteira criada com sucesso!',
            'data' => $carteira
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carteira = $this->carteiraService->buscarCarteira(Auth::id(), (int) $id);
        return response()->json($carteira);
    }

    public function evolucaoCarteira(int $carteiraId): JsonResponse
    {
        try {
            $userId = (int) Auth::id();

            $this->carteiraService->buscarCarteira($userId, $carteiraId); // valida posse

            $evolucao = $this->carteiraService->calcularEvolucaoCarteira($carteiraId);

            return response()->json($evolucao);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarteiraRequest $request, string $id)
    {
        $carteira = $this->carteiraService->atualizarCarteira(
            Auth::id(),
            (int) $id,
            $request->nome ?? null,
            $request->descricao ?? null
        );

        return response()->json([
            'message' => 'Carteira atualizada com sucesso!',
            'data' => $carteira
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->carteiraService->removerCarteira(Auth::id(), (int)$id);
        return response()->json(['message' => 'Carteira removida com sucesso!']);
    }

    public function restore(string $id)
    {
        $carteira = $this->carteiraService->restaurarCarteira(Auth::id(), (int)$id);
        if (!$carteira) {
            return response()->json(['message' => 'Carteira não encontrada'], 404);
        }
        return response()->json([
            'message' => 'Carteira restaurada com sucesso!',
            'data' => $carteira
        ]);
    }
}
