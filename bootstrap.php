<?php

declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use Jenssegers\Blade\Blade;
use App\Application\RaceService;

Dotenv\Dotenv::create(__DIR__)->load();

$blade = new Blade(
    '../src/Views/Blade/',
    '../src/Views/Blade/cache/'
);

$raceService = new RaceService();
