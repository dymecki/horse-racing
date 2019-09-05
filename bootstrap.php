<?php

declare(strict_types = 1);

require_once '../vendor/autoload.php';

use Jenssegers\Blade\Blade;

Dotenv\Dotenv::create(__DIR__)->load();

$blade = new Blade(
    '../src/Views/Blade/',
    '../src/Views/Blade/cache/'
);
