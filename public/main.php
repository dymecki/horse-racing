<?php

declare(strict_types = 1);

include_once('../bootstrap.php');

use App\Application\Services\HorseService;

echo $blade->make('main', [
    'canAddNewRace' => $raceService->canAddNewRace(),
    'canProgress'   => $raceService->canProgress(),
    'races'         => $raceService->activeRaces(),
    'bestHorseEver' => (new HorseService())->getBestHorseRunEver()
])->render();
