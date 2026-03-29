<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CarteiraController;
use App\Http\Controllers\API\AtivoController;
use App\Http\Controllers\API\AssetTypeController;
use App\Http\Controllers\API\CategoriaController;
use App\Http\Controllers\API\TransacaoController;

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

  // Deletar transação
  Route::delete('/carteiras/{carteiraId}/transacoes/{id}', [TransacaoController::class, 'destroy']);
});
