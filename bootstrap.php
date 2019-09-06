<?php

declare(strict_types = 1);

require_once '../vendor/autoload.php';

use Jenssegers\Blade\Blade;
use App\Application\Services\RaceService;

Dotenv\Dotenv::create(__DIR__)->load();

$blade = new Blade(
    '../src/Views/Blade/',
    '../src/Views/Blade/cache/'
);

$raceService = new RaceService();
