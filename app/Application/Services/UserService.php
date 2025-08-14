<?php

namespace App\Application\Services;

use Illuminate\Support\Facades\Hash;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Entities\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
  private UserRepositoryInterface $userRepository;

  public function __construct(UserRepositoryInterface $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function getAllUsers(): array
  {
    return $this->userRepository->findAll();
  }

  public function getUserById(int $id): ?User
  {
    return $this->userRepository->findById($id);
  }

  public function registerUser(string $name, string $email, string $password): void
  {
    $hashedPassword = Hash::make($password);

    $user = new User($name, $email, $hashedPassword);
    $this->userRepository->save($user);
  }

  public function loginUser(string $email, string $password): array
  {
    $credentials = ['email' => $email, 'password' => $password];

    if (!$token = JWTAuth::attempt($credentials)) {
      throw new \Exception("Credenciais inválidas");
    }

    $user = JWTAuth::user();

    return [
      'token' => $token,
      'user' => [
        'name' => $user->name,
        'email' => $user->email,
      ],
    ];
  }
}
