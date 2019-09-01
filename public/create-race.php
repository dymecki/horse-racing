<?php

declare(strict_types = 1);

require_once '../vendor/autoload.php';

use App\Application\Services\RaceService;
use App\Application\Services\HorseService;

$raceService = new RaceService();
$raceService->startNewRace();

//$horseService = new HorseService();
//$horseService->adNewHorse();

header('Location: /');
exit();
