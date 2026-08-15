<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
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
            $text = sprintf(
                "%s: %s in %s:%d\n\n%s\n",
                $e::class,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine(),
                $e->getTraceAsString()
            );

            error_log($text);
            @file_put_contents('/tmp/last_error.txt', $text);

            return false;
        });
    })->create();
