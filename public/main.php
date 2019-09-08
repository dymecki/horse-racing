<?php

declare(strict_types = 1);

include_once '../bootstrap.php';

echo $blade->make('main', [
    'canAddNewRace' => $raceService->canAddNewRace(),
    'canProgress'   => $raceService->canProgress(),
    'races'         => $raceService->activeRaces(),
    'bestHorseEver' => $raceService->bestHorseRunEver()
])->render();
