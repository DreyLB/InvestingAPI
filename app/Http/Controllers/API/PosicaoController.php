<?php
// app/Http/Controllers/API/PosicaoController.php

namespace App\Http\Controllers\API;

use App\Application\Services\PositionService;
use App\Infrastructure\Persistence\CarteiraRepository;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PosicaoController extends Controller
{
  public function __construct(
    private PositionService $positionService,
    private CarteiraRepository $carteiraRepository
  ) {}

  // GET /carteiras/{carteiraId}/posicoes
  public function index(int $carteiraId): JsonResponse
  {
    try {
      $userId = (int) Auth::id();

      if (!$this->carteiraRepository->findByIdAndUserId($carteiraId, $userId)) {
        return response()->json(['message' => 'Carteira não encontrada.'], 404);
      }

      return response()->json(
        $this->positionService->listarPorCarteira($carteiraId)
      );
    } catch (ModelNotFoundException $e) {
      return response()->json(['message' => $e->getMessage()], 404);
    }
  }
}
