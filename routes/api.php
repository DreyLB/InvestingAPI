<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CarteiraController;
use App\Http\Controllers\API\AtivoController;
use App\Http\Controllers\API\PosicaoController;
use App\Http\Controllers\API\TransacaoController;
use App\Http\Controllers\API\DividendoController;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\AssetTypeController;
use App\Http\Controllers\API\AlertaController;
use App\Http\Controllers\API\MetaController;
use App\Http\Controllers\API\RendimentoController;

// ROTAS PÚBLICAS
Route::post('/register', [UserController::class, 'register']);
Route::post('/login',    [UserController::class, 'login']);

// Catálogo global de ativos — público para autocomplete no frontend
Route::get('/ativos', [AtivoController::class, 'index']);
Route::get('/asset-types', [AssetTypeController::class, 'index']);

// ROTAS AUTENTICADAS
Route::middleware('auth:api')->group(function () {

  // USER
  Route::post('/logout', [UserController::class, 'logout']);
  Route::get('/me',      [UserController::class, 'me']);

  // CARTEIRAS
  Route::apiResource('/carteiras', CarteiraController::class);

  // POSIÇÕES (portfolio atual)
  Route::get('/carteiras/{carteiraId}/posicoes', [PosicaoController::class, 'index']);

  // TRANSAÇÕES
  Route::get('/carteiras/{carteiraId}/transacoes',        [TransacaoController::class, 'index']);
  Route::post('/carteiras/{carteiraId}/comprar',          [TransacaoController::class, 'comprar']);
  Route::post('/carteiras/{carteiraId}/vender',           [TransacaoController::class, 'vender']);
  Route::delete('/carteiras/{carteiraId}/transacoes/{id}', [TransacaoController::class, 'destroy']);

  // DIVIDENDOS
  Route::get('/carteiras/{carteiraId}/dividendos',                              [DividendoController::class, 'porCarteira']);
  Route::get('/carteiras/{carteiraId}/ativos/{ativoId}/dividendos',             [DividendoController::class, 'index']);
  Route::post('/carteiras/{carteiraId}/ativos/{ativoId}/dividendos',            [DividendoController::class, 'store']);
  Route::delete('/carteiras/{carteiraId}/dividendos/{id}',                      [DividendoController::class, 'destroy']);

  // METAS
  Route::get('/carteiras/{carteiraId}/metas',        [MetaController::class, 'index']);
  Route::post('/carteiras/{carteiraId}/metas',       [MetaController::class, 'store']);
  Route::put('/carteiras/{carteiraId}/metas/{id}',   [MetaController::class, 'update']);
  Route::delete('/carteiras/{carteiraId}/metas/{id}', [MetaController::class, 'destroy']);

  // ALERTAS
  Route::get('/carteiras/{carteiraId}/alertas',                [AlertaController::class, 'index']);
  Route::post('/carteiras/{carteiraId}/alertas',               [AlertaController::class, 'store']);
  Route::patch('/carteiras/{carteiraId}/alertas/{id}/lido',    [AlertaController::class, 'marcarComoLido']);
  Route::delete('/carteiras/{carteiraId}/alertas/{id}',        [AlertaController::class, 'destroy']);

  // RENDIMENTOS
  Route::get('/carteiras/{carteiraId}/rendimentos',         [RendimentoController::class, 'index']);
  Route::post('/carteiras/{carteiraId}/rendimentos',        [RendimentoController::class, 'store']);
  Route::put('/carteiras/{carteiraId}/rendimentos/{id}',    [RendimentoController::class, 'update']);
  Route::delete('/carteiras/{carteiraId}/rendimentos/{id}', [RendimentoController::class, 'destroy']);

  // CATEGORIAS
  Route::apiResource('/categorias', CategoriaController::class);
});
