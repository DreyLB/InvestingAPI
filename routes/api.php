<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CarteiraController;
use App\Http\Controllers\API\AtivoController;

//ROTAS PUBLICAS
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

//ROTAS AUTENTICADAS

//USER
Route::post('/logout', [UserController::class, 'logout']);

//WALLET
Route::apiResource('/carteiras', CarteiraController::class)->middleware('auth:api');

//ASSETS

Route::middleware('auth:api')->group(function () {
  // Assets (sempre dentro de uma carteira)
  Route::get('/carteiras/{wallet}/ativos', [AtivoController::class, 'index']);
  Route::post('/carteiras/{wallet}/ativos', [AtivoController::class, 'store']);
  Route::get('/carteiras/{wallet}/ativos/{ativo}', [AtivoController::class, 'show']);
  Route::put('/carteiras/{wallet}/ativos/{ativo}', [AtivoController::class, 'update']);
  Route::delete('/carteiras/{wallet}/ativos/{ativo}', [AtivoController::class, 'destroy']);
});
