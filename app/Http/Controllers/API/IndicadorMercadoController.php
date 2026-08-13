<?php
// app/Http/Controllers/API/IndicadorMercadoController.php

namespace App\Http\Controllers\API;

use App\Application\Services\IndicadorMercadoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class IndicadorMercadoController extends Controller
{
  public function __construct(
    private IndicadorMercadoService $service
  ) {}

  // GET /indicadores-mercado
  public function index(): JsonResponse
  {
    return response()->json($this->service->listarTodos());
  }
}
