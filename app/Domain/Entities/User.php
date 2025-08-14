<?php

//Aqui sempre será adicionado as informações basicas da entidade, que nesse caso é usuário

namespace App\Domain\Entities;

class User
{
  private ?int $id = null;
  private string $name;
  private string $email;
  private string $password;
  private float $balance = 0.0;
  private int $age = 0;
  private string $investorProfile = '';

  public function __construct(
    string $name,
    string $email,
    string $password,
  ) {
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
  }

  // --- Getters ---

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function getBalance(): float
  {
    return $this->balance;
  }

  public function getAge(): int
  {
    return $this->age;
  }

  public function getInvestorProfile(): string
  {
    return $this->investorProfile;
  }

  // --- Setters ---

  /* public function setId(int $id): void
  {
    $this->id = $id;
  } */

  public function setName(string $name): void
  {
    $this->name = $name;
  }

  public function setEmail(string $email): void
  {
    $this->email = $email;
  }

  public function setPassword(string $password): void
  {
    $this->password = $password;
  }

  public function setBalance(float $balance): void
  {
    $this->balance = $balance;
  }

  public function setAge(int $age): void
  {
    $this->age = $age;
  }

  public function setInvestorProfile(string $investorProfile): void
  {
    $this->investorProfile = $investorProfile;
  }
}
