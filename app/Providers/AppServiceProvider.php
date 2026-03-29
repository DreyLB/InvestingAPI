<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\UserRepository;
use App\Domain\Repositories\CarteiraRepositoryInterface;
use App\Infrastructure\Persistence\CarteiraRepository;
use App\Domain\Repositories\AssetTypeRepositoryInterface;
use App\Infrastructure\Persistence\AssetTypeRepository;
use App\Domain\Repositories\CategoriaRepositoryInterface;
use App\Infrastructure\Persistence\CategoriaRepository;

use App\Domain\Repositories\TransacaoRepositoryInterface;
use App\Infrastructure\Persistence\TransacaoRepository;

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
        $this->app->bind(AssetTypeRepositoryInterface::class, AssetTypeRepository::class);
        $this->app->bind(CategoriaRepositoryInterface::class, CategoriaRepository::class);
        $this->app->bind(TransacaoRepositoryInterface::class, TransacaoRepository::class);
    }
}
