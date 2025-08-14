<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\Models\UserModel;

class UserRepository implements UserRepositoryInterface
{
  public function findById(int $id): ?User
  {
    $model = UserModel::find($id);
    if (!$model) {
      return null;
    }
    return $this->toEntity($model);
  }

  public function findByEmail(string $email): ?User
  {
    $model = UserModel::where('email', $email)->first();
    if (!$model) {
      return null;
    }
    return $this->toEntity($model);
  }

  public function findAll(): array
  {
    return UserModel::all()->map(fn($model) => $this->toEntity($model))->toArray();
  }

  public function save(User $user): void
  {
    $model = $user->getId() ? UserModel::find($user->getId()) : new UserModel();
    $model->name = $user->getName();
    $model->email = $user->getEmail();
    $model->password = $user->getPassword();
    $model->balance = $user->getBalance();
    $model->age = $user->getAge();
    $model->investorProfile = $user->getInvestorProfile();
    $model->save();
  }

  public function delete(int $id): void
  {
    UserModel::destroy($id);
  }

  private function toEntity(UserModel $model): User
  {
    return new User(
      $model->name,
      $model->email,
      $model->password,
      $model->balance,
      $model->age,
      $model->investorProfile
    );
  }
}
