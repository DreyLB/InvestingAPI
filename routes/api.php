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

//ROTAS PUBLICAS
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

//ROTAS AUTENTICADAS

// ROTAS AUTENTICADAS
Route::middleware('auth:api')->group(function () {

  // USER
  Route::post('/logout', [UserController::class, 'logout']);
  Route::get('/me', [UserController::class, 'me']);

  // WALLET
  Route::apiResource('/carteiras', CarteiraController::class);

  // ASSETS (ativos dentro de uma carteira)
  Route::apiResource('carteira.ativos', AtivoController::class)
    ->parameters([
      'ativos' => 'ativoId',      // renomeia o parâmetro do ativo
      'carteiras' => 'carteiraId' // renomeia o parâmetro da carteira
    ]);

  Route::apiResource('carteiras.tipo.ativo', AssetTypeController::class)
    ->parameters([
      'tipoativo' => 'tipoAtivoId',      // renomeia o parâmetro do ativo
      'carteiras' => 'carteiraId' // renomeia o parâmetro da carteira
    ]);

  //CATEGORIES
  Route::apiResource('/categorias', CategoriaController::class);

  //TRANSACTIONS
  Route::get('/carteiras/{carteiraId}/transacoes', [TransacaoController::class, 'porCarteira']);

  // Transações de um ativo específico + criar
  Route::get('/carteiras/{carteiraId}/ativos/{ativoId}/transacoes', [TransacaoController::class, 'index']);
  Route::post('/carteiras/{carteiraId}/ativos/{ativoId}/transacoes', [TransacaoController::class, 'store']);
  Route::post('/carteiras/{carteiraId}/comprar', [TransacaoController::class, 'comprar']);

  // Deletar transação
  Route::delete('/carteiras/{carteiraId}/transacoes/{id}', [TransacaoController::class, 'destroy']);

  //DIVIDENDS
  Route::get('/carteiras/{carteiraId}/dividendos', [DividendoController::class, 'porCarteira']);
  Route::get('/carteiras/{carteiraId}/ativos/{ativoId}/dividendos', [DividendoController::class, 'index']);
  Route::post('/carteiras/{carteiraId}/ativos/{ativoId}/dividendos', [DividendoController::class, 'store']);
  Route::delete('/carteiras/{carteiraId}/dividendos/{id}', [DividendoController::class, 'destroy']);

  //RENDIMENTOS
  Route::get('/carteiras/{carteiraId}/rendimentos', [RendimentoController::class, 'index']);
  Route::post('/carteiras/{carteiraId}/rendimentos', [RendimentoController::class, 'store']);
  Route::put('/carteiras/{carteiraId}/rendimentos/{id}', [RendimentoController::class, 'update']);
  Route::delete('/carteiras/{carteiraId}/rendimentos/{id}', [RendimentoController::class, 'destroy']);

  //METAS
  Route::get('/carteiras/{carteiraId}/metas', [MetaController::class, 'index']);
  Route::post('/carteiras/{carteiraId}/metas', [MetaController::class, 'store']);
  Route::put('/carteiras/{carteiraId}/metas/{id}', [MetaController::class, 'update']);
  Route::delete('/carteiras/{carteiraId}/metas/{id}', [MetaController::class, 'destroy']);
});
