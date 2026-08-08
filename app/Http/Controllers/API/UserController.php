<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Application\Services\UserService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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
    ], 200)->cookie($this->makeRefreshCookie($token['token']));
  }

  public function refresh()
  {
    $cookieToken = request()->cookie('refresh_token');

    if (!$cookieToken) {
      return response()->json(['error' => 'Sessão não encontrada'], 401);
    }

    try {
      // Seta o token do cookie no request para o guard conseguir validar/renovar
      JWTAuth::setToken($cookieToken);
      $newToken = JWTAuth::refresh();
      $user = JWTAuth::setToken($newToken)->toUser();
    } catch (\Exception $e) {
      return response()->json(['error' => 'Sessão expirada, faça login novamente'], 401);
    }

    return response()->json([
      'token' => $newToken,
      'user' => [
        'name' => $user->name,
        'email' => $user->email,
      ],
    ], 200)->cookie($this->makeRefreshCookie($newToken));
  }

  public function logout()
  {
    try {
      $this->userService->logoutUser();

      $refreshToken = request()->cookie('refresh_token');
      if ($refreshToken) {
        JWTAuth::setToken($refreshToken)->invalidate();
      }

      return response()
        ->json(['message' => 'Logout realizado com sucesso'], 200)
        ->cookie(Cookie::forget('refresh_token'));
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  public function me()
  {
    $user = JWTAuth::user();
    return response()->json(['user' => [
      'name' => $user->name,
      'email' => $user->email,
    ]], 200);
  }

  private function makeRefreshCookie(string $token)
  {
    return cookie(
      name: 'refresh_token',
      value: $token,
      minutes: (int) config('jwt.refresh_ttl'), // <-- cast aqui
      path: '/',
      domain: null,
      secure: false,
      httpOnly: true,
      sameSite: 'lax',
    );
  }
}
