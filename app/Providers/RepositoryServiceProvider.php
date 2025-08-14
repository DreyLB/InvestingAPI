<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
  }

  public function boot()
  {
    //
  }
}
