<?php

header('Content-Type: text/plain');

echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? '(unset)') . "\n";
echo "PATH_INFO: " . ($_SERVER['PATH_INFO'] ?? '(unset)') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? '(unset)') . "\n";
echo "SCRIPT_FILENAME: " . ($_SERVER['SCRIPT_FILENAME'] ?? '(unset)') . "\n";
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? '(unset)') . "\n";
echo "QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? '(unset)') . "\n";
echo "\n";

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

try {
    $httpKernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $request = \Illuminate\Http\Request::capture();
    echo "Request::capture() path: " . $request->path() . "\n";
    echo "Request::capture() url: " . $request->url() . "\n";
    $response = $httpKernel->handle($request);
    echo "status=" . $response->getStatusCode() . "\n";
} catch (\Throwable $e) {
    echo "FAILED: " . get_class($e) . ": " . $e->getMessage() . "\n";
}
