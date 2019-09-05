<?php

declare(strict_types = 1);

include_once('../bootstrap.php');

use App\Application\Services\RaceService;
use App\Application\Services\HorseService;

$raceService = new RaceService();

echo $blade->make('main', [
    'canAddNewRace' => $raceService->canAddNewRace(),
    'races'         => $raceService->activeRaces(),
    'bestHorseEver' => (new HorseService())->getBestHorseRunEver()
])->render();
