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
    $secret = config('services.cron_secret');

    if ($secret && $request->bearerToken() !== $secret) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    Artisan::call('cotacoes:atualizar');

    return response()->json(['output' => Artisan::output()]);
  }
}
