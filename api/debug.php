<?php

header('Content-Type: text/plain');

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

try {
    $httpKernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $request = \Illuminate\Http\Request::create('/up', 'GET');
    $httpKernel->handle($request);

    $router = $app->make(\Illuminate\Routing\Router::class);
    $routes = $router->getRoutes();
    echo "Total de rotas registradas: " . count($routes) . "\n\n";
    foreach ($routes as $route) {
        echo implode('|', $route->methods()) . " " . $route->uri() . "\n";
    }
} catch (\Throwable $e) {
    echo "FAILED: " . get_class($e) . ": " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo $e->getTraceAsString() . "\n";
}
