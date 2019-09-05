<?php

declare(strict_types = 1);

include_once('../bootstrap.php');

use App\Application\Services\RaceService;

$raceService = new RaceService();

echo $blade->make('races.last', [
    'canAddNewRace' => $raceService->canAddNewRace(),
    'races'         => $raceService->getLastRacesBestPositions()
])->render();
