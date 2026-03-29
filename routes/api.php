<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CarteiraController;
use App\Http\Controllers\API\AtivoController;
use App\Http\Controllers\API\AssetTypeController;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\TransacaoController;
use App\Http\Controllers\API\DividendoController;
use App\Http\Controllers\API\RendimentoController;
use App\Http\Controllers\API\MetaController;
use App\Http\Controllers\API\AlertaController;

// ROTAS PÚBLICAS
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// ROTAS AUTENTICADAS
Route::middleware('auth:api')->group(function () {

  // USER
  Route::post('/logout', [UserController::class, 'logout']);
  Route::get('/me', [UserController::class, 'me']);

  // CARTEIRAS
  Route::apiResource('carteiras', CarteiraController::class);

  // ATIVOS (aninhado em carteiras)
  Route::apiResource('carteiras.ativos', AtivoController::class)
    ->parameters([
      'ativos'    => 'ativoId',
      'carteiras' => 'carteiraId',
    ]);

  // TIPO DE ATIVO (aninhado em carteiras)
  Route::apiResource('carteiras.tipo.ativo', AssetTypeController::class)
    ->parameters([
      'ativo'     => 'tipoAtivoId',
      'carteiras' => 'carteiraId',
    ]);

  // CATEGORIAS
  Route::apiResource('categorias', CategoriaController::class);

  // TRANSAÇÕES
  Route::apiResource('carteiras.ativos.transacoes', TransacaoController::class)
    ->parameters([
      'carteiras'  => 'carteiraId',
      'ativos'     => 'ativoId',
      'transacoes' => 'id',
    ])
    ->except(['show', 'update']);

  // Rota extra: todas as transações de uma carteira (sem ativo específico)
  Route::get('carteiras/{carteiraId}/transacoes', [TransacaoController::class, 'porCarteira']);

  // Rota extra: comprar ativo
  Route::post('carteiras/{carteiraId}/comprar', [TransacaoController::class, 'comprar']);

  // DIVIDENDOS
  Route::apiResource('carteiras.ativos.dividendos', DividendoController::class)
    ->parameters([
      'carteiras' => 'carteiraId',
      'ativos'    => 'ativoId',
      'dividendos' => 'id',
    ])
    ->except(['show', 'update']);

  // Rota extra: todos os dividendos de uma carteira (sem ativo específico)
  Route::get('carteiras/{carteiraId}/dividendos', [DividendoController::class, 'porCarteira']);

  // RENDIMENTOS
  Route::apiResource('carteiras.rendimentos', RendimentoController::class)
    ->parameters([
      'carteiras'   => 'carteiraId',
      'rendimentos' => 'id',
    ])
    ->except(['show']);

  // METAS
  Route::apiResource('carteiras.metas', MetaController::class)
    ->parameters([
      'carteiras' => 'carteiraId',
      'metas'     => 'id',
    ])
    ->except(['show']);

  // ALERTAS
  Route::apiResource('carteiras.alertas', AlertaController::class)
    ->parameters([
      'carteiras' => 'carteiraId',
      'alertas'   => 'id',
    ])
    ->except(['show', 'update']);

  // Rota extra: marcar alerta como lido (fora do padrão REST)
  Route::patch('carteiras/{carteiraId}/alertas/{id}/lido', [AlertaController::class, 'marcarComoLido']);
});
