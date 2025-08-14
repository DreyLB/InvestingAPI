<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CarteiraController;

//ROTAS PUBLICAS
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

//ROTAS AUTENTICADAS

//USER
Route::post('/logout', [UserController::class, 'logout']);

//WALLET
Route::apiResource('/carteiras', CarteiraController::class)->middleware('auth:api');
