<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Application\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
  protected UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
      'email' => 'required|email',
      'password' => 'required|string|min:6',
    ]);

    $this->userService->registerUser(
      $request->input('name'),
      $request->input('email'),
      $request->input('password')
    );

    return response()->json(['message' => 'Usuário criado com sucesso'], 201);
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|string|min:6',
    ]);

    try {
      $token = $this->userService->loginUser(
        $request->input('email'),
        $request->input('password')
      );
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 401);
    }

    return response()->json([
      'message' => 'Login realizado com sucesso',
      'token' => $token
    ], 200);
  }
}
