<?php

declare(strict_types = 1);

include_once('../bootstrap.php');

echo $blade->make('races.last', [
    'canAddNewRace' => $raceService->canAddNewRace(),
    'canProgress'   => $raceService->canProgress(),
    'races'         => $raceService->getLastRacesBestPositions()
])->render();
