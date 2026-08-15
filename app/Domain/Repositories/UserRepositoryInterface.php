<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function findAll(): array;
    public function save(User $user): int;
    public function delete(int $id): void;
}
