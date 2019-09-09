<?php

declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use Jenssegers\Blade\Blade;
use App\Application\RaceService;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\ErrorHandler;

ini_set('error_reporting', 'E_ALL');

if (getenv('APP_ENV') == 'prod') {
    ini_set('display_errors', 'Off');
    ini_set('display_startup_errors', 'Off');
}

if (getenv('APP_ENV') == 'dev') {
    ini_set('display_errors', 'On');
    ini_set('display_startup_errors', 'On');
}

$logger = new Logger('logger');
$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));
ErrorHandler::register($logger);

set_error_handler(function ($level, $message, $file = '', $line = 0) {
    throw new ErrorException($message, 0, $level, $file, $line);
});

register_shutdown_function(function () use ($logger) {
    $error = error_get_last();

    if ($error != null) {
        $error = (object)$error;
        $logger->log($error->type, $error->message, [$error->file, $error->line]);
    }
});

function url(string $url = '/'): string
{
    if ($url == '/' || $url == '') {
        return '/';
    }

    return getenv('APP_ENV') == 'dev' ? "$url.php" : $url;
}

Dotenv\Dotenv::create(__DIR__)->load();

$blade       = new Blade('../src/Views/Blade/', '../src/Views/Blade/cache/');
$raceService = new RaceService();
