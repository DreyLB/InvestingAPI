<?php

header('Content-Type: text/plain');

echo "PHP: " . PHP_VERSION . "\n";
echo "PDO drivers: " . implode(',', PDO::getAvailableDrivers()) . "\n";
echo "LOG_CHANNEL env: " . (getenv('LOG_CHANNEL') ?: '(unset)') . "\n";
echo "DB_CONNECTION env: " . (getenv('DB_CONNECTION') ?: '(unset)') . "\n";
echo "DB_HOST env: " . (getenv('DB_HOST') ?: '(unset)') . "\n";
echo "APP_KEY set: " . (getenv('APP_KEY') ? 'yes' : 'no') . "\n";
echo "\n";

$stderr = @fopen('php://stderr', 'a');
echo "fopen php://stderr: " . ($stderr ? 'ok' : 'FAILED') . "\n";
if ($stderr) {
    $wrote = @fwrite($stderr, "debug test\n");
    echo "fwrite php://stderr: " . ($wrote !== false ? 'ok' : 'FAILED') . "\n";
    fclose($stderr);
}
echo "\n";

try {
    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s;sslmode=%s',
        getenv('DB_HOST'),
        getenv('DB_PORT'),
        getenv('DB_DATABASE'),
        getenv('DB_SSLMODE') ?: 'prefer'
    );
    $pdo = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    echo "PDO pgsql connect: ok\n";
} catch (\Throwable $e) {
    echo "PDO pgsql connect FAILED: " . get_class($e) . ": " . $e->getMessage() . "\n";
}
echo "\n";

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require __DIR__ . '/../bootstrap/app.php';
    echo "Laravel bootstrap: ok\n";

    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    echo "Console kernel resolved: ok\n";
} catch (\Throwable $e) {
    echo "Laravel bootstrap FAILED: " . get_class($e) . ": " . $e->getMessage() . "\n";
    echo "at " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo $e->getTraceAsString() . "\n";
}
