<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\UserRepository;
use App\Domain\Repositories\CarteiraRepositoryInterface;
use App\Infrastructure\Persistence\CarteiraRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }


    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CarteiraRepositoryInterface::class, CarteiraRepository::class);
    }
}
