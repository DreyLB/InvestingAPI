<?php
// app/Http/Controllers/API/AtivoController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Domain\Repositories\AtivoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AtivoController extends Controller
{
    public function __construct(
        private AtivoRepositoryInterface $ativoRepository
    ) {}

    // GET /ativos
    // GET /ativos?ticker=PETR4
    public function index(Request $request): JsonResponse
    {
        if ($request->has('ticker')) {
            $ativo = $this->ativoRepository->findByTicker($request->query('ticker'));

            if (!$ativo) {
                return response()->json(['message' => 'Ativo não encontrado.'], 404);
            }

            return response()->json($ativo);
        }

        return response()->json($this->ativoRepository->listarTodos());
    }
}
