<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CarteiraController;
use App\Http\Controllers\API\AtivoController;

//ROTAS PUBLICAS
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

//ROTAS AUTENTICADAS

// ROTAS AUTENTICADAS
Route::middleware('auth:api')->group(function () {

  // USER
  Route::post('/logout', [UserController::class, 'logout']);

  // WALLET
  Route::apiResource('/carteiras', CarteiraController::class);

  // ASSETS (ativos dentro de uma carteira)
  Route::apiResource('carteiras.ativos', AtivoController::class)
    ->parameters([
      'ativos' => 'ativoId',      // renomeia o parâmetro do ativo
      'carteiras' => 'carteiraId' // renomeia o parâmetro da carteira
    ]);
});
