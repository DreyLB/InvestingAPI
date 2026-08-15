<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        // Na Vercel, o entry-point roda em /api/index.php (exigência da
        // plataforma), e o runtime vercel-php calcula o PATH_INFO removendo
        // esse prefixo "/api" do path recebido — colidindo com o prefixo
        // "api" que o Laravel adiciona por padrão às rotas de API. Sem essa
        // env var (ambiente local via Docker/nginx), o prefixo padrão "api"
        // é mantido normalmente.
        apiPrefix: env('API_PREFIX', 'api'),
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Em serverless (Vercel), o pipeline padrão de log do Laravel pode
        // cair no logger de emergência hardcoded do framework, que escreve
        // em storage/logs — inexistente/read-only nesse ambiente. Reportamos
        // via error_log() nativo do PHP (aparece nos Runtime Logs da Vercel)
        // e pulamos o pipeline padrão retornando false.
        $exceptions->reportable(function (\Throwable $e) {
            error_log(sprintf(
                '%s: %s in %s:%d',
                $e::class,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            return false;
        });
    })->create();
