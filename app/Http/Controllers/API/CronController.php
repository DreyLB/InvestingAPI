<?php
// app/Http/Controllers/API/CronController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CronController extends Controller
{
  // GET /cron/atualizar-cotacoes
  // Disparado pelo Vercel Cron (ou qualquer scheduler HTTP externo), já que
  // o scheduler do Laravel não roda em ambiente serverless.
  public function atualizarCotacoes(Request $request): JsonResponse
  {
    return $this->executarComando($request, 'cotacoes:atualizar');
  }

  // GET /cron/atualizar-indicadores
  // Atualiza IBOVESPA/Bitcoin (tabela indicadores_mercado).
  public function atualizarIndicadores(Request $request): JsonResponse
  {
    return $this->executarComando($request, 'indicadores:atualizar');
  }

  private function executarComando(Request $request, string $comando): JsonResponse
  {
    $secret = config('services.cron_secret');

    if ($secret && $request->bearerToken() !== $secret) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    Artisan::call($comando);

    return response()->json(['output' => Artisan::output()]);
  }
}
